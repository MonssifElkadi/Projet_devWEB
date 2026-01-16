<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    // 1. Redirect the user to the provider (Google/GitHub)
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // 2. Handle the callback (User comes back)
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login cancelled or failed.');
        }

        // Check if user already exists
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Update the ID and Login
            if ($provider == 'google') { $user->google_id = $socialUser->getId(); }
            if ($provider == 'github') { $user->github_id = $socialUser->getId(); }
            $user->save();

            Auth::login($user);
            return redirect()->route('home');
        } else {
            // Create a new user
            $newUser = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname(), // GitHub uses nickname sometimes
                'email' => $socialUser->getEmail(),
                'password' => null, // No password needed
                'role' => 'internal', // Default role
                'is_active' => true, // We trust social login, so we activate them automatically
                'google_id' => ($provider == 'google') ? $socialUser->getId() : null,
                'github_id' => ($provider == 'github') ? $socialUser->getId() : null,
            ]);

            Auth::login($newUser);
            return redirect()->route('home');
        }
    }
}