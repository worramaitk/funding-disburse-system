<?php

namespace App\Http\Controllers;
use App\Models\Announcement;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        ActivitiylogController::store('/home','GET');
        $data = Announcement::first();
        $username = '';
        $title = '';
        $text = '';
        $createdat = '';
        $updatedat = '';
        $announcementexists = false;
        if(!$data){
            $announcementexists = false;
        } else {
            $announcementexists = true;
            $username = $data->username;
            $title = $data->title;
            $text = $data->text;
            $createdat = $data->created_at;
            $updatedat = $data->updated_at;
        }
        return view('home', compact('announcementexists','username','title','text','createdat','updatedat'));
    }


    public function user()
    {
        ActivitiylogController::store('/home','GET');
        return view('testcustomuser');
    }

    public function phpinfo()
    {
        ActivitiylogController::store('/phpinfo','GET');
        return phpinfo();
    }

    public function licenses()
    {
        ActivitiylogController::store('/licenses','GET');
        return view('licenses');
    }
}

