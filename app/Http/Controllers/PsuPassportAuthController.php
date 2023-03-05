<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class PsuPassportAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('PsuPassport')->redirect();
    }
    public function callbackPsu()
    {
        try{
            $psu_user = Socialite::driver('PsuPassport')->user();
            $user = User::where('psu_id', $psu_user->getId())->first();

            if (!$user){
                $new_user = User::create([
                    'name' => $psu_user->getName(),
                    'email' => $psu_user->getEmail(),
                    'psu_id' => $psu_user->getID()
                ]);
                Auth::Login($new_user);

                return redirect()->intended('dashboard')
            }


        } catch(Throwable $th) {
            dd('something went wrong'.$th->getMessage());
        }
    }
}
