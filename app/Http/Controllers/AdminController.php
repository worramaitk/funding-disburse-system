<?php
namespace App\Http\Controllers;
use App\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
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
        if (Auth::user()->pos_id == "06" || Auth::user()->pos_id == "07" || Auth::user()->pos_id ==  "08"){
            return redirect('/home');
        }
        else {
            return view('adminhome');
        }
    }


    public function createForm(){

    }


    public function fileUpload(Request $req)
    {
        $req->validate([
            'file' => 'required|max:20000'
        ]);
        $fileModel = new File;
        if($req->file()) {
            //$fileName = time().'_'.$req->file->getClientOriginalName();
             //->storeAs('uploads', $fileName, 'public');
            //Storage::disk('local')->put($req->file('file') , 'public');
            Log::info('name: '.var_dump($req->name));
            error_log('name: '.var_dump($req->name));

            //check for possible name to be renamed
            $trimmedName = trim($req->name);
            if ($trimmedName == "") {
                //keep file name as the original one
                $originalFileName = $this->filter_filename($req->file->getClientOriginalName());
                $fileName = time().'_'.($originalFileName);
            } else {
                $originalFileExt = $this->filter_filename($req->file->getClientOriginalExtension());
                $fileName = time().'_'.$trimmedName.'.'.($originalFileExt);
            }
            $filePath = $req->file('file')->move('assets',$fileName);
            $fileModel->name = $fileName ; //time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = $filePath; // '/storage/' . $filePath;
            if (Auth::user()) {
                $fileModel->username = Auth::user()->username;
            }
            else {
                $fileModel->username = "error";
            }
            $fileModel->amount = $req->amount;

            //logging
            Log::info(json_encode($fileModel));
            error_log(var_dump($fileModel));

            $fileModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);


        }
    }

    public function listfiles()
    {
        // $data = File::get(['name', 'file_path', 'username', 'amount']);

        $data = File::all();

    	// $data = File::join('state', 'state.country_id', '=', 'country.country_id')
        // ->join('city', 'city.state_id', '=', 'state.state_id')
        // ->get(['country.country_name', 'state.state_name', 'city.city_name']);

        /*Above code will produce following query
        Select
        `country`.`country_name`,
        `state`.`state_name`,
        `city`.`city_name`
        from `country`
        inner join `state`
        on `state`.`country_id` = `country`.`country_id`
        inner join `city`
        on `city`.`state_id` = `state`.`state_id`
        */

        //return view('join_table', compact('data'));
        return view('listfiles', compact('data'));
    }

    public function download(Request $request, $id)
    {
        $data = File::find($id);
        return response()->download(public_path('assets/'.$data->file_path));
    }

    public function viewfile($id)
    {
        $data = File::find($id);
        return view('viewfile',compact('data'));
    }

    //from https://stackoverflow.com/questions/2021624/string-sanitizer-for-filename
    public function filter_filename($filename, $beautify=true) {
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

    public function beautify_filename($filename) {
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
}

//code from https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user
