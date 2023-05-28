<?php
namespace App\Http\Controllers;
use App\Models\Announcement;
use App\Models\Activitylog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
//use ZipArchive;

class ActivitiylogController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

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
    public function create($t,$c)
    {
        $activitylogModel = new Activitylog;
        $activitylogModel->route = '/test/activitylog/'.$t.'/'.$c;
        $activitylogModel->action = 'GET | t: '.$t;
        if ( Auth::user() ) {
            $activitylogModel->loggedin = true;
            $activitylogModel->username = Auth::user()->username;
        } else {
            $activitylogModel->loggedin = false;
        }
        $activitylogModel->comment = $c;
        $activitylogModel->save();

        // ‘error_log('message here.');’ produces ‘ WARN  message here.’ in the terminal
        // code from https://stackoverflow.com/questions/42324438/how-to-print-messages-on-console-in-laravel
        error_log(json_encode($activitylogModel));

        //code based on: https://stackoverflow.com/questions/32552450/how-to-log-info-to-separate-file-in-laravel
        Log::channel('your_channel_name')->info(json_encode($activitylogModel));
    }

    /**
     * Delete the announcement
     *
     * @return
     */
    public function destroy($id)
    {
        $data = ActivityLog::find($id);
        if ( !Auth::user() ) {
            return abort('403', 'You are not logged in!');
        }
        if ( !$this->check_rights(0) ) {
            return abort('403', 'You are not an admin!');
        }

        $data->delete();
        return back()->with('success', 'activity log deleted successfully');
    }

    /**
     * download all log
     *
     * @return
     */
    public function index()
    {
        $data = ActivityLog::all();

        https://stackoverflow.com/questions/52940999/how-to-write-to-a-txt-file-in-laravel
        // try {
        $attemptToWriteText = "Hi from plain PHP";
        //https://stackoverflow.com/questions/6054033/pretty-printing-json-with-php

        //https://stackoverflow.com/questions/14837065/how-to-get-public-directory
        $myfile = fopen( base_path()."/storage/logs/log.log", "w") or die("Unable to open file!");
        fwrite($myfile, $data);
        $myfile = fopen( base_path()."/storage/logs/hi.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $attemptToWriteText);
        fclose($myfile);

        // } catch (\Exception $e) {
        //     dd($e);
        // }

        unlink(base_path()."/storage/all_logs.zip");

        // $files = array('readme.txt', 'test.html', 'image.gif');
        $files = array_diff( scandir( base_path()."/storage/logs/"), array('.', '..'));
        $zipname = base_path()."/storage/all_logs.zip";

        ActivitiylogController::store('/admin/log','GET', json_encode($files));

        $zip = new \ZipArchive;

        if ($zip->open($zipname, \ZipArchive::CREATE) === TRUE) {
            $tempcount = 0;
            foreach ($files as $file) {
                $zip->addFile(base_path()."/storage/logs/".$file , 'all_logs/'.$file ); //add file to the zip archive but put them in '/all_logs' directory of the zip
                ActivitiylogController::store('/admin/log','GET', '#'.$tempcount++.' '.$file);
            }
            $zip->close();
        } else {
            ActivitiylogController::store('/admin/log','GET', 'open failed');
        }

        // $zip->open($zipname, \ZipArchive::CREATE);

        //https://stackoverflow.com/questions/1754352/download-multiple-files-as-a-zip-file-using-php
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='."all_logs.zip");
        header('Content-Length: ' . filesize(base_path()."/storage/all_logs.zip"));
        readfile(base_path()."/storage/all_logs.zip");
    }

    /**
     * add activity log to database
     *
     * @return
     */
    public static function store($route, $action, $comment = '')
    {
        $activitylogModel = new Activitylog;
        $activitylogModel->route = $route;
        $activitylogModel->action = $action;
        if ( Auth::user() ) {
            $activitylogModel->loggedin = true;
            $activitylogModel->username = Auth::user()->username;
        } else {
            $activitylogModel->loggedin = false;
        }
        $activitylogModel->comment = $comment;
        $activitylogModel->save();

        // ‘error_log('message here.');’ produces ‘ WARN  message here.’ in the terminal
        // code from https://stackoverflow.com/questions/42324438/how-to-print-messages-on-console-in-laravel
        error_log(json_encode($activitylogModel));

        //logging to custom Log channel that's defined in /config/logging.php
        //We don't have any further need of this code as we now log into Database instead
        //code based on: https://stackoverflow.com/questions/32552450/how-to-log-info-to-separate-file-in-laravel
        //Log::channel('your_channel_name')->info(json_encode($activitylogModel));
    }
}
