<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfessorController extends Controller
{
    public function create(Request $request) { // Crea un profesor

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

            if(Student::where('email', '=', $request->email)->exists()
            || Student::where('nick', '=', $request->nick)->exists()) {

                abort(500);
            }

            $professor = new Professor();
            $professor->name = $request->name;
            $professor->surnames = $request->surnames;
            $professor->email = $request->email;
            $professor->nick = $request->nick;
            $professor->password = Hash::make($request->password);
            $professor->center = $request->birth_date;
            $professor->save();
            DB::commit();

            $user = DB::select('select * FROM professors WHERE email = ? OR nick = ?',
                [$professor->email, $professor->nick]);

            return response()->json([
                "status" => 1,
                "msg" => "Se ha insertado!",
                "data" => $user
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido insertar! + $e",
            ]);
        }

    }

    public function delete(Request $request) { // Borra un profesor

        try{
            
            DB::beginTransaction();
            $request->validate([
                'id' => 'required',
            ]);

            $professor = Professor::findOrFail($request->id);
            $professor = DB::table('professors')->where('id', $request->id)->first();
            DB::table('professors')->where('id', $request->id)->delete();
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

    public function update(Request $request) { // Actualiza un profesor

        try{
            
            DB::beginTransaction();
            $request->validate([
                'id' => 'required',
                'name' => 'required',
                'surnames' => 'required',
                'email' => 'required',
                'nick' => 'required',
                'password' => 'required',
                'avatar' => 'required',
                'center' => 'required',
            ]);

            $password = Hash::make($request->password);

            if(Student::where('email', '=', $request->email)->exists()
            || Student::where('nick', '=', $request->nick)->exists()) {

                abort(500);
            }

            if($request->avatar == "") {

                DB::update('update professors set name = ?, surnames = ?, email = ?, nick = ?, password = ?, center = ? WHERE id = ?',
                [$request->name, $request->surnames, $request->email, $request->nick, $password, $request->center, $request->id]);
                DB::commit();
            } else {

                // Obtener el contenido de la imagen en base64 desde la solicitud
                $base64_image = $request->avatar;

                // Decodificar el contenido de la imagen en base64
                $decoded_image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_image));

                // Generar un nombre de archivo único
                $filename = uniqid() . '.webp';

                // Guardar el archivo en la carpeta "public/images"
                $path = storage_path('../public/images/custom/' . $filename);
                file_put_contents($path, $decoded_image);

                DB::update('update professors set name = ?, surnames = ?, email = ?, nick = ?, password = ?, avatar = ?, center = ? WHERE id = ?',
                [$request->name, $request->surnames, $request->email, $request->nick, $password, $filename, $request->center, $request->id]);
                DB::commit();
            }

            $user = DB::select('select * FROM professors WHERE email = ? OR nick = ?',
                [$request->email, $request->nick]);
            
            return response()->json([
                "status" => 1,
                "msg" => "Se ha actualizado!",
                "data" => $user
            ]);

        } catch (Exception $e) {

            $user = DB::select('select * FROM professors WHERE email = ? OR nick = ?',
                [$request->email, $request->nick]);

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido actualizar! + $e",
                "data" => $user
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

            DB::update('update professors set character_id = ? WHERE email = ? OR nick = ?',
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

    public function read(Request $request) { // Lee un profesor

        try{

            $request->validate([
                'id' => '',
                'name' => '',
                'surnames' => '',
                'email' => '',
                'nick' => '',
                'center' => '',
            ]);

            $professor = Professor::findOrFail($request->id);
            $professor = DB::select('select * FROM professors WHERE id = ? OR name = ? OR surnames = ? OR email = ? OR nick = ? OR center = ?',
            [$request->id, $request->name, $request->surnames, $request->email, $request->nick, $request->center]);

            return $professor;

            return response()->json([
                "status" => 1,
                "msg" => "Vista exitosa!",
                "data" => $professor,
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => 0,
                "msg" => "No se ha encontrado! + $e",
            ]);

        }
    }
}