<?php

namespace App\Http\Controllers\Need;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Illuminate\Support\Facades\Storage;
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
        $user = Auth::user();
        $user = User::find(Auth::user()->id);

        if ($user->hasRole('admin')) {
            $needs = Need::when($search, function ($query, $search) {
                return $query->where('item_name', 'like', '%' . $search . '%');
            })
                ->with(['needDetail' => function ($query) use ($languageId) {
                    $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
                }])
                ->get();
        } else {
            $organization = Organization::with(['need.donations'])->where('user_id', auth()->id())->first();

            $needs = Need::where('organization_id', $organization->id)
                ->when($search, function ($query, $search) {
                    return $query->where('item_name', 'like', '%' . $search . '%');
                })
                ->with(['needDetail' => function ($query) use ($languageId) {
                    $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
                }])
                ->get();
        }

        return view('dashboard.needs.manage_needs', compact('needs'));
    }

    // Soft delete a need
    public function destroy($id)
    {
        $deleted = Need::deleteNeed($id);
        $deletedNeedDetail = NeedDetail::deleteNeedDetail($id);
        $deletedNeedDetail = NeedImage::deleteNeedImage($id);



        if (!$deleted) {
            return redirect()->route('need')->with('error', 'Need not found');
        }

        return redirect()->route('orgnization.manage_Needs')->with('success', 'Need deleted successfully');
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
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('need_images', $fileName, 'public');
            $imagePath = $fileName;
            NeedImage::create([
                'need_id' => $need->id,
                'image' => $imagePath
            ]);
        }

        return redirect()->route('orgnization.manage_Needs')->with('success', 'Need created successfully.');
    }


    public function editNeed($id)
    {
        $need = Need::findOrFail($id);
        $needDetails = NeedDetail::where('need_id', $id)->get();
        $categories = Category::all();
        $languages = Language::all();
        $currentImageS = NeedImage::where('need_id', $id)->get();

        return view('dashboard.needs.edit_need', compact('need', 'needDetails', 'categories', 'languages', 'currentImageS'));
    }

    public function updateNeed(NeedRequest $request, $id)
    {
        $need = Need::findOrFail($id);

        $need->update([
            'quantity_needed' => $request->quantity_needed,
            'urgency' => $request->urgency,
            'status' => $request->status,
            'category_id' => $request->category_id,
        ]);

        // Update Need Details
        foreach ($request->item_name as $languageCode => $itemName) {
            $languageId = Language::where('key', $languageCode)->first()->id;

            $detail = NeedDetail::where('need_id', $id)->where('language_id', $languageId)->first();
            if ($detail) {
                $detail->update([
                    'item_name' => $itemName,
                    'description' => $request->description[$languageCode] ?? '',
                ]);
            } else {
                NeedDetail::create([
                    'need_id' => $id,
                    'item_name' => $itemName,
                    'description' => $request->description[$languageCode] ?? '',
                    'language_id' => $languageId,
                ]);
            }
        }

        // Update Image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('need_images', $fileName, 'public');
            $imagePath = $fileName;
            NeedImage::create([
                'need_id' => $id,
                'image' => $imagePath
            ]);
        }

        return redirect()->route('orgnization.manage_Needs')->with('success', 'Need updated successfully.');
    }

    public function deleteNeedImage($imageId)
    {
        $image = NeedImage::findOrFail($imageId);

        Storage::disk('public')->delete('need_images/' . $image->image);

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
