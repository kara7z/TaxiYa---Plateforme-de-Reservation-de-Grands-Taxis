<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class SessionsController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Invalid infos'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = $request->user();
        $role = $user->role ?? 'passenger';

        // Choose fallback redirect based on role (used when no "intended" URL exists)
        $fallback = '/';

        if ($role === 'driver') {
            $fallback = Route::has('driver.dashboard') ? route('driver.dashboard') : '/driver/dashboard';
        } elseif ($role === 'admin') {
            $fallback = Route::has('admin.dashboard') ? route('admin.dashboard') : '/admin/dashboard';
        }
        
        return redirect()->intended($fallback);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
