<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerView()
    {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'terms' => 'accepted',
        ]);

        $id = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Auth::loginUsingId($id);

        return redirect()->route('login')->with('success', 'You are registered successfully. Please login to continue.');
    }

    public function loginView()
    {
        if (auth()->user()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // dd($request->all());

        $user = DB::table('users')->where('email', $request->email)->first();

        // dd($user);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid password');
        }

        //dd('inside logged in step');

        $remember = $request->has('remember') == 'on' ? true : false;
        Auth::loginUsingId($user->id, $remember);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
