<?php

namespace App\Http\Controllers;

use App\Models\Ranking_user;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Ranking_usersController extends Controller
{

    public function create(Request $request)
    {
        try{
            
            DB::beginTransaction();
            $request->validate([
                'ranking_id' => 'required',
                'student_id' => 'required',
                'puntuation' => '',
            ]);

            $ranking_users = DB::select('SELECT * 
                                        FROM students
                                        WHERE ranking_id = ?
                                        AND student_id = ?',
            [$request->ranking_id, $request->student_id]);

            $user = new Ranking_user();
            $user->ranking_id = $request->ranking_id;
            $user->student_id = $request->student_id;
            $user->puntuation = 0;
            $user->save();
            DB::commit();

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

    public function index($id){

        try{
            
            $ranking_users = DB::select('SELECT * 
                                        FROM students s
                                        JOIN ranking_users r
                                        WHERE s.id = r.student_id
                                        AND r.ranking_id = ?
                                        ORDER BY puntuation DESC',

            [$id]);

            if ($ranking_users == null) {abort(500);}

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
    
    public function joinRanking(Request $request){

        try{
            
            DB::beginTransaction();
            $request->validate([
                'code' => 'required',
                'student_id' => 'required',
            ]);

            $cond1 = DB::select('SELECT * FROM rankings WHERE code = ?', [$request->code]);

            $cond2 = DB::select('SELECT * 
                                        FROM ranking_users
                                        WHERE ranking_id = ?
                                        AND student_id = ?',
            [$cond1[0]->id, $request->student_id]);

            if($cond1 == null || $cond2 != null) {abort(500);}

            $user = new Ranking_user();
            $user->ranking_id = $cond1[0]->id;
            $user->student_id = $request->student_id;
            $user->puntuation = 0;
            $user->save();
            DB::commit();

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
