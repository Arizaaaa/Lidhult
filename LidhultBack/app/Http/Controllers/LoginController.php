<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request) { // Función de login

        try{

            $request->validate([
                'dato' => 'required',
                'password' => 'required',
            ]);

            $user = DB::select('select * FROM students WHERE email = ? OR nick = ?', [$request->dato, $request->dato]); // Comprueba que el email o nick lo use un estudiante

            if ($user == null) { // Si un estudiante no usa el email o nick...

                $user = DB::select('select * FROM professors WHERE email = ? OR nick = ?', [$request->dato, $request->dato]); // Comprueba que el email o nick lo use un profesor
                
                if($user == null || !password_verify($request->password, $user[0]->password)) { abort(500); } // Si no esta usado, verifica la contraseña, o devuelve error

            } else {
                if(!password_verify($request->password, $user[0]->password)) { abort(500); } // Si el email o nick lo usa un estudiante, devuelve error
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
