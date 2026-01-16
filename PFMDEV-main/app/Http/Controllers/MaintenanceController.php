<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        // Only tech and admin can access maintenance page
        if (!auth()->check() || !auth()->user()->canAccessMaintenance()) {
            abort(403, 'Unauthorized access.');
        }

        $query = Resource::with('category')->where('state', 'maintenance');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $resources = $query->get();

        return view('resources.maintenance', compact('resources'));
    }

    public function ajaxFilter(Request $request)
    {
        // Only tech and admin can filter maintenance
        if (!auth()->check() || !auth()->user()->canAccessMaintenance()) {
            abort(403, 'Unauthorized access.');
        }

        $query = Resource::with('category')->where('state', 'maintenance');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'ALL') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        $resources = $query->get();
        return view('resources.partials.grid', compact('resources'));
    }
    
    public function resolve($id)
    {
        // Only tech and admin can resolve maintenance
        if (!auth()->check() || !auth()->user()->canAccessMaintenance()) {
            abort(403, 'Unauthorized action.');
        }

        $resource = Resource::findOrFail($id);
        $resource->update(['state' => 'available']);
        
        return redirect()->back()->with('success', 'Resource repaired and available again!');
    }
}