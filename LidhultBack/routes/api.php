<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\Ranking_usersController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('createProfessor', [ProfessorController::class, 'create']); // Crear profesor
Route::delete('deleteProfessor', [ProfessorController::class, 'delete']); // Eliminar profesor
Route::post('updateProfessor', [ProfessorController::class, 'update']); // Actualizar profesor
Route::post('readProfessor', [ProfessorController::class, 'read']); // Leer profesor

Route::post('createStudent', [StudentController::class, 'create']); // Crea estudiante
Route::delete('deleteStudent', [StudentController::class, 'delete']); // Eliminar estudiante
Route::post('updateStudent', [StudentController::class, 'update']); // Actualizar estudiante
Route::post('readStudent', [StudentController::class, 'read']); // Leer estudiante

Route::post('login', [LoginController::class, 'login']); // Iniciar sesión

Route::post('createRanking', [RankingController::class, 'create']); // Crear ranking
Route::get('showRanking/{id}', [RankingController::class, 'show']); // Mostrar ranking
Route::get('newCode/{id}', [RankingController::class, 'newCode']); // Actualizar código de ranking

Route::get('indexUsers/{id}', [Ranking_usersController::class, 'index']); // Mostrar estudiantes de ranking
Route::post('createRanking_user', [Ranking_usersController::class, 'create']); // Crear log de rankings

Route::get('indexCharacters', [CharacterController::class, 'index']); // Mostrar todos los personajes

Route::post('sendMessage', [MessageController::class, 'createMessage']); // Enviar mensaje
Route::post('sendRequest', [MessageController::class, 'createRequest']); // Enviar solicitud

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
