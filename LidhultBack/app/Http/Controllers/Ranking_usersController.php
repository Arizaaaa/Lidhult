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
}
