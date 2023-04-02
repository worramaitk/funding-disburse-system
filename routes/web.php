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

Route::get ('',                         function(){ return redirect('/home');                                         });
Route::get ('/secret',                  function(){ return redirect('https://www.youtube.com/watch?v=dQw4w9WgXcQ');   });
Auth::routes();

//home routes
Route::get ('/home',                    [App\Http\Controllers\HomeController::class   , 'index'                       ])->name('home');
Route::get ('/file/upload',             [App\Http\Controllers\FileController::class   , 'createForm'                  ])->name('upload-file');
Route::post('/file/upload',             [App\Http\Controllers\FileController::class   , 'fileUpload'                  ])->name('fileUpload');
Route::get ('/file/listyours',          [App\Http\Controllers\FileController::class   , 'listfiles'                   ]);
Route::get ('/file/download/{id}',      [App\Http\Controllers\FileController::class   , 'downloadfile'                ]);
Route::get ('/file/serve/{id}',         [App\Http\Controllers\FileController::class   , 'servefile'                   ]);
Route::get ('/file/view/{id}',          [App\Http\Controllers\FileController::class   , 'viewfile'                    ]);
Route::get ('/home/usertest',           [App\Http\Controllers\HomeController::class   , 'user'                        ])->name('home');

//admin routes
Route::get ('/admin',                   [App\Http\Controllers\AdminController::class  , 'index'                       ])->name('home');
//auth routes
Route::get ('/auth/psu',                [App\Http\Controllers\PsuAuthController::class, 'redirect'                    ])->name('PsuPassport');
Route::get ('/auth/psu/callback',       [App\Http\Controllers\PsuAuthController::class, 'callbackPsu'                 ])->name('PsuPassport');
Route::get ('/auth/logout',             [App\Http\Controllers\PsuAuthController::class, 'logout'                      ])->name('logout.perform');

Route::post('/home/usertest',           [App\Http\Controllers\PsuAuthController::class, 'usertest'                    ])->name('usertest');

