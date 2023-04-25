<?php

namespace App\Http\Controllers;
use Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brick\Math\Exception\MathException;
use Mockery\Undefined;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PsuAuthController extends Controller
{

    public function auth()
    {
        header('location: '.Config::get('oauthpsu.oauth_authorize_url').'?client_id='.Config::get('oauthpsu.client_id').'&redirect_uri='.Config::get('oauthpsu.redirect_uri').'&response_type=code&state='.md5(date('Y-m-d H:i:s')));
        die();
    }

    public function callback()
    {
        //get $data as data related to access token and $userinfo for user information
        $code = trim($_REQUEST['code']);
        if($code==''){
            return redirect('/auth/error');
        } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, config::get('oauthpsu.oauth_token_url'));
            curl_setopt($ch, CURLOPT_POST, TRUE);

            /** Authorize Code */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(
                'code' => $code,
                'client_id' => config::get('oauthpsu.client_id'),
                'client_secret' => config::get('oauthpsu.client_secret'),
                'redirect_uri' => config::get('oauthpsu.redirect_uri'),
                'grant_type' => 'authorization_code'
            ));
            $data = json_decode(curl_exec($ch),true);
            $access_token=$data["access_token"];

            /** Get User Information */
            $authorization = "Authorization: Bearer ".$access_token;
            curl_setopt($ch, CURLOPT_URL, config::get('oauthpsu.userinfo_endpoint_url'));
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$_POST);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $userinfo = json_decode(curl_exec($ch),true);
            curl_close($ch);
            $userinfo = array_merge($userinfo, $data);
        }

        // `error_log('message here.');` produces ` WARN  message here.` in the terminal
        // code from https://stackoverflow.com/questions/42324438/how-to-print-messages-on-console-in-laravel
        error_log('message here.');
        error_log('$userinfo: '.json_encode($userinfo));

        //code based on: https://stackoverflow.com/questions/32552450/how-to-log-info-to-separate-file-in-laravel
        Log::channel('your_channel_name')->info('$userinfo: '.json_encode($userinfo));

        $user = User::where('username',$userinfo["username"])->first();

        //create new user if their username is not in our system already
        if(!$user){
            $new_user = User::create([
                'username'      => $userinfo["username"],
                'first_name'    => $userinfo["first_name"],
                'last_name'     => $userinfo["last_name"],
                'staff_id'      => $userinfo["staff_id"],
                'email'         => $userinfo["email"],
                'campus_id'     => $userinfo["campus_id"],
                'fac_id'        => $userinfo["fac_id"],
                'dept_id'       => $userinfo["dept_id"],
                'pos_id'        => $userinfo["pos_id"],

                'access_token'  => $userinfo["access_token"],
                'expires_in'    => $userinfo["expires_in"],
                'token_type'    => $userinfo["token_type"],
                'scope'         => $userinfo["scope"],
                'refresh_token' => $userinfo["refresh_token"],
            ]);
            $user = $new_user;
        } else {
            $new_info = [
                'first_name'    => $userinfo["first_name"],
                'last_name'     => $userinfo["last_name"],
                'staff_id'      => $userinfo["staff_id"],
                'email'         => $userinfo["email"],
                'campus_id'     => $userinfo["campus_id"],
                'fac_id'        => $userinfo["fac_id"],
                'dept_id'       => $userinfo["dept_id"],
                'pos_id'        => $userinfo["pos_id"],

                'access_token'  => $userinfo["access_token"],
                'expires_in'    => $userinfo["expires_in"],
                'token_type'    => $userinfo["token_type"],
                'scope'         => $userinfo["scope"],
                'refresh_token' => $userinfo["refresh_token"],
            ];
            $user->update($new_info);
        }

        //https://stackoverflow.com/questions/48859424/laravel-session-expire-time-for-each-session
        //config(['session.lifetime' => 1]);
        Auth::login($user, false);
        return redirect('/home');             //return redirect()->intended('dashboard');
    }

    public function usertest(Request $req)
    {
        $user = User::where('username',$req->username)->first();
        if(!$user){
            $new_user = User::create([
                'username'      => $req->username,
                'first_name'    => $req->first_name,
                'last_name'     => $req->last_name,
                'staff_id'      => $req->staff_id,
                'email'         => $req->email,
                'campus_id'     => $req->campus_id,
                'fac_id'        => $req->fac_id,
                'dept_id'       => $req->dept_id,
                'pos_id'        => $req->pos_id,
                'access_token'  => $req->access_token,
                'expires_in'    => $req->expires_in,
                'token_type'    => $req->token_type,
                'scope'         => $req->scope,
                'refresh_token' => $req->refresh_token,
            ]);
            $user = $new_user;
        }
        Auth::login($user);
        return redirect('/home');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function errorpage()
    {
        return view('auth.error');
    }
}
