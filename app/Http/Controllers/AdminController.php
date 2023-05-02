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
     * Delete the announcement
     *
     * @return
     */
    public function destroy($id)
    {
        $data = Announcement::find($id);
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights($data->username) ) {
            return abort('403', 'You don\'t have access to this file.');
        }

        $data->delete();
        return redirect('/file/create')->with('message', 'File deleted successfully');
    }

    /**
     * edit the announcement
     *
     * @return
     */
    public function edit($id)
    {
        $data = File::find($id);
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights($data->username) ) {
            return abort('403', 'You don\'t have access to this feature.');
        }

        return view('announcement.edit', compact('data'));
    }

    /**
     * add announcement entry to database
     *
     * @return
     */
    public function store(Request $req)
    {
        if ( !Auth::user() ) {
            return back()->withErrors(['field_name' => ['Error: You\'re not logged in']]);
        }

        //LogController::logging(var_dump($req->files));
        $req->validate([
            'files' => 'required|max:90000'
        ]);

        //code from: https://www.tutsmake.com/laravel-8-multiple-file-upload-example/
        if(!$req->file()) {
            return back()->withErrors(['field_name' => ['Error: There\'s no file to upload']]);
        }
        $amount_of_files = sizeof($req->file('files'));
        LogController::logging("uploading ".$amount_of_files." files");
        foreach($req->file('files') as $key => $fi){
            $fileModel = new File;

            Log::info('req->name: '.var_dump($req->name));
            error_log('req->name: '.var_dump($req->name));

            //check for possible name to be renamed
            $trimmedName = trim($req->name);
            if ($trimmedName == "") {
                //keep file name as the original one
                $fileModel->name = $this->filter_filename($fi->getClientOriginalName());
            } else {
                $fileModel->name = $trimmedName.'.'.$this->filter_filename($fi->getClientOriginalExtension());;
            }

            if (Auth::user()) {
                //uploader was logged in
                $uploader_username = Auth::user()->username;
            }
            else {
                //uploader was not logged in
                $uploader_username = "guest";
            }
            //Storage::putFile() doesn't accept file name as argument so we're using Storage::putFileAs() instead
            $filePath = Storage::putFileAs($uploader_username.'/'.time().'/'.Str::random(8) , $fi , $fileModel->name);
            $fileModel->username = $uploader_username;
            $fileModel->file_path = $filePath;
            $fileModel->amount = $req->amount;
            $fileModel->status = 'pending';
            //logging
            LogController::logging(var_dump($fileModel));

            $fileModel->save();
        }

        LogController::logging("FINISHED uploading ".$amount_of_files." files");
        return back()
        ->with('success',$amount_of_files.' file(s) has been uploaded.');
    }

    /**
     * update announcement
     *
     * @return
     */
    public function update(Request $req, $id)
    {
        $fileModel = File::find($id);

        if ( !Auth::user() ) {
            return back()->withErrors(['field_name' => ['Error: You\'re not logged in']]);
        }
        if ( !$this->check_rights($fileModel->username) ) {
            return back()->withErrors(['field_name' => ['Error: You\'re unauthorized.']]);
        }

        $new_info = [];

        //check for possible name to be renamed
        $trimmedName = trim($req->name);
        if ($trimmedName != "") {
            $new_name = $this->filter_filename($trimmedName);
            $new_info['name'] = $new_name.'.'.pathinfo($fileModel->name, PATHINFO_EXTENSION);

            $old_path = $fileModel->file_path;
            $new_info['file_path'] = dirname($old_path).'/'.$new_info['name'] ;
            Storage::move($old_path, $new_info['file_path']);
        }

        if ($req->amount != "") {
            $new_info['amount'] = $req->amount;
        }

        LogController::logging('info to be updated: '.json_encode($new_info));

        $fileModel->update($new_info);
        return back()
        ->with('success','File has been updated.')
        ->with('file', $new_info);
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
        return view('admin.index', compact('data'));
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

//code from https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user
