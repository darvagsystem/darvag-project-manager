<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLoggerService;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('panel.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('username', 'password'))) {
            $request->session()->regenerate();

            // Log login activity
            ActivityLoggerService::logLogin(Auth::user());

            return redirect()->intended(route('panel.dashboard'));
        }

        return back()->withErrors([
            'username' => 'اطلاعات وارد شده صحیح نیست.',
        ]);
    }

    public function logout(Request $request)
    {
        // Log logout activity before logout
        if (Auth::check()) {
            ActivityLoggerService::logLogout(Auth::user());
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
