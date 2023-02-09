<?php

use App\Http\Controllers\ProfessorController;
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

Route::post('createProfessor', [ProfessorController::class, 'create']);
Route::delete('deleteProfessor', [ProfessorController::class, 'delete']);
Route::post('updateProfessor', [ProfessorController::class, 'update']);
Route::post('readProfessor', [ProfessorController::class, 'read']);
Route::post('createStudent', [StudentController::class, 'create']);
Route::delete('deleteStudent', [StudentController::class, 'delete']);
Route::post('updateStudent', [StudentController::class, 'update']);
Route::post('readStudent', [StudentController::class, 'read']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
