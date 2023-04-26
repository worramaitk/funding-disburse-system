<?php

namespace App\Http\Controllers;

use App\Http\Controllers\LogController;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function user()
    {
        return view('testcustomuser');
    }

    public function phpinfo()
    {
        LogController::logging("loading phpinfo");
        return phpinfo();
    }
}
