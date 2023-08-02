<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\mobilController;
use App\Http\Controllers\routeController;
use App\Http\Controllers\userController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[routeController::class,'dashboard']);
Route::get('/mob',[mobilController::class,'detailMobil']);
Route::get('/getUser',[userController::class,'getName']);
Route::get('/daftar-mobil',[mobilController::class,'getMobil']);
Route::get('/daftar-mobil/{jenis}',[mobilController::class,'getMobil']);
Route::get('/ulasan/{id}',[mobilController::class,'getUlasan']);
Route::get('/logout',[loginController::class,'logout']);
Route::post('/login',[loginController::class,'login']);
Route::post('/daftar',[loginController::class,'daftar']);
Route::post('/user/ulasan',[mobilController::class,'addUlasanMobil']);

Route::middleware(['auth','level:admin'])->group(function(){
    Route::get('/admin',[routeController::class,'dashboard'])->name('admin');
    // Route::get('/dashboard',[routeController::class,'dashboard']);
    Route::get('/admin/daftar-mobil',[routeController::class,'detailMobil']);
    Route::get('/admin/mobil',[mobilController::class,'getMobil']);
    Route::get('/admin/mobil/{id}',[mobilController::class,'editMobil']);
    Route::delete('/admin/mobil/{id}',[mobilController::class,'deleteMobil']);
    Route::post('/admin/mobil',[mobilController::class,'addMobil']);
    Route::get('/admin/user',[routeController::class,'user']);
    Route::get('/admin/data-user',[userController::class,'getUser']);
    Route::get('/admin/data-user/{level}',[userController::class,'getUser']);
    Route::post('/admin/user',[userController::class,'addUser']);
    Route::post('/admin/user/{id}',[userController::class,'editUser']);
    Route::delete('/admin/delete/{id}',[userController::class,'deleteUser']);
});

Route::middleware(['auth','level:user'])->group(function(){
    Route::get('/dashboard',[routeController::class,'dashboard'])->name('user');
    // Route::post('/user/ulasan',[mobilController::class,'addUlasanMobil']);
});