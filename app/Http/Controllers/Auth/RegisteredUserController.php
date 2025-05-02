<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Notifications\UserUnderReview;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:32'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'id_front' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'id_back' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Create user with status pending (files will be added after user is created)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => 'pending',
            'password' => Hash::make($request->password),
        ]);

        // Assign the 'user' role
        $user->assignRole('user');

        // Store files in public/users/{user_id}/
        $dir = 'users/' . $user->id;
        $user->profile_photo = $request->file('profile_photo')->store($dir, 'public');
        $user->id_front = $request->file('id_front')->store($dir, 'public');
        $user->id_back = $request->file('id_back')->store($dir, 'public');
        $user->save();

        // TODO: Send 'account under review' notification to user
        $user->notify(new UserUnderReview());

        // Do not log in user after registration
        // event(new Registered($user));
        // Auth::login($user);

        return redirect(route('login'))->with('status', 'Your account is under review. You will be notified once approved.');
    }
}
