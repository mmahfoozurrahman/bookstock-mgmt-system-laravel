<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function dashboard()
    {
        return view('profile.dashboard', [
            'title' => 'Dashboard',
            'description' => 'Welcome to your dashboard'
        ]);
    }
    public function edit()
    {
        return view('profile.edit', [
            'title' => 'Edit Profile',
            'description' => 'Update your personal information'
        ]);
    }

    public function edit_password()
    {
        return view('profile.edit_password', [
            'title' => 'Edit Password',
            'description' => 'Update your password'
        ]);
    }
}
