<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import nécessaire pour supprimer les anciennes images
use Illuminate\Support\Facades\Auth; // Pour récupérer l'utilisateur connecté

class ProfileController extends Controller
{
    public function show() {
        return view('profile', ['user' => Auth::user()]);
    }

    public function update(Request $request) {
        $user = Auth::user();

        // 1. Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2Mo
        ]);

        // 2. Gestion de l'Upload de l'image
        if ($request->hasFile('photo')) {
            // A. Supprimer l'ancienne photo s'il y en a une (pour ne pas encombrer le serveur)
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // B. Sauvegarder la nouvelle
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        // 3. Mise à jour des infos
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}