<?php
namespace App\Http\Controllers;
use App\Models\Announcement;
use App\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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


    /**
     * if the current user is NOT either a Bachelor's degree student ["06"] ,
     * a Master's degree student ["07"]
     * or PHD student ["08"] , then they're admin.
     *
     * @return bool
     */
    public function check_rights($username)
    {
        return !(Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08") ;
    }
    /**
     * Return view for admin to make new announcement
     *
     * @return
     */
    public function create()
    {
        return view('announcement.create');
    }

    /**
     * create new/update the existing announcement
     *
     * @return
     */
    public function update(Request $req, $id)
    {
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You don\'t have access to this feature.');
        }

        $data = Announcement::find($id);

        $new_info = [];

        $new_info['username'] = Auth::user()->username;
        $new_info['title'] = $req->title;
        $new_info['text'] = $req->text;

        $data->update($new_info);

        return back()->with('success', 'announcement updated successfully');
    }

    /**
     * create new/update the existing announcement
     *
     * @return
     */
    public function del(Request $req)
    {
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You don\'t have access to this feature.');
        }

        $data = Announcement::first();

        if(!$data){
            return back()->with('success', 'There was no announcement to delete.');
        } else {
            $data->delete();
        }
        return back()->with('success', 'announcement deleted successfully');
    }

    /**
     * edit the announcement
     *
     * @return
     */
    public function edit($id)
    {
        $data = Announcement::all();
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You don\'t have access to this feature.');
        }

        return view('announcement.edit', compact('data'));
    }

    public function index()
    {
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You are not an admin!');
        }

        $data = File::paginate(3);
        $totalAmount = 0;
        foreach ($data as $row) {
            $totalAmount = $totalAmount + $row->amount;
        }
        $titleText = 'All uploaded files';
        $total = 'Total amount by everyone: '.$totalAmount;
        return view('file.index', compact('data','titleText','total'));
    }

    /**
     * add announcement entry to database
     *
     * @return
     */
    public function store(Request $req)
    {
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You are not an admin!');
        }

        $announcementModel =  new Announcement;

        $announcementModel->username = Auth::user()->username;
        $announcementModel->title = $req->title;
        $announcementModel->text = $req->text;

        $announcementModel->save();

        ActivitiylogController::store('/admin/store','POST',var_dump($announcementModel));
        return back()
        ->with('success','created an announcement.');
    }

    /**
     * update announcement
     *
     * @return
     */
    public function destroy(Request $req, $id)
    {
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You don\'t have access to this feature.');
        }

        $data = Announcement::find($id);
        $data->delete();
        return back()->with('message', 'File deleted successfully');
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
        ->with('success','approved this file')
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
        ->with('success','denied this file')
        ->with('file', $new_info);
    }
}
