<?php

namespace App\Http\Controllers;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Affiche la liste des ressources pour la page publique (accueil)
     * Accessible à tous (connectés et non connectés)
     */
    public function publicIndex()
    {
        $resources = Resource::all();
        return view('resources.index', compact('resources'));
    }

    /**
     * Affiche le tableau de bord des ressources pour l'Admin
     * Accessible uniquement aux administrateurs
     */
    public function adminIndex()
    {
        $resources = Resource::all();
        return view('admin.resources', compact('resources'));
    }

    public function index(Request $request)
    {
        // Page d'accueil - affiche toutes les ressources SAUF maintenance
        $resources = Resource::where('state', '!=', 'maintenance')->get();
        return view('resources.index', compact('resources'));
    }

    public function indexFilter(Request $request)
    {
        $query = \App\Models\Resource::with('category')
                    ->where('state', '!=', 'maintenance');      

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category != 'ALL') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->filled('min_cpu')) {
            $query->where('cpu_cores', '>=', $request->min_cpu);
        }

        if ($request->filled('min_ram')) {
            $query->where('ram_gb', '>=', $request->min_ram);
        }

        if ($request->filled('min_storage')) {
            $query->where('storage_gb', '>=', $request->min_storage);
        }

        $resources = $query->get();

        return view('resources.index', compact('resources'));
    }

    public function ajaxFilter(Request $request)
    {
        $query = Resource::with('category')
                    ->where('state', '!=', 'maintenance');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category && $request->category !== 'ALL') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        if ($request->min_cpu) {
            $query->where('cpu_cores', '>=', $request->min_cpu);
        }

        if ($request->min_ram > 0) {
            $query->whereNotNull('ram_gb')
                  ->where('ram_gb', '>=', $request->min_ram);
        }

        if ($request->min_storage > 0) {
            $query->whereNotNull('storage_gb')
                  ->where('storage_gb', '>=', $request->min_storage);
        }

        $resources = $query->get();
        return view('resources.partials.grid', compact('resources'));
    }

    public function update(Request $request, $id)
    {
        // Only tech and admin can update
        if (!auth()->check() || !auth()->user()->canManage()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $resource = Resource::find($id);
        if (!$resource) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        // Validate required fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'state' => 'required|in:available,maintenance',
            'cpu_cores' => 'nullable|integer|min:0',
            'ram_gb' => 'nullable|integer|min:0',
            'storage_gb' => 'nullable|integer|min:0',
            'storage_type' => 'nullable|string|max:50',
            'bandwidth_mbps' => 'nullable|integer|min:0',
        ]);

        $updateData = [
            'name'  => $validated['name'],
            'state' => $validated['state'],
        ];

        // Add optional fields if provided
        if ($request->filled('cpu_cores')) {
            $updateData['cpu_cores'] = $validated['cpu_cores'];
        }
        if ($request->filled('ram_gb')) {
            $updateData['ram_gb'] = $validated['ram_gb'];
        }
        if ($request->filled('storage_gb')) {
            $updateData['storage_gb'] = $validated['storage_gb'];
        }
        if ($request->filled('storage_type')) {
            $updateData['storage_type'] = $validated['storage_type'];
        }
        if ($request->filled('bandwidth_mbps')) {
            $updateData['bandwidth_mbps'] = $validated['bandwidth_mbps'];
        }

        try {
            Resource::where('id', $id)->update($updateData);
            return response()->json(['success' => true, 'message' => 'Resource updated successfully!'], 200);
        } catch (\Exception $e) {
            \Log::error('Update error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Resource $resource)
    {
        // Only tech and admin can delete
        if (!auth()->check() || !auth()->user()->canManage()) {
            abort(403, 'Unauthorized action.');
        }

        $resource->delete();
        return redirect()->back();
    }

    public function store(Request $request)
    {
        // Only tech and admin can create
        if (!auth()->check() || !auth()->user()->canManage()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:resource_categories,id',
            'state' => 'required|in:available,maintenance',
        ];

        $categoryId = $request->category_id;

        if ($categoryId == 1 || $categoryId == 2) {
            $rules['cpu_cores'] = 'required|integer|min:1';
            $rules['ram_gb'] = 'required|integer|min:1';
            $rules['storage_gb'] = 'required|integer|min:1';
        } elseif ($categoryId == 3) {
            $rules['storage_type'] = 'required|string|max:50';
            $rules['storage_gb'] = 'required|integer|min:1';
        } elseif ($categoryId == 4) {
            $rules['bandwidth_mbps'] = 'required|integer|min:1';
        }

        try {
            $data = $request->validate($rules);
            $resource = Resource::create($data);
            return response()->json(['success' => true, 'message' => 'Resource created!', 'resource' => $resource], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}