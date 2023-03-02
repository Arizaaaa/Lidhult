<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
  
    // public function create()
    // {
    //     //
    // }

    // public function delete($id)
    // {
    //     //
    // }

    // public function update(Request $request, $id)
    // {
    //     //
    // }

    public function index() {

        $character = DB::select('select * FROM characters');

        return response()->json([
            "status" => 1,
            "msg" => "Vista exitosa!",
            "data" => $character
        ]);

    }

    public function read($id)
    {
        //
    }
}
