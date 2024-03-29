<?php

use App\Http\Controllers\ActivitiylogController;
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
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

//home routes
Route::get ('/home',                      [App\Http\Controllers\HomeController::class         , 'index'       ])->name('home');
Route::get ('/licenses',                  [App\Http\Controllers\HomeController::class         , 'licenses'    ])->name('licenses');

Route::get ('/file/create',               [App\Http\Controllers\FileController::class         , 'create'      ])->name('file-create');
Route::get ('/file/destroy/{id}',         [App\Http\Controllers\FileController::class         , 'destroy'     ])->name('file-destroy');
Route::get ('/file/download/{id}',        [App\Http\Controllers\FileController::class         , 'download'    ])->name('file-download');
Route::get ('/file/edit/{id}',            [App\Http\Controllers\FileController::class         , 'edit'        ])->name('file-edit');
Route::get ('/file/index',                [App\Http\Controllers\FileController::class         , 'index'       ])->name('file-index');
Route::get ('/file/serve/{id}',           [App\Http\Controllers\FileController::class         , 'serve'       ])->name('file-serve');
Route::get ('/file/show/{id}',            [App\Http\Controllers\FileController::class         , 'show'        ])->name('file-show');
Route::post('/file/store',                [App\Http\Controllers\FileController::class         , 'store'       ])->name('file-store');
Route::post('/file/update/{id}',          [App\Http\Controllers\FileController::class         , 'update'      ])->name('file-update');

//admin routes
Route::get ('/admin',                     [App\Http\Controllers\AdminController::class        , 'index'       ])->name('admin');
Route::get ('/admin/approve/{id}',        [App\Http\Controllers\AdminController::class        , 'approve'     ])->name('admin-approve');
Route::get ('/admin/deny/{id}',           [App\Http\Controllers\AdminController::class        , 'deny'        ])->name('admin-deny');
Route::get ('/admin/log',                 [App\Http\Controllers\ActivitiylogController::class , 'index'       ])->name('admin-log');
Route::post('/admin/store/',              [App\Http\Controllers\AdminController::class        , 'store'       ])->name('admin-store');
Route::post('/admin/update/{id}',         [App\Http\Controllers\AdminController::class        , 'update'      ])->name('admin-update');
Route::get ('/admin/destroy/{id}',        [App\Http\Controllers\AdminController::class        , 'destroy'     ])->name('admin-destroy');

//auth routes
Route::get ('/auth/psu',                  [App\Http\Controllers\PsuAuthController::class      , 'auth'        ])->name('auth-PsuPassport');
Route::get ('/auth/error',                [App\Http\Controllers\PsuAuthController::class      , 'errorpage'   ])->name('auth-error');
Route::get ('/auth/psu/callback',         [App\Http\Controllers\PsuAuthController::class      , 'callback'    ])->name('auth-callback-PsuPassport');
Route::get ('/auth/logout',               [App\Http\Controllers\PsuAuthController::class      , 'logout'      ])->name('auth-logout');

//testing routes
Route::get ('/home/phpinfo',              [App\Http\Controllers\HomeController::class         , 'user'        ])->name('home');
Route::get ('/home/usertest',             [App\Http\Controllers\PsuAuthController::class      , 'custom'      ])->name('usercustom');
Route::post('/home/usertest',             [App\Http\Controllers\PsuAuthController::class      , 'usertest'    ])->name('usertest');
Route::get ('/phpinfo',                   [App\Http\Controllers\HomeController::class         , 'phpinfo'     ])->name('phpinfo');
Route::get ('/calendar/test',             [App\Http\Controllers\CalendarController::class     , 'test'        ])->name('calendar-test');
Route::get ('/calendar/today',            [App\Http\Controllers\CalendarController::class     , 'today'       ])->name('calendar-today');
Route::get ('/test/activitylog/{t}/{c}',  [App\Http\Controllers\ActivitiylogController::class , 'create'      ])->name('loggingtest');

//routes that got redirected
Route::get ('',                 function(){ ActivitiylogController::store('/','GET');       return redirect('/home');                         });
Route::get ('/secret',          function(){ ActivitiylogController::store('/secret','GET'); return redirect('https://youtu.be/dQw4w9WgXcQ');  });
