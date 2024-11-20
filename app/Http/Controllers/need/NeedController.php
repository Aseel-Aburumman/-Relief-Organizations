<?php

namespace App\Http\Controllers\Need;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Need;
use App\Models\Category; // Import the Category model


class NeedController extends Controller
{

    public function index(Request $request)
    {

        $categories = Category::all();

        // Fetch unique urgency and status values for the filters
        $urgencies = Need::select('urgency')->distinct()->pluck('urgency');
        $statuses = Need::select('status')->distinct()->pluck('status');

        $filters = $request->only(['category_id', 'urgency', 'status', 'organization_id']);

        $needs = Need::getAllNeeds($filters);

        return view('need.needs', compact('needs', 'categories', 'urgencies', 'statuses'));
    }



    // Show a single need
    public function show($id)
    {
        $need = Need::getNeedById($id);

        if (!$need) {
            return redirect()->route('need')->with('error', 'Need not found');
        }

        return view('need.show', compact('need'));
    }

    // Show the form for creating a new need
    public function create()
    {
        return view('need.create');
    }

    // Store a new need
    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_id' => 'required|integer',
            'category_id' => 'required|integer',
            'item_name' => 'required|string|max:255',
            'language_id' => 'required|integer',
            'quantity_needed' => 'required|integer',
            'donated_quantity' => 'nullable|integer',
            'description' => 'nullable|string',
            'urgency' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:open,closed',
        ]);

        Need::createNeed($data);

        return redirect()->route('need')->with('success', 'Need created successfully');
    }

    // Show the form for editing a need
    public function edit($id)
    {
        $need = Need::getNeedById($id);

        if (!$need) {
            return redirect()->route('need')->with('error', 'Need not found');
        }

        return view('need.edit', compact('need'));
    }

    // Update a need
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'organization_id' => 'required|integer',
            'category_id' => 'required|integer',
            'item_name' => 'required|string|max:255',
            'language_id' => 'required|integer',
            'quantity_needed' => 'required|integer',
            'donated_quantity' => 'nullable|integer',
            'description' => 'nullable|string',
            'urgency' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:open,closed',
        ]);

        $updated = Need::updateNeed($id, $data);

        if (!$updated) {
            return redirect()->route('need')->with('error', 'Need not found');
        }

        return redirect()->route('need')->with('success', 'Need updated successfully');
    }

    // Soft delete a need
    public function destroy($id)
    {
        $deleted = Need::deleteNeed($id);

        if (!$deleted) {
            return redirect()->route('need')->with('error', 'Need not found');
        }

        return redirect()->route('need')->with('success', 'Need deleted successfully');
    }

    // Restore a soft-deleted need
    public function restore($id)
    {
        $restored = Need::restoreNeed($id);

        if (!$restored) {
            return redirect()->route('need')->with('error', 'Need not found or not deleted');
        }

        return redirect()->route('need')->with('success', 'Need restored successfully');
    }

    // Permanently delete a need
    public function forceDelete($id)
    {
        $deleted = Need::forceDeleteNeed($id);

        if (!$deleted) {
            return redirect()->route('need')->with('error', 'Need not found');
        }

        return redirect()->route('need')->with('success', 'Need permanently deleted successfully');
    }
}
