<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\InternalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\MaintenanceController;
// Page d'accueil (Publique) - Affiche les ressources
Route::get('/', [ResourceController::class, 'index'])->name('home');
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/ajax-filter', [ResourceController::class, 'ajaxFilter'])->name('resources.filter');
Route::get('/rules', [GuestController::class, 'rules'])->name('rules');

// Authentification (Manuelle car pas de Breeze/Jetstream)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Espace Admin (Protégé par Middleware)
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard Admin (Gestion Utilisateurs)
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Actions sur les Utilisateurs (Activer / Changer rôle)
    Route::patch('/admin/users/{user}/activate', [AdminController::class, 'activate'])->name('admin.users.activate');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');

    // Ressources (LECTURE SEULE UNIQUEMENT)
    // On garde juste le "get" (index), on a supprimé "create", "store", "update", "destroy"
    Route::get('/admin/resources', [ResourceController::class, 'adminIndex'])->name('admin.resources.index');

    // Dans le groupe middleware(['auth'])
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update'); // <--- AJOUTE ÇA

    // Route pour DÉSACTIVER
    Route::patch('/admin/users/{user}/deactivate', [AdminController::class, 'deactivate'])->name('admin.users.deactivate');

    // Route pour SUPPRIMER
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

// Espace Admin et Manager - Gestion des Ressources
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
    Route::patch('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
    Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');
});

// Espace Utilisateur Connecté (Profil)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
   
    Route::get('/admin/resources', [ResourceController::class, 'adminIndex'])->name('admin.resources.index');
    Route::patch('/admin/resources/{resource}/status', [ResourceController::class, 'updateStatus'])->name('admin.resources.status');
});
// --- ESPACE RESPONSABLE (MANAGER) ---
Route::middleware(['auth', 'role:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'index'])->name('manager.dashboard');
    // Plus tard : Route pour valider/refuser une demande
});

// --- ESPACE UTILISATEUR INTERNE ---
Route::middleware(['auth', 'role:internal'])->group(function () {
    Route::get('/internal/dashboard', [InternalController::class, 'index'])->name('internal.dashboard');
    // Plus tard : Route pour créer une réservation
});
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        Session::put('locale', $locale);
    }
    return back(); // Revient à la page précédente
})->name('lang.switch');

// Maintenance Routes (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/maintenances', [MaintenanceController::class, 'index'])->name('maintenances.index');
    Route::get('/maintenances/filter', [MaintenanceController::class, 'ajaxFilter'])->name('maintenances.filter');
    Route::post('/maintenances/{id}/resolve', [MaintenanceController::class, 'resolve'])->name('maintenances.resolve');
});

// Social Login Routes
Route::get('/auth/{provider}/redirect', [SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialController::class, 'callback'])->name('social.callback');