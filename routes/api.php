<?php

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

Route::get('/login', [\App\Http\Controllers\Controller::class, 'login']);
Route::get('/course', [\App\Http\Controllers\Controller::class, 'course']);
Route::get('/score', [\App\Http\Controllers\Controller::class, 'score']);
