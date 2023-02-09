<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request) {

        try{

            $request->validate([
                'dato' => 'required',
                'password' => 'required',
            ]);

            $request->password = Hash::make($request->password);

            $user = DB::select('select * FROM students WHERE email = ? OR nick = ? AND password = ?',
            [$request->dato, $request->dato, $request->center]);

            if ($user == null) {
                $user = DB::select('select * FROM professors WHERE email = ? OR nick = ? AND password = ?',
                [$request->dato, $request->dato, $request->center]);
            }

            return response()->json([
                "status" => 1,
                "msg" => "Login exitoso!",
                "data" => $user,
            ]);

        } catch (Exception $e) {

            return response()->json([
                "status" => 0,
                "msg" => "No se ha logueado! + $e",
            ]);

        }

    }
}
