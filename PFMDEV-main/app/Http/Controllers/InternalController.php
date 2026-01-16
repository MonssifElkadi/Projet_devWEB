<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class InternalController extends Controller
{
    public function index() {
        // L'utilisateur interne doit voir les ressources pour pouvoir réserver
        $resources = Resource::where('state', '!=', 'maintenance')->get();
        return view('internal.dashboard', compact('resources'));
    }
}
