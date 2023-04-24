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
        $code = $_REQUEST['code'];
        if(trim($code)==''){
            return redirect('/auth/error');
        } else {
            Log::channel('your_channel_name')->info('$code: '.$code);
            $data = $this->authorizecode($code);
            $userinfo = $this->getuserinfo($code,$data);
        }

        // `error_log('message here.');` produces ` WARN  message here.` in the terminal
        // code from https://stackoverflow.com/questions/42324438/how-to-print-messages-on-console-in-laravel
        error_log('message here.');
        error_log('$userinfo: ');
        error_log($userinfo);

        //code based on: https://stackoverflow.com/questions/32552450/how-to-log-info-to-separate-file-in-laravel
        Log::channel('your_channel_name')->info('$userinfo: '.$userinfo);

        $user = User::where('username',json_decode($userinfo)->username)->first();

        //create new user if their username is not in our system already
        if(!$user){
            $new_user = User::create([
                'username' => json_decode($userinfo)->username,
                'first_name'  => json_decode($userinfo)->first_name,
                'last_name' => json_decode($userinfo)->last_name,
                'staff_id' => json_decode($userinfo)->staff_id,
                'email' => json_decode($userinfo)->email,
                'campus_id' => json_decode($userinfo)->campus_id,
                'fac_id' => json_decode($userinfo)->fac_id,
                'dept_id' => json_decode($userinfo)->dept_id,
                'pos_id' => json_decode($userinfo)->pos_id,

                'access_token' => json_decode($data)->access_token,
                'expires_in' => json_decode($data)->expires_in,
                'token_type' => json_decode($data)->token_type,
                'scope' => json_decode($data)->scope,
                'refresh_token' => json_decode($data)->refresh_token,
            ]);
            $user = $new_user;
        } else {
            $new_info = [
                'first_name'  => json_decode($userinfo)->first_name,
                'last_name' => json_decode($userinfo)->last_name,
                'staff_id' => json_decode($userinfo)->staff_id,
                'email' => json_decode($userinfo)->email,
                'campus_id' => json_decode($userinfo)->campus_id,
                'fac_id' => json_decode($userinfo)->fac_id,
                'dept_id' => json_decode($userinfo)->dept_id,
                'pos_id' => json_decode($userinfo)->pos_id,

                'access_token' => json_decode($data)->access_token,
                'expires_in' => json_decode($data)->expires_in,
                'token_type' => json_decode($data)->token_type,
                'scope' => json_decode($data)->scope,
                'refresh_token' => json_decode($data)->refresh_token,
            ];
            $user->update($new_info);
        }

        //https://stackoverflow.com/questions/48859424/laravel-session-expire-time-for-each-session
        //config(['session.lifetime' => 1440]);

        Auth::login($user, false);
        return redirect('/home');             //return redirect()->intended('dashboard');
    }

    public function usertest(Request $req)
    {
        $user = User::where('username',$req->username)->first();
        if(!$user){
            $new_user = User::create([
                'username' => $req->username,
                'first_name'  => $req->first_name,
                'last_name' => $req->last_name,
                'staff_id' => $req->staff_id,
                'email' => $req->email,
                'campus_id' => $req->campus_id,
                'fac_id' => $req->fac_id,
                'dept_id' => $req->dept_id,
                'pos_id' => $req->pos_id,

            ]);
            $user = $new_user;
        }
        Auth::login($user);
        return redirect('/home');
    }

    public function authorizecode($code){
        //if user has been inactive for too long, log them out
        $client_id                = Config::get('oauthpsu.client_id');
        $client_secret            = Config::get('oauthpsu.client_secret');
        $redirect_uri             = Config::get('oauthpsu.redirect_uri');
        $oauth_authorize_url      = Config::get('oauthpsu.oauth_authorize_url');
        $oauth_token_url          = Config::get('oauthpsu.oauth_token_url');
        $userinfo_endpoint_url    = Config::get('oauthpsu.userinfo_endpoint_url');

        error_log('$code: ');
        error_log($code);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $oauth_token_url);

        curl_setopt($ch, CURLOPT_POST, TRUE);



        /** Authorize Code */

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        ));

        $data = curl_exec($ch);
        curl_close($ch);

        error_log('$data from oauth_token_url: ');
        error_log($data);

        Log::channel('your_channel_name')->info('$data from oauth_token_url: '.$data);
        return $data;
    }

    public function getuserinfo($code, $data){
        $client_id                = Config::get('oauthpsu.client_id');
        $client_secret            = Config::get('oauthpsu.client_secret');
        $redirect_uri             = Config::get('oauthpsu.redirect_uri');
        $oauth_authorize_url      = Config::get('oauthpsu.oauth_authorize_url');
        $oauth_token_url          = Config::get('oauthpsu.oauth_token_url');
        $userinfo_endpoint_url    = Config::get('oauthpsu.userinfo_endpoint_url');

        $psu_refresh_token = json_decode($data)->refresh_token;
        $access_token = json_decode($data)->access_token;


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $oauth_token_url);

        curl_setopt($ch, CURLOPT_POST, TRUE);



        /** Authorize Code */

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'code' => $code,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code'
        ));

        error_log('$data from oauth_token_url: ');
        error_log($data);

        Log::channel('your_channel_name')->info('$data from oauth_token_url: '.$data);


        /** Get User Information */
        $authorization = "Authorization: Bearer ".$access_token;
        curl_setopt($ch, CURLOPT_URL, $userinfo_endpoint_url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_POSTFIELDS,$_POST); okay so I can comment this line out just fine
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $userinfo= curl_exec($ch);
        curl_close($ch);

        return $userinfo;
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
