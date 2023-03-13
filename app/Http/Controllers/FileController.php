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
            $filePath = $req->file('file'); //->storeAs('uploads', $fileName, 'public');
            Storage::disk('local')->put($req->file('file') , 'public');
            $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->username = Auth::user()->username ;
            $fileModel->amount = $req->amount;

            $fileModel->save();
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
    }

    public function listfiles()
    {
        $data = File::get(['name', 'file_path', 'username', 'amount']);
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
}

//code from https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user
