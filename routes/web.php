<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', "App\Http\Controllers\AuthController@Index");
Route::post('/login', "App\Http\Controllers\AuthController@Login")->name("login");
Route::get('/logout', "App\Http\Controllers\AuthController@Logout")->name("logout");

Route::get('/register', "App\Http\Controllers\AuthController@Register");
Route::post('/register', "App\Http\Controllers\AuthController@StoreUser")->name("register");

Route::get('/home', "App\Http\Controllers\HomeController@index")->name("home");
Route::post('/home', "App\Http\Controllers\HomeController@index")->name("home_sent");

//Socket Server
Route::get("socket", "App\Http\Controllers\SocketController@server");
Route::get("save-socket", "App\Http\Controllers\SocketController@SaveSocket");
Route::get("get-socket", "App\Http\Controllers\SocketController@GetSocket");