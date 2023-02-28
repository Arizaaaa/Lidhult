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

                $ranking->code = mt_rand(10000000, 99999999);

                $user = DB::select('select code FROM rankings WHERE code = ?',
                [$ranking->code]);
                
            } while ($user != null);

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
        try{

            $request->validate([    
                'id' => '',
                'name' => '',
                'surnames' => '',
                'email' => '',
                'nick' => '',
                'birth_date' => '',
            ]);

            $student = Ranking::findOrFail($request->id);
            $student = DB::select('select * FROM rankings WHERE id = ? OR name = ? OR surnames = ? OR email = ? OR nick = ? OR birth_date = ?',
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
