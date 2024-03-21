<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/',[TodoController::class,'index']);
    Route::post('/add-task',[TodoController::class,'addTask']); //C
    Route::get('/all-tasks',[TodoController::class,'allTasks']); //R
    Route::post('/update-task/{id}',[TodoController::class,'update']); //U
    Route::get('/task/delete/{id}',[TodoController::class,'destroy']); //D
    Route::get('/set-complete/{id}',[TodoController::class,'setComplete']); //Set complete
    Route::get('/user',function (Request $request) {
        return $request->user();
    }); //User profile
} 
);

Route::get('token', [LoginController::class,'tokenRefresh']);
Route::post('login',[AuthController::class,'login']);
Route::post('register',[AuthController::class,'register']);


