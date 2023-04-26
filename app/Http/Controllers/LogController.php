<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;


class LogController extends Controller
{
    public static function logging($text, $channel = 1)
    {
        if($channel == 1){
            // ‘error_log('message here.');’ produces ‘ WARN  message here.’ in the terminal
            // code from https://stackoverflow.com/questions/42324438/how-to-print-messages-on-console-in-laravel
            error_log($text);

            //code based on: https://stackoverflow.com/questions/32552450/how-to-log-info-to-separate-file-in-laravel
            Log::channel('your_channel_name')->info($text);
        }
    }
}

//code from https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user
