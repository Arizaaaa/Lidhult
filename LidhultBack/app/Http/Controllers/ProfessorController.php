<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'center' => 'required',
            ]);
            $professor = new Professor();
            $professor->name = $request->name;
            $professor->surnames = $request->surnames;
            $professor->email = $request->email;
            $professor->nick = $request->nick;
            $professor->password = $request->password;
            $professor->center = $request->center;
            $professor->save();
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

    public function delete(Request $request) { // Borra un profesor

        try{
            
            DB::beginTransaction();
            $request->validate([
                'id' => 'required',
            ]);

            $professor = Professor::find($request->id);
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
                "status" => 1,
                "msg" => "No se ha podido eliminar! + $e",
            ]);
        }       

    }

    public function update(Request $request) { // Actualiza un profesor

        try{
            
            DB::beginTransaction();
            $request->validate([
                'name' => 'required',
                'surnames' => 'required',
                'email' => 'required',
                'nick' => 'required',
                'password' => 'required',
                'center' => 'required',
            ]);

            DB::update('update professors set name = ?, surnames = ?, email = ?, nick = ?, password = ?, center = ? WHERE id = ?',
            [$request->name, $request->surnames, $request->email, $request->nick, $request->password, $request->center, $request->id]);
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
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => 1,
                "msg" => "No se ha encontrado! + $e",
            ]);

        }
    }
}