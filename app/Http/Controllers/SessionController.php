<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function debug(Request $request)
    {
        $sessionData = [
            'session_id' => session()->getId(),
            'session_driver' => config('session.driver'),
            'session_lifetime' => config('session.lifetime'),
            'session_expire_on_close' => config('session.expire_on_close'),
            'is_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'user_name' => Auth::user() ? Auth::user()->name : 'Not logged in',
            'last_activity' => Auth::user() ? Auth::user()->last_activity : null,
            'session_data' => $request->session()->all(),
            'cookies' => $request->cookies->all(),
        ];

        return response()->json($sessionData, 200, [], JSON_PRETTY_PRINT);
    }
}
