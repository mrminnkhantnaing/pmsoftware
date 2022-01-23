<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show Profile & Edit
    public function index($username) {
        $user = User::where('username', $username)->first();

        return view('auth.profile.index', compact('user'));
    }

    // Update Profile
    public function update(Request $request, $username) {
        $request->validate([
            'name' => 'required',
            'phone_no' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'profile_picture' => 'mimes:png,jpg,jpeg|max:1024'
        ]);


        $user = User::where('username', $username)->first();

        $username = Str::slug($request->username);
        if ($request->profile_picture) {
            $profile_name = $username . '.' . $request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile_pictures'), $profile_name);
        }

        $user->update([
            'name' => $request->name,
            'username' => $user->username !== $username ? $username : $user->username,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'address' => $request->address,
            'profile_picture' => $request->profile_picture ? 'images/profile_pictures/' . $username . '.' . $request->profile_picture->getClientOriginalExtension() : $user->profile_picture,
        ]);

        return redirect()->route('profile.show', $user->username)->with('success', 'Your profile has been successfully updated!');
    }

    // Update Password
    public function updatePassword(Request $request, $username) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = User::where('username', $username)->first();
        $hashedPassword = $user->password;

        if (!Hash::check($request->current_password, $hashedPassword)) {
            return redirect()->route('profile.show', $user->username)->with('error', 'Your password does not match!');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show', $user->username)->with('success', 'Your password has been changed successfully!');
    }
}
