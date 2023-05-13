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


    public function index()
    {
        $data = ActivityLog::all();

        //https://stackoverflow.com/questions/52940999/how-to-write-to-a-txt-file-in-laravel
        try {
            $attemptToWriteText = "Hi";
            //https://stackoverflow.com/questions/6054033/pretty-printing-json-with-php
            Storage::put('log.log', json_encode($data, JSON_PRETTY_PRINT));
            Storage::put('hi.txt', $attemptToWriteText);
        } catch (\Exception $e) {
            dd($e);
        }
        return Storage::download('log.log');
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
