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

            if ($ranking_users == null) {abort(500);} // Devuelve error si no existen usuarios en el ranking

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
    
    public function requestRanking(Request $request){ // Verifica al usuario para unirse a un ranking

        try{
            
            DB::beginTransaction();
            $request->validate([
                'code' => 'required',
                'student_id' => 'required',
            ]);

            $cond1 = DB::select('SELECT * FROM rankings WHERE code = ?', [$request->code]); // Verifica el código

            $cond2 = DB::select('SELECT * 
                                FROM ranking_users
                                WHERE ranking_id = ?
                                AND student_id = ?',
            [$cond1[0]->id, $request->student_id]); // Verifica si el estudiante ya existe en ese ranking

            if($cond1 == null || $cond2 != null) {abort(500);} // Si se cumplen las condiciones devuelve error

            $student = DB::select('SELECT *
                                    FROM students
                                    WHERE id = ?',
            [$request->student_id]);

            $professor = DB::select('SELECT *
                                    FROM professors
                                    WHERE id = (SELECT professor_id 
                                    FROM rankings 
                                    WHERE code = ?)',
            [$request->code]);




            // Arreglar




            $nicks = new Request();
            $nicks->sender = $student[0]->nick;
            $nicks->receiver = $professor[0]->nick;

            $user = (new MessageController)->createRequest($nicks);

            return response()->json([
                "status" => 1,
                "msg" => "Se ha enviado la solicitud!",
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
