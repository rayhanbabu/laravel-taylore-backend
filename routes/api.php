<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendApiController;


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

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
       return $request->user();
     });

     Route::get('{dept_id}/department_view/', [BackendApiController::class, 'department_view']);
     Route::get('{dept_id}/sleeve_view/', [BackendApiController::class,'sleeve_view']);
     Route::get('{dept_id}/collor_view/', [BackendApiController::class,'collor_view']);
     Route::get('{dept_id}/pocket_view/', [BackendApiController::class,'pocket_view']);
     Route::get('{dept_id}/back_detail_view/', [BackendApiController::class,'back_detail_view']);
     Route::get('{dept_id}/buttom_view/', [BackendApiController::class,'buttom_view']);
     Route::get('{dept_id}/buttomcut_view/', [BackendApiController::class,'buttomcut_view']);
     Route::get('{dept_id}/slider_view/', [BackendApiController::class,'slider_view']);




   
     



