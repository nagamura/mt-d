<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }
        $user = $request->session()->get('user');
        return view('mypage.index', ['user' => $user]);
    }
}
