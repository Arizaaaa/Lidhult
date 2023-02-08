<?php

namespace App\Http\Controllers;

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
            $student = new Student();
            $student->name = $request->name;
            $student->surnames = $request->surnames;
            $student->email = $request->email;
            $student->nick = $request->nick;
            $student->password = Hash::make($request->password);
            $student->birth_date = $request->birth_date;
            $student->save();
            DB::commit();

            return response()->json([
                "status" => 1,
                "msg" => "Se ha insertado!",
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 1,
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

            $student = Student::find($request->id);
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
                "status" => 1,
                "msg" => "No se ha podido eliminar! + $e",
            ]);
        }       

    }

    public function update(Request $request) { // Actualiza un estudiante

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

            DB::update('update students set name = ?, surnames = ?, email = ?, nick = ?, password = ?, birth_date = ? WHERE id = ?',
            [$request->name, $request->surnames, $request->email, $request->nick, Hash::make($request->password), $request->birth_date, $request->id]);
            DB::commit();
            
            return response()->json([
                "status" => 1,
                "msg" => "Se ha actualizado!",
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 1,
                "msg" => "No se ha podido actualizar! + $e",
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
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => 1,
                "msg" => "No se ha encontrado! + $e",
            ]);

        }
    }
}
