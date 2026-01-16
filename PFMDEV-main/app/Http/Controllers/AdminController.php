<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resource; // N'oublie pas cet import pour les stats !

class AdminController extends Controller
{
    // 1. AFFICHER LE DASHBOARD (Avec les stats)
    public function index() {
        // On récupère tous les utilisateurs sauf soi-même
        $users = User::where('id', '!=', auth()->id())->get();
        
        // Calcul des statistiques
        $totalUsers = User::count();
        $totalResources = Resource::count();
        $resourcesOccupied = Resource::where('state', 'occupied')->count();
        $resourcesMaintenance = Resource::where('state', 'maintenance')->count();

        return view('admin.dashboard', compact('users', 'totalUsers', 'totalResources', 'resourcesOccupied', 'resourcesMaintenance'));
    }

    // 2. METTRE À JOUR LE RÔLE
    public function updateRole(Request $request, User $user) {
        $request->validate([
            'role' => 'required|in:admin,manager,internal', // On interdit "guest"
        ]);

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'Rôle mis à jour avec succès.');
    }

    // 3. ACTIVER UN COMPTE (C'est cette méthode qui te manquait !)
    public function activate(User $user) {
        $user->is_active = true;
        $user->save();

        return back()->with('success', 'Compte activé avec succès.');
    }

    // 4. DÉSACTIVER UN COMPTE
    public function deactivate(User $user) {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Impossible de désactiver votre propre compte admin.']);
        }

        $user->is_active = false;
        $user->save();

        return back()->with('success', 'Compte désactivé.');
    }

    // 5. SUPPRIMER UN COMPTE
    public function destroy(User $user) {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Impossible de supprimer votre propre compte admin.']);
        }

        $user->delete();

        return back()->with('success', 'Utilisateur supprimé définitivement.');
    }
}