<?php

namespace App\Http\Controllers;

use App\Models\Ranking_user;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ranking_usersController extends Controller
{

    public function index($id){ // Devuelve los usuarios del ranking deseado

        try{
            
            $ranking_users = DB::select('SELECT * 
                                        FROM students s
                                        JOIN ranking_users r
                                        WHERE s.id = r.student_id
                                        AND r.ranking_id = ?
                                        ORDER BY puntuation DESC',

            [$id]);

            if ($ranking_users == null) {abort(500);} // Devuelve error si el ranking no existe

            return response()->json([
                "status" => 1,
                "data" => $ranking_users,
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha encontrado! + $e",
            ]);
        }
    }

    public function update(Request $request) { // Actualiza un estudiante

        try{
            
            DB::beginTransaction();
            $request->validate([
                'ranking_id' => 'required',
                'student_id' => 'required',
                'puntuation' => 'required',
            ]);
            
            DB::update('update ranking_users set puntuation = ? WHERE ranking_id = ? AND student_id = ?',
            [$request->puntuation, $request->ranking_id, $request->student_id]);
            DB::commit();            
            
            $user = DB::select('select * FROM students WHERE email = ? OR nick = ?', [$request->email, $request->nick]);
            
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
}
