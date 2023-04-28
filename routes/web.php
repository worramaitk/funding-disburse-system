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

Auth::routes();

// https://www.youtube.com/watch?v=MYyJ4PuL4pY&t=6183s&ab_channel=TraversyMedia
// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing -- TODO
// update - Update listing          -- TODO
// destroy - Delete listing         -- TODO

//home routes
Route::get ('/home',                    [App\Http\Controllers\HomeController::class     , 'index'       ])->name('home');

Route::get ('/file/create',             [App\Http\Controllers\FileController::class     , 'create'      ])->name('file-create');
Route::get ('/file/destroy/{id}',       [App\Http\Controllers\FileController::class     , 'destroy'     ])->name('file-destroy');
Route::get ('/file/download/{id}',      [App\Http\Controllers\FileController::class     , 'download'    ])->name('file-download');
Route::get ('/file/edit/{id}',          [App\Http\Controllers\FileController::class     , 'edit'        ])->name('file-edit');
Route::get ('/file/index',              [App\Http\Controllers\FileController::class     , 'index'       ])->name('file-index');
Route::get ('/file/serve/{id}',         [App\Http\Controllers\FileController::class     , 'serve'       ])->name('file-serve');
Route::get ('/file/show/{id}',          [App\Http\Controllers\FileController::class     , 'show'        ])->name('file-show');
Route::post('/file/store',              [App\Http\Controllers\FileController::class     , 'store'       ])->name('file-store');
Route::post('/file/update/{id}',        [App\Http\Controllers\FileController::class     , 'update'      ])->name('file-update');

//admin routes
Route::get ('/admin',                   [App\Http\Controllers\AdminController::class    , 'index'       ])->name('admin');
Route::get ('/admin/approve/{id}',      [App\Http\Controllers\AdminController::class    , 'approve'     ])->name('admin-approve');
Route::get ('/admin/deny/{id}',         [App\Http\Controllers\AdminController::class    , 'deny'        ])->name('admin-deny');

Route::get ('/message/create/{id}',     [App\Http\Controllers\MessageController::class  , 'create'      ])->name('message-create');
Route::get ('/message/destroy/{id}',    [App\Http\Controllers\MessageController::class  , 'destroy'     ])->name('message-destroy');
Route::get ('/message/edit/{id}',       [App\Http\Controllers\MessageController::class  , 'edit'        ])->name('message-edit');
Route::get ('/message/index',           [App\Http\Controllers\MessageController::class  , 'index'       ])->name('message-index');
Route::get ('/message/serve/{id}',      [App\Http\Controllers\MessageController::class  , 'serve'       ])->name('message-serve');
Route::get ('/message/show/{id}',       [App\Http\Controllers\MessageController::class  , 'show'        ])->name('message-show');
Route::post('/message/store/{id}',      [App\Http\Controllers\MessageController::class  , 'store'       ])->name('message-store');
Route::post('/message/update/{id}',     [App\Http\Controllers\MessageController::class  , 'update'      ])->name('message-update');

//auth routes
Route::get ('/auth/psu',                [App\Http\Controllers\PsuAuthController::class  , 'auth'        ])->name('auth-PsuPassport');
Route::get ('/auth/error',              [App\Http\Controllers\PsuAuthController::class  , 'errorpage'   ])->name('auth-error');
Route::get ('/auth/psu/callback',       [App\Http\Controllers\PsuAuthController::class  , 'callback'    ])->name('auth-callback-PsuPassport');
Route::get ('/auth/logout',             [App\Http\Controllers\PsuAuthController::class  , 'logout'      ])->name('auth-logout');

//testing routes
Route::get ('/home/phpinfo',            [App\Http\Controllers\HomeController::class     , 'user'        ])->name('home');
Route::get ('/home/usertest',           [App\Http\Controllers\PsuAuthController::class  , 'custom'      ])->name('usercustom');
Route::post('/home/usertest',           [App\Http\Controllers\PsuAuthController::class  , 'usertest'    ])->name('usertest');
Route::get ('/phpinfo',                 [App\Http\Controllers\HomeController::class     , 'phpinfo'     ])->name('phpinfo');
Route::get ('/calendar/test',           [App\Http\Controllers\CalendarController::class , 'test'        ])->name('calendar-test');
Route::get ('/calendar/today',          [App\Http\Controllers\CalendarController::class , 'today'       ])->name('calendar-today');
Route::get ('/test/logging/{text}',     [App\Http\Controllers\PsuAuthController::class  , 'logging'     ])->name('loggingtest');

//routes that got redirected
Route::get ('',                         function(){ return redirect('/home');                           });
Route::get ('/secret',                  function(){ return redirect('https://youtu.be/dQw4w9WgXcQ');    });
