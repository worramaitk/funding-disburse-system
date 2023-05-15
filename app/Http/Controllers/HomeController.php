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
        $data = Announcement::all();
        if(!$data){
            $announcementDoesNotExist = true;
            ActivitiylogController::store('/home','GET','there are zero announcement(s)');
        } else {
            ActivitiylogController::store('/home','GET','there are '.count($data).' announcement(s)');
            if(count($data) == 0){
            } else {
                $announcementDoesNotExist = false;
            }
        }
        return view('home', compact('announcementDoesNotExist','data'));
    }


    public function user()
    {
        ActivitiylogController::store('/home/usertest','GET');
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

