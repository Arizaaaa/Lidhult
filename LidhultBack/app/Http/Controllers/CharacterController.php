<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{

    public function index() { // Devuelve todos los carácteres

        $character = DB::select('select * FROM characters');

        return response()->json([
            "status" => 1,
            "msg" => "Vista exitosa!",
            "data" => $character
        ]);

    }
}
