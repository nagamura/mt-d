<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function callback(Request $request)
    {
        $userData = Socialite::driver('saml2')->stateless()->user();
        //dd($userData);
        //$userData = Socialite::driver('saml2')->user();
        $user = Users::updateOrCreate(
            ['email' => $userData->id],
            []
        );
        Auth::login($user);
        $request->session()->put('user', $user->getAttributes());
        return redirect()->route('mypage.index');
    }
                             

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('mypage.index');
        }
        
        $ua = $request->header('User-Agent');
        $result = false;
        if (strstr($ua , 'Chrome') || strstr($ua , 'Safari')) {
            $result = true;
        }
        return view('auth.login', ['result' => $result, 'ua' => $ua]);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}
