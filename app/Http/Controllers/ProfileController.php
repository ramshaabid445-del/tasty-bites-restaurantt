<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('backend.profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information (Name, Email, Password, Avatar).
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validation logic
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'confirmed', 'min:8'], // Password field optional rakha hai
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
        ]);

        // 1. Name aur Email fill karein
        $user->fill($request->only('name', 'email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // 2. Password handle karein (agar user ne input kiya hai)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 3. Avatar Upload handle karein
        if ($request->hasFile('avatar')) {
            // Purani picture delete karein agar default nahi hai
            if ($user->avatar && File::exists(public_path('uploads/avatars/' . $user->avatar))) {
                File::delete(public_path('uploads/avatars/' . $user->avatar));
            }

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            
            // Folder nahi bana toh bana dega
            if (!File::isDirectory(public_path('uploads/avatars'))) {
                File::makeDirectory(public_path('uploads/avatars'), 0777, true, true);
            }

            $avatar->move(public_path('uploads/avatars'), $filename);
            $user->avatar = $filename;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}