<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function dashboard()
    {
        //dd('inside profile dashboard');
        return view('profile.dashboard', [
            'title' => 'Dashboard',
            'description' => 'Welcome to your dashboard'
        ]);
    }
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', [
            'title' => 'Edit Profile',
            'description' => 'Update your personal information',
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        //dd($user);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'updated_at' => now()
            ]);

        return redirect()->route('edit-profile')->with('success', 'Profile updated successfully');
    }

    public function edit_password()
    {
        return view('profile.edit_password', [
            'title' => 'Edit Password',
            'description' => 'Update your password'
        ]);
    }

    public function update_password(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Get current user
        $user = DB::table('users')
            ->where('id', $user->id)
            ->first();

        // Check old password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect'
            ]);
        }

        // Update new password
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('edit-password')
            ->with('success', 'Password updated successfully!');
    }
}
