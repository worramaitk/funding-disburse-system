<?php
namespace App\Http\Controllers;
use App\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\LogController;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // comment that line out if https://oauth2.eng.psu.ac.th/ went down again like on 11:45 2023-03-25
        $this->middleware('auth');
    }

    /**
     * Return view for user to upload file
     *
     * @return
     */
    public function create()
    {
        return view('file.create');
    }

    /**
     * Delete the file , then delete its entry from the database
     *
     * @return
     */
    public function destroy($id)
    {
        $data = File::find($id);
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights($data->username) ) {
            return abort('403', 'You don\'t have access to this file.');
        }

        Storage::delete($data->file_path);
        $data->delete();
        return redirect('/file/create')->with('message', 'File deleted successfully');
    }

    /**
     * download the file
     *
     * @return
     */
    public function download($id)
    {
        $data = File::find($id);
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights($data->username) ) {
            return abort('403', 'You don\'t have access to this file.');
        }

        return Storage::download($data->file_path);
    }

    /**
     * edit the file information
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
            return abort('403', 'You don\'t have access to this file.');
        }

        return view('file.edit', compact('data'));
    }

    /**
     * list all files that that user uploaded
     *
     * @return
     */
    public function index()
    {
        // $data = File::all()->where('username', Auth::user()->username)->paginate(3);
        $data = File::where('username', Auth::user()->username)->paginate(3);
        $totalAmount = 0;
        foreach ($data as $row) {
            $totalAmount = $totalAmount + $row->amount;
        }
        $titleText = 'Your uploaded files';
        $total = 'Total amount by you: '.$totalAmount;
        return view('file.index', compact('data','titleText','total'));
    }

    /**
     * shows the raw file to the user
     *
     * @return
     */
    public function serve($id)
    {
        $data = File::find($id);
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights($data->username) ) {
            return abort('403', 'You don\'t have access to this file.');
        }

        return response()->file( Storage::path($data->file_path));
    }

    /**
     * shows the file inside iframe
     *
     * @return
     */
    public function show($id)
    {
        $data = File::find($id);
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights($data->username) ) {
            return abort('403', 'You don\'t have access to this file.');
        }

        return view('file.show',compact('data'));
    }

    /**
     * store the file with storage facade and add entry to database
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
     * update file information
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

    //from https://stackoverflow.com/questions/2021624/string-sanitizer-for-filename
    public function filter_filename($filename, $beautify=true)
    {
        LogController::logging('filtering filename: "'.($filename).'"');

        // sanitize filename
        $filename = preg_replace(
            '~
            [<>:"/\\\|?*]|           # file system reserved https://en.wikipedia.org/wiki/Filename#Reserved_characters_and_words
            [\x00-\x1F]|             # control characters http://msdn.microsoft.com/en-us/library/windows/desktop/aa365247%28v=vs.85%29.aspx
            [\x7F\xA0\xAD]|          # non-printing characters DEL, NO-BREAK SPACE, SOFT HYPHEN
            [#\[\]@!$&\'()+,;=]|     # URI reserved https://www.rfc-editor.org/rfc/rfc3986#section-2.2
            [{}^\~`]                 # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
            ~x',
            '-', $filename);
        // avoids ".", ".." or ".hiddenFiles"
        $filename = ltrim($filename, '.-');
        // optional beautification
        if ($beautify) $filename = $this->beautify_filename($filename);
        // maximize filename length to 255 bytes http://serverfault.com/a/9548/44086
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = mb_strcut(pathinfo($filename, PATHINFO_FILENAME), 0, 255 - ($ext ? strlen($ext) + 1 : 0), mb_detect_encoding($filename)) . ($ext ? '.' . $ext : '');
        return $filename;
    }

    public function beautify_filename($filename)
    {
        // reduce consecutive characters
        $filename = preg_replace(array(
            // "file   name.zip" becomes "file-name.zip"
            '/ +/',
            // "file___name.zip" becomes "file-name.zip"
            '/_+/',
            // "file---name.zip" becomes "file-name.zip"
            '/-+/'
        ), '-', $filename);
        $filename = preg_replace(array(
            // "file--.--.-.--name.zip" becomes "file.name.zip"
            '/-*\.-*/',
            // "file...name..zip" becomes "file.name.zip"
            '/\.{2,}/'
        ), '.', $filename);
        // lowercase for windows/unix interoperability http://support.microsoft.com/kb/100625
        $filename = mb_strtolower($filename, mb_detect_encoding($filename));
        // ".file-name.-" becomes "file-name"
        $filename = trim($filename, '.-');
        return $filename;
    }

    public function check_rights($username)
    {
        //check if the current user is the same as a given username
        return (Auth::user()->username == $username
        //if the current user is NOT either a Bachelor's degree student ["06"] , a Master's degree student ["07"] or PHD student ["08"] , then they're admin
        || !(Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08")) ;
    }
}
