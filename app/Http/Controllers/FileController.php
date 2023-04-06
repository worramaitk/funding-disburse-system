<?php
namespace App\Http\Controllers;
use App\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
        if (Auth::user()) {
            if (Auth::user()->username == $data->username) {
                Storage::delete($data->file_path);
                $data->delete();
                return redirect('/file/create')->with('message', 'File deleted successfully');
            } else {
                return abort('403', 'Unauthorized Action');
            }
        } else {
            return abort('403', 'Unauthorized Action');
        }
    }

    /**
     * download the file
     *
     * @return
     */
    public function download($id)
    {
        $data = File::find($id);

        if (Auth::user()) {
            if (Auth::user()->username == $data->username) {
                return Storage::download($data->file_path);
            } else {
                return abort('403', 'Unauthorized Action');
            }
        } else {
            return abort('403', 'Unauthorized Action');
        }

        // if(Auth::user() && Auth::id() === $file->user->id) {
        //     // filename should be a relative path inside storage/app to your file like 'userfiles/report1253.pdf'
        //     return Storage::download($file->filename);
        // }
    }

    /**
     * edit the file information
     *
     * @return
     */
    public function edit($id)
    {
        $data = File::find($id);
        return view('file.edit', compact('data'));
    }

    /**
     * list all files that that user uploaded
     *
     * @return
     */
    public function index()
    {
        $data = File::all();
        return view('file.index', compact('data'));
    }

    /**
     * shows the raw file to the user
     *
     * @return
     */
    public function serve($id)
    {
        $data = File::find($id);
        if (Auth::user()) {
            if (Auth::user()->username == $data->username) {
                return response()->file( Storage::path($data->file_path));
            } else {
                return abort('403', 'Unauthorized Action');
            }
        } else {
            return abort('403', 'Unauthorized Action');
        }
    }

    /**
     * shows the file inside iframe
     *
     * @return
     */
    public function show($id)
    {
        $data = File::find($id);
        if (Auth::user()->username == $data->username) {
            return view('file.show',compact('data'));
        } else {
            return abort('403', 'Unauthorized Action');
        }
    }

    /**
     * store the file with storage facade and add entry to database
     *
     * @return
     */
    public function store(Request $req)
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
            try{
                error_log('message here.');
                error_log('creating test_dir:');

                Storage::makeDirectory('test_dir');

                error_log('created test_dir successfully');
            } catch (Exception $ex) {
                // jump to this part
                // if an exception occurred
                error_log($ex);
                error_log('such exception occured while creating test_dir');
            }
            //check for possible name to be renamed
            $trimmedName = trim($req->name);
            if ($trimmedName == "") {
                //keep file name as the original one
                $originalFileName = $this->filter_filename($req->file->getClientOriginalName());
                $fileName = ($originalFileName);
            } else {
                $originalFileExt = $this->filter_filename($req->file->getClientOriginalExtension());
                $fileName = $trimmedName.'.'.($originalFileExt);
            }
            // $filePath = $req->file('file')->move('assets',$fileName);

            $fileModel->name = $fileName ; //time().'_'.$req->file->getClientOriginalName();

            if (Auth::user()) {
                //uploader was logged in
                $uploader_username = Auth::user()->username;
            }
            else {
                //uploader was not logged in
                $uploader_username = "guest";
            }
            //Storage::putFile() doesn't accept file name as argument so we're using Storage::putFileAs() instead
            $filePath = Storage::putFileAs($uploader_username.'/'.time().'/'.Str::random(8) , $req->file('file') , $fileName);
            $fileModel->username = $uploader_username;
            $fileModel->file_path = $filePath; // '/storage/' . $filePath;
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

    /**
     * update file information
     *
     * @return
     */
    public function update(Request $req, $id)
    {
        $fileModel = File::find($id);

        if (Auth::user()->username != $fileModel->username) {
            abort(403, 'Unauthorized Action');
        }

        //check for possible name to be renamed
        $trimmedName = trim($req->name);
        if ($trimmedName != "") {
            $new_name = $this->filter_filename($trimmedName);
            $originalFileExt = pathinfo($fileModel->name, PATHINFO_EXTENSION);
            $new_name = $new_name.'.'.($originalFileExt);
        }

        if ($req->amount != "") {
            $new_amount = $req->amount;
        }

        $new_info = [
            'name' => $new_name,
            'amount'  => $new_amount,
        ];

        //logging
        Log::info(json_encode($new_info));
        error_log(var_dump($new_info));

        $fileModel->update($new_info);
        return back()
        ->with('success','File has been updated.')
        ->with('file', $new_info);

    }

    //from https://stackoverflow.com/questions/2021624/string-sanitizer-for-filename
    public function filter_filename($filename, $beautify=true)
    {
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
}

//code from https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user
