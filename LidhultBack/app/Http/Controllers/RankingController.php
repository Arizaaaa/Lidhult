<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RankingController extends Controller
{
    
    public function create(Request $request) { // Crea un ranking

        try{
            
            DB::beginTransaction();
            $request->validate([
                'professor_id' => 'required',
                'name' => 'required',
                'code' => '',
            ]);

            $ranking = new Ranking();
            $ranking->professor_id = $request->professor_id;
            $ranking->name = $request->name;

            do{

                $ranking->code = mt_rand(10000000, 99999999); // Crea un numero de 8 cifras aleatorio

                $user = DB::select('select code FROM rankings WHERE code = ?',
                [$ranking->code]);
                
            } while ($user != null); // Se repite si el número esta duplicado en la base de datos

            $ranking->save();
            DB::commit();

            return response()->json([
                "status" => 1,
                "msg" => "Se ha insertado!",
                "data" => $ranking,
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido insertar! + $e",
            ]);
        }
    }

    public function show($id)
    {
        try{

            $ranking = DB::select('SELECT *
                                FROM rankings r
                                JOIN ranking_users u
                                WHERE r.id = u.ranking_id
                                AND u.student_id = ?',
            [$id]);

            if($ranking == null) {abort(500);}

            return response()->json([
                "status" => 1,
                "msg" => "Vista exitosa!",
                "data" => $ranking,
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => 0,
                "msg" => "No se ha encontrado! + $e",
            ]);

        }
    }
    
    public function newCode($id) { // Actualiza el código del ranking

        $ranking = Ranking::findOrFail($id);
        $ranking = DB::select('select * FROM rankings WHERE id = ?', [$id]);

        do{

            $ranking[0]->code = mt_rand(10000000, 99999999); // Crea un numero de 8 cifras aleatorio

            $user = DB::select('select code FROM rankings WHERE code = ?', [$ranking[0]->code]);
            
        } while ($user != null); // Se repite si el número esta duplicado en la base de datos

    }
}
