<?php

namespace App\Http\Controllers;
use Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brick\Math\Exception\MathException;
use Mockery\Undefined;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PsuAuthController extends Controller
{

    public function redirect()
    {
        $client_id                = Config::get('oauthpsu.client_id');                //
        $redirect_uri             = Config::get('oauthpsu.redirect_uri');             //
        $oauth_authorize_url      = Config::get('oauthpsu.oauth_authorize_url');      //
        header('location: '.$oauth_authorize_url.'?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&response_type=code&state='.md5(date('Y-m-d H:i:s')));
        die();
    }

    public function callbackPsu()
    {
        $client_id                = Config::get('oauthpsu.client_id');
        $client_secret            = Config::get('oauthpsu.client_secret');
        $redirect_uri             = Config::get('oauthpsu.redirect_uri');
        $oauth_authorize_url      = Config::get('oauthpsu.oauth_authorize_url');
        $oauth_token_url          = Config::get('oauthpsu.oauth_token_url');
        $userinfo_endpoint_url    = Config::get('oauthpsu.userinfo_endpoint_url');

        $code = $_REQUEST['code'];
        //$request->get('code');
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

        $userinfo = '';
        $data = curl_exec($ch);

        error_log('message here.');
        error_log('$data:');
        error_log($data);

        $access_token=json_decode($data)->access_token;
        /** Get User Information */
        $authorization = "Authorization: Bearer ".$access_token;
        curl_setopt($ch, CURLOPT_URL, $userinfo_endpoint_url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$_POST);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $userinfo= curl_exec($ch);
        curl_close($ch);

        // `error_log('message here.');` produces ` WARN  message here.` in the terminal
        // code from https://stackoverflow.com/questions/42324438/how-to-print-messages-on-console-in-laravel
        error_log('message here.');
        error_log('$userinfo:');
        error_log($userinfo);
        $user_object = json_decode($userinfo);

        $user = User::where('username',$user_object->username)->first();

        if(!$user){
            $new_user = User::create([
                'username' => $user_object->username,
                'first_name'  => $user_object->first_name,
                'last_name' => $user_object->last_name,
                'staff_id' => $user_object->staff_id,
                'email' => $user_object->email,
                'campus_id' => $user_object->campus_id,
                'fac_id' => $user_object->fac_id,
                'dept_id' => $user_object->dept_id,
                'pos_id' => $user_object->pos_id,

            ]);
            $user = $new_user;
        }
        Auth::login($user);
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

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
