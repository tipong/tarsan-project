<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, \App\Services\CloudinaryService $cloudinary)
{
    $user = $request->user();

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required', 'email',
            'max:255',
            'unique:users,email,' . $user->id
        ],
        'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ]);

    // Upload photo if there is
    if ($request->hasFile('photo')) {

        // Delete old photo
        if ($user->photo) {
            $cloudinary->delete($user->photo);
        }

        $path = $cloudinary->upload($request->file('photo'), 'profile-photos');

        $user->photo = $path;
    }

    $user->name = $request->name;
    $user->email = $request->email;

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return back()->with('status', 'profile-updated');
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
