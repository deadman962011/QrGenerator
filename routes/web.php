<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',['uses'=>'App\Http\Controllers\Controller@home']);

Route::post('/',['uses'=>'App\Http\Controllers\Controller@GenerateQr','as'=>'GenerateQr']);

Route::get('/{coll}/print',['uses'=>'App\Http\Controllers\Controller@print','as'=>'print']);

Route::get('/{coll}/pdf',['uses'=>'App\Http\Controllers\Controller@pdf','as'=>'pdf']);

