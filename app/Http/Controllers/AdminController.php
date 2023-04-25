<?php
namespace App\Http\Controllers;
use App\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        // comment that line out if https://oauth2.eng.psu.ac.th/ went down again like on 11:45 2023-03-25
        $this->middleware('auth');


    }

    public function index()
    {
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You are not an admin!');
        }

        $data = File::all();
        return view('file.index', compact('data'));
    }

    public function approve($id)
    {
        $fileModel = File::find($id);

        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You are not an admin!');
        }

        $new_info = [];

        $new_info['status'] = 'approved' ;

        $fileModel->update($new_info);
        return back()
        ->with('success','File has been updated.')
        ->with('file', $new_info);

    }

    public function deny($id)
    {
        $fileModel = File::find($id);

        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You are not an admin!');
        }

        $new_info = [];

        $new_info['status'] = 'denied' ;

        $fileModel->update($new_info);
        return back()
        ->with('success','File has been updated.')
        ->with('file', $new_info);

    }

    public function check_rights($username)
    {
        //if the current user is NOT either a Bachelor's degree student ["06"] , a Master's degree student ["07"] or PHD student ["08"] , then they're admin
        return !(Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08") ;
    }
}

//code from https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user
