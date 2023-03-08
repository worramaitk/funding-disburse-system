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

Route::get('', function(){
    return redirect('/home');
});

Auth::routes();

//home routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home/uploadfiles', [App\Http\Controllers\HomeController::class, 'uploadfile'])->name('upload-file');
Route::get('/home/listfiles', [App\Http\Controllers\HomeController::class, 'listfiles'])->name('home');

//auth routes
Route::get('/auth/psu', [App\Http\Controllers\PsuAuthController::class,'redirect'])->name('PsuPassport');
Route::get('/auth/psu/callback', [App\Http\Controllers\PsuAuthController::class,'callbackPsu'])->name('PsuPassport');
Route::get('/auth/logout', [App\Http\Controllers\LogoutController::class,'perform'])->name('logout.perform');

//test routes for testing purposes.
Route::get('/test/tailwind', function(){
    return view('tailwindtest');
});

Route::get('/test/topbar', function(){
    return view('topbartest');
});