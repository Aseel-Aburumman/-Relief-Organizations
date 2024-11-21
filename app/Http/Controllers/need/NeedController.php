<?php

namespace App\Http\Controllers\Need;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; // Import the Category model
use App\Models\Need;
use App\Models\Language;
use App\Models\NeedDetail;
use Illuminate\Support\Facades\App;
use App\Models\NeedImage;
use App\Http\Requests\NeedRequest;
use App\Models\Organization;

class NeedController extends Controller
{

    // public function index(Request $request)
    // {

    //     $categories = Category::all();

    //     $urgencies = Need::select('urgency')->distinct()->pluck('urgency');
    //     $statuses = Need::select('status')->distinct()->pluck('status');

    //     $filters = $request->only(['category_id', 'urgency', 'status', 'organization_id']);

    //     $needs = Need::getAllNeeds($filters);


    //     return view('need.needs', compact('needs', 'categories', 'urgencies', 'statuses'));
    // }

    public function index(Request $request)
{
    // $categories = Category::all(); // جلب جميع الفئات من جدول الفئات
    // $urgencies = Need::select('urgency')->distinct()->pluck('urgency');
    // $statuses = Need::select('status')->distinct()->pluck('status');

    // $filters = $request->only(['category_id', 'urgency', 'status', 'organization_id']);

    // $needs = Need::with(['image', 'needDetail'])->when($filters, function ($query) use ($filters) {
    //     if (!empty($filters['category_id'])) {
    //         $query->where('category_id', $filters['category_id']);
    //     }

    //     if (!empty($filters['urgency'])) {
    //         $query->where('urgency', $filters['urgency']);
    //     }

    //     if (!empty($filters['status'])) {
    //         $query->where('status', $filters['status']);
    //     }
    // })->paginate(10);

    return view('need.needs');
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



    public function getallNeed(Request $request)
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;


        $search = $request->input('search');

        $organization = Organization::with(['need.donations'])->where('user_id', auth()->id())->first();

        $needs = Need::where('organization_id', $organization->id)
            ->when($search, function ($query, $search) {
                return $query->where('item_name', 'like', '%' . $search . '%');
            })
            ->with(['needDetail' => function ($query) use ($languageId) {
                $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
            }])
            ->get();



        return view('dashboard.needs.manage_needs', compact('needs'));
    }

    public function disable_need($organizationId)
    {
        $needs = Need::where('organization_id', $organizationId)->update(['status' => 'disabled']);

        return redirect()->back()->with('success', 'All needs for this organization have been disabled.');
    }

    public function create_Need()
    {
        $organization = Organization::where('user_id', auth()->id())->first();
        $languages = Language::all();
        $categories = Category::all();
        return view('dashboard.needs.create_need', compact('categories', 'organization', 'languages'));
    }

    public function storeNeed(NeedRequest  $request)
    {

        $need = Need::create([
            'organization_id' => $request->organization_id,
            'quantity_needed' => $request->quantity_needed,
            'urgency' => $request->urgency,
            'status' => $request->status,
            'donated_quantity' => 0,
            'category_id' => $request->category_id,
        ]);



        if ($request->filled('item_name')) {
            foreach ($request->item_name as $languageCode => $itemName) {
                NeedDetail::create([
                    'need_id' => $need->id,
                    'item_name' => $itemName,
                    'description' => $request->description[$languageCode] ?? '',
                    'language_id' => Language::where('key', $languageCode)->first()->id,
                ]);
            }
        }

        // Handle the Image Upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('need_images', 'public');

            // Create an Image record
            NeedImage::create([
                'need_id' => $need->id,
                // 'organization_id' => $need->organization_id,
                'image' => $imagePath,
            ]);
        }

        return redirect()->route('orgnization.manage_Needs')->with('success', 'Need created successfully.');
    }

    public function edit_Need()
    {
        $organization = Organization::where('user_id', auth()->id())->first();
        $languages = Language::all();
        $categories = Category::all();
        return view('dashboard.needs.create_need', compact('categories', 'organization', 'languages'));
    }
}
