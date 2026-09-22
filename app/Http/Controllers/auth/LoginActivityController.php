<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;

class LoginActivityController extends Controller
{
    public function index()
    {
        $loginLogs = LoginLog::with('user')
            ->latest('login_at')
            ->get();

        return view('auth.login-activity', compact('loginLogs'));
    }
}