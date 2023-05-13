<?php

namespace App\Http\Controllers;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ActivitiyLogController;
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
        ActivitiylogController::store('/auth/psu','GET');
        header('location: '.Config::get('oauthpsu.oauth_authorize_url').'?client_id='.Config::get('oauthpsu.client_id').'&redirect_uri='.Config::get('oauthpsu.redirect_uri').'&response_type=code&state='.md5(date('Y-m-d H:i:s')));
        die();
    }

    public function callback()
    {
        ActivitiylogController::store('/auth/psu/callback','GET','code: '.trim($_REQUEST['code']));
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
            ActivitiylogController::store('/auth/psu/callback','GET','new user: '.$userinfo["username"]);
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
            ActivitiylogController::store('/auth/psu/callback','GET','returning user: '.$userinfo["username"]);
        }

        //https://stackoverflow.com/questions/48859424/laravel-session-expire-time-for-each-session
        //config(['session.lifetime' => 1]);
        Auth::login($user, false);
        return redirect('/home');             //return redirect()->intended('dashboard');
    }

    public function usertest(Request $req)
    {
        $t = json_decode($req->text);

        LogController::logging('log in via usertest : '.json_encode($req->text));
        $user = User::where('username',$t->username)->first();
        if(!$user){
            $new_user = User::create([
                'username'      => $t->username,
                'first_name'    => $t->first_name,
                'last_name'     => $t->last_name,
                'staff_id'      => $t->staff_id,
                'email'         => $t->email,
                'campus_id'     => $t->campus_id,
                'fac_id'        => $t->fac_id,
                'dept_id'       => $t->dept_id,
                'pos_id'        => $t->pos_id,

                'access_token'  => $t->access_token,
                'expires_in'    => $t->expires_in,
                'token_type'    => $t->token_type,
                'scope'         => $t->scope,
                'refresh_token' => $t->refresh_token,
            ]);
            $user = $new_user;
        } else {
            //return back()->withErrors(['field_name' => ['Error: That username is taken']]);
            $new_info = [
                'first_name'    => $t->first_name,
                'last_name'     => $t->last_name,
                'staff_id'      => $t->staff_id,
                'email'         => $t->email,
                'campus_id'     => $t->campus_id,
                'fac_id'        => $t->fac_id,
                'dept_id'       => $t->dept_id,
                'pos_id'        => $t->pos_id,

                'access_token'  => $t->access_token,
                'expires_in'    => $t->expires_in,
                'token_type'    => $t->token_type,
                'scope'         => $t->scope,
                'refresh_token' => $t->refresh_token,
            ];
            $user->update($new_info);
        }
        Auth::login($user);
        return redirect('/home');
    }

    /**
     *
     * log out then redirect user to home page
     * code based on:
     * https://codeanddeploy.com/blog/laravel/laravel-8-logout-for-your-authenticated-user
     *
     * @return
     */
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function custom()
    {
        return view('testcustomuser');
    }

    public function customuser()
    {
        return view('auth.error');
    }
}
