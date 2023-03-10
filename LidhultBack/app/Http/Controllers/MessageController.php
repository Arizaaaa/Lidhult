<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    
    public function createMessage(Request $request) { // Crea un mensaje

        try{
            
            DB::beginTransaction();
            $request->validate([
                'sender' => 'required',
                'receiver' => 'required',
                'content' => 'required',
            ]);
            
            $message = new Message();
            $message->sender = $request->sender;
            $message->receiver = $request->receiver;
            $message->content = $request->content;
            $message->save();
            DB::commit();
            
            return response()->json([
                "status" => 1,
                "msg" => "Se ha insertado!",
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido insertar! + $e",
            ]);
        }
    }

    public function createRequest(Request $request) { // Crea una petición de unión a un ranking

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
            [$request->student_id]); // Selecciona el nick del emisor

            $professor = DB::select('SELECT *
                                    FROM professors
                                    WHERE id = (SELECT professor_id 
                                    FROM rankings 
                                    WHERE code = ?)',
            [$request->code]); // Selecciona el nick del receptor
                        
            $message = new Message();
            $message->sender = $student[0]->nick;
            $message->receiver = $professor[0]->nick;
            $message->issue = "Petición para unirse al Ranking";
            $message->save();
            DB::commit();
            
            return response()->json([
                "status" => 1,
                "msg" => "Se ha insertado!",
                "data" => $message,
            ]);

        } catch (Exception $e) {

            DB::rollBack();
            return response()->json([
                "status" => 0,
                "msg" => "No se ha podido insertar! + $e",
            ]);
        }
    }
}
