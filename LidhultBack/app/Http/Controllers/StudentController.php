<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            
            if(Professor::where('email', '=', $request->email)->exists()
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

            $user = DB::select('select * FROM students WHERE email = ? OR nick = ?',
            [$student->email, $student->nick]);
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

            $student = Student::findOrFail($request->id);
            $student = DB::table('students')->where('id', $request->id)->first();
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
                'avatar' => 'required',
                'birth_date' => 'required',
            ]);

            $password = Hash::make($request->password);

            if(Professor::where('email', '=', $request->email)->exists()
            || Professor::where('nick', '=', $request->nick)->exists()) {

                abort(500);
            }

            $imageName = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move('images/custom', $imageName);

            DB::update('update students set name = ?, surnames = ?, email = ?, nick = ?, password = ?, avatar = ?, birth_date = ? WHERE id = ?',
            [$request->name, $request->surnames, $request->email, $request->nick, $password, $request->avatar, $request->birth_date, $request->id]);
            DB::commit();
            
            $user = DB::select('select * FROM students WHERE email = ? OR nick = ?',
                [$request->email, $request->nick]);
            
            return response()->json([
                "status" => 1,
                "msg" => "Se ha actualizado!",
                "data" => $user
            ]);

        } catch (Exception $e) {

            $user = DB::select('select * FROM students WHERE email = ? OR nick = ?',
                [$request->email, $request->nick]);

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido actualizar! + $e",
                "data" => $user

            ]);
        }    
        
    }

    public function avatar(Request $request) {

        try{

            DB::beginTransaction();
            $request->validate([
                'dato' => 'required',
                'avatar' => 'required',
            ]);

            DB::update('update students set avatar = ? WHERE email = ? OR nick = ?',
            [$request->avatar, $request->dato, $request->dato]);
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

    public function character(Request $request) {

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