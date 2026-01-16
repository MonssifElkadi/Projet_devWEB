<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    
    public function showRegister() { return view('auth.register'); }

   public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // Vérification si actif
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte n\'est pas encore activé.']);
            }

            // Redirection intelligente selon le rôle
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'manager':
                    return redirect()->route('manager.dashboard'); // Vers espace Responsable
                case 'internal':
                    return redirect()->route('internal.dashboard'); // Vers espace Interne
                default:
                    return redirect()->route('home'); // Invité
            }
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }
  public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'internal', 
            'is_active' => false 
        ]);

        return redirect()->route('login')
            ->with('success', 'Votre demande d\'ouverture de compte a été envoyée. Attendez l\'activation par un administrateur.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
    public function profile() {
        return view('auth.profile', ['user' => Auth::user()]);
    }
    // ... tes autres fonctions ...

    public function updateProfile(Request $request) {
        $user = Auth::user();

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            // L'email doit être unique, MAIS on ignore l'ID de l'utilisateur actuel (sinon il se bloque lui-même)
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed', // "nullable" signifie qu'on peut le laisser vide
        ]);

        // Mise à jour des infos de base
        $user->name = $request->name;
        $user->email = $request->email;

        // Mise à jour du mot de passe (seulement si rempli)
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}

