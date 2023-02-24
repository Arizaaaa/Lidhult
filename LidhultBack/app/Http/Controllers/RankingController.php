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
