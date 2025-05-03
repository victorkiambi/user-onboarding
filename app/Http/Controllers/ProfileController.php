<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if ($request->route()->getName() === 'user.profile.edit') {
            return view('user.edit-profile', [
                'user' => $request->user(),
            ]);
        }
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Redirect to the correct profile edit page based on route
        if ($request->route()->getName() === 'user.profile.update') {
            return Redirect::route('user.profile.edit')->with('status', 'profile-updated');
        }
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

    /**
     * Show the form for editing the user's documents.
     */
    public function editDocuments(Request $request)
    {
        return view('profile.edit-documents', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's documents.
     */
    public function updateDocuments(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'id_front' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'id_back' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);
        $dir = 'users/' . $user->id;
        if ($request->hasFile('profile_photo')) {
            $user->profile_photo = $request->file('profile_photo')->store($dir, 'public');
        }
        if ($request->hasFile('id_front')) {
            $user->id_front = $request->file('id_front')->store($dir, 'public');
        }
        if ($request->hasFile('id_back')) {
            $user->id_back = $request->file('id_back')->store($dir, 'public');
        }
        $user->save();
        // Redirect to the correct dashboard based on user role
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('status', 'Documents updated successfully.');
        } elseif ($user->hasRole('user')) {
            return redirect()->route('user.dashboard')->with('status', 'Documents updated successfully.');
        }
        // Fallback for other roles or future extensibility
        return redirect()->route('dashboard')->with('status', 'Documents updated successfully.');
    }
}
