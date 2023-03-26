<?php
namespace App\Http\Controllers;
use App\Models\File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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

    public function createForm()
    {
        return view('fileupload');
    }

    public function fileUpload(Request $req)
    {
        $req->validate([
            'file' => 'required|max:20000'
        ]);
        $fileModel = new File;
        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->move('assets',$fileName); //->storeAs('uploads', $fileName, 'public');
            //Storage::disk('local')->put($req->file('file') , 'public');
            $fileModel->name = $req->name; //time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = $fileName;// '/storage/' . $filePath;
            if (Auth::user()) {
                $fileModel->username = Auth::user()->username;
            }
            else {
                $fileModel->username = "error";
            }
            $fileModel->amount = $req->amount;

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
}

//code from https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user