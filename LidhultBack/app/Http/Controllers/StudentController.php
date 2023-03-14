<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Student;
use Exception;
use finfo;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function create(Request $request) { // Crea un estudiante

        try{
            
            DB::beginTransaction();
            $request->validate([
                'name' => 'required',
                'surnames' => 'required',
                'email' => 'required',
                'nick' => 'required',
                'password' => 'required',
                'birth_date' => 'required',
            ]);
            
            if(Professor::where('email', '=', $request->email)->exists() // Verifica que el email o nick no lo use un profesor
            || Professor::where('nick', '=', $request->nick)->exists()) {

                abort(500);
            }

            $student = new Student();
            $student->name = $request->name;
            $student->surnames = $request->surnames;
            $student->email = $request->email;
            $student->nick = $request->nick;
            $student->password = Hash::make($request->password);
            $student->birth_date = $request->birth_date;
            $student->save();
            DB::commit();

            $user = DB::select('select * from professors where nick = ?', [$request->nick]);

            return response()->json([
                "status" => 1,
                "msg" => "Se ha insertado!",
                "data" => $user,
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido insertar! + $e",
            ]);
        }
    }

    public function delete(Request $request) { // Borra un estudiante

        try{
            
            DB::beginTransaction();
            $request->validate([
                'id' => 'required',
            ]);

            $student = Student::findOrFail($request->id); // Verifica que el estudiante exista
            DB::table('students')->where('id', $request->id)->delete();
            DB::commit();

            return response()->json([
                "status" => 1,
                "msg" => "Se ha eliminado!",
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido eliminar! + $e",
            ]);
        }       

    }

    public function update(Request $request) { // Actualiza un estudiante

        try{
            
            DB::beginTransaction();
            $request->validate([
                'id' => 'required',
                'name' => 'required',
                'surnames' => 'required',
                'email' => 'required',
                'nick' => 'required',
                'password' => 'required',
                'avatar' => '',
                'birth_date' => 'required',
            ]);

            $password = Hash::make($request->password); // Encripta la contraseña

            if(Professor::where('email', '=', $request->email)->exists() // Verifica que el email o nick no lo use un profesor
            || Professor::where('nick', '=', $request->nick)->exists()) {

                abort(500);
            }
            
            if($request->avatar == "") { // Si el avatar no se actualiza
            
                DB::update('update students set name = ?, surnames = ?, email = ?, nick = ?, password = ?, birth_date = ? WHERE id = ?',
                [$request->name, $request->surnames, $request->email, $request->nick, $password, $request->birth_date, $request->id]);
                DB::commit();
            } else { // Si el avatar se actualiza

                // Obtener el contenido de la imagen en base64 desde la solicitud
                $base64_image = $request->avatar;

                // Decodificar el contenido de la imagen en base64
                $decoded_image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image));

                // Generar un nombre de archivo único
                $filename = uniqid() . '.webp';

                // Guardar el archivo en la carpeta "public/images"
                $path = storage_path('../public/images/custom/' . $filename);
                file_put_contents($path, $decoded_image);

                DB::update('update students set name = ?, surnames = ?, email = ?, nick = ?, password = ?, avatar = ?, birth_date = ? WHERE id = ?',
                [$request->name, $request->surnames, $request->email, $request->nick, $password, $filename, $request->birth_date, $request->id]);
                DB::commit();
            }
            
            
            $user = DB::select('select * FROM students WHERE email = ? OR nick = ?',
                [$request->email, $request->nick]);
            
            return response()->json([
                "status" => 1,
                "msg" => "Se ha actualizado!",
                "data" => $user
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido actualizar! + $e",
            ]);
        }    
        
    }

    public function puntuation(Request $request) { // Actualiza los puntos totales del estudiante y el nivel de personaje

        try{

            DB::beginTransaction();
            $request->validate([
                'id' => 'required',
            ]);

            $puntuation = DB::select('SELECT puntuation FROM ranking_users WHERE student_id = ?', [$request->id]); // Selecciona todos los puntos

            $total = 0;

            for ($i = 0; $i < count($puntuation); $i++) { $total += $puntuation[$i]->puntuation; } // Sua todos los puntos

            $character = DB::select('SELECT c.name
                                    FROM characters c
                                    JOIN students s
                                    WHERE s.character_id = c.id
                                    AND s.id = ?',
            [$request->id]); // Selecciona el nombre del personaje del estudiante

            if($total > 4000) {$lvl = 5;} // Determina el nivel según los puntos totales del estudiate
            else if($total > 3000) {$lvl = 4;}
            else if($total > 2000) {$lvl = 3;}
            else if($total > 1000) {$lvl = 2;}
            else {$lvl = 1;}

            $newCharacter = DB::select('SELECT id 
                                        FROM characters
                                        WHERE name = ?
                                        AND level = ?',
            [$character[0]->name, $lvl]); // Selecciona el id del personaje actualizado por los puntos

            DB::update('update students set total_puntuation = ?, character_id = ? WHERE id = ?',
            [$total, $newCharacter[0]->id, $request->id]); // Actualiza el estudiante
            DB::commit();

            return response()->json([
                "status" => 1,
                "msg" => "Se ha actualizado!"
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido actualizar! + $e"
            ]);

        }

    }

    public function character(Request $request) { // Actualiza el personaje

        try{

            DB::beginTransaction();
            $request->validate([
                'dato' => 'required',
                'character' => 'required',
            ]);

            DB::update('update students set character_id = ? WHERE email = ? OR nick = ?',
            [$request->character, $request->dato, $request->dato]);
            DB::commit();

            return response()->json([
                "status" => 1,
                "msg" => "Se ha actualizado!",
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => 1,
                "msg" => "No se ha podido actualizar + $e!",
            ]);

        }

    }

    public function read(Request $request) { // Lee un estudiante

        try{

            $request->validate([    
                'id' => '',
                'name' => '',
                'surnames' => '',
                'email' => '',
                'nick' => '',
                'birth_date' => '',
            ]);

            $student = Student::findOrFail($request->id);
            $student = DB::select('select * FROM students WHERE id = ? OR name = ? OR surnames = ? OR email = ? OR nick = ? OR birth_date = ?',
            [$request->id, $request->name, $request->surnames, $request->email, $request->nick, $request->birth_date]);

            return $student;

            return response()->json([
                "status" => 1,
                "msg" => "Vista exitosa!",
                "data" => $student,
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => 0,
                "msg" => "No se ha encontrado! + $e",
            ]);

        }
    }
}