<?php

namespace App\Http\Controllers\Need;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Log;

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


    public function index(Request $request)
    {


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
        try {
            $languageId = Language::getLanguageIdByLocale();
            $search = $request->input('search');
            $user = Auth::user();

            if (!$user) {
                return redirect()->route('index')->with('error', 'User not authenticated');
            }

            $user = User::find($user->id);

            if ($user->hasRole('admin')) {
                $needs = Need::fetchNeeds($search, $languageId);
            } elseif ($user->hasRole('organization')) {
                $organization = Organization::fetchOrganizationWithNeedsAndDonations(auth()->id());


                if (!$organization) {
                    return redirect()->route('index')->with('error', 'Organization not found');
                }

                $needs = Need::fetchNeedsByOrganization($organization->id, $search, $languageId);
            } else {
                return redirect()->route('index')->with('error', 'You do not have the appropriate role');
            }
            return view('dashboard.needs.manage_needs', compact('needs'));
        } catch (\Exception $e) {
            Log::error('Error fetching needs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching the needs. Please try again.');
        }
    }


    public function destroy($id)
    {
        try {
            $deleted = Need::deleteNeed($id);
            $deletedNeedDetail = NeedDetail::deleteNeedDetail($id);
            $deletedNeedImage = NeedImage::deleteNeedImage($id);

            if (!$deleted) {
                return redirect()->route('need')->with('error', 'Need not found');
            }

            return redirect()->route('organization.manage_Needs')->with('success', 'Need deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting need: ' . $e->getMessage());
            return redirect()->route('organization.manage_Needs')->with('error', 'An error occurred while deleting the need. Please try again later.');
        }
    }


    public function create_Need()
    {
        $organization = Organization::where('user_id', auth()->id())->first();
        $languages = Language::all();
        $categories = Category::all();
        return view('dashboard.needs.create_need', compact('categories', 'organization', 'languages'));
    }

    public function storeNeed(NeedRequest $request)
    {
        try {
            $needData = $request->only([
                'organization_id',
                'category_id',
                'quantity_needed',
                'urgency',
                'status',
            ]);
            $needData['donated_quantity'] = 0;
            $need = Need::createNeed($needData);

            if ($request->filled('item_name')) {
                NeedDetail::createNeedDetailsWithLang($need->id, $request->only(['item_name', 'description']));
            }

            if ($request->hasFile('image')) {
                NeedImage::uploadNeedImage($need->id, $request->file('image'));
            }

            return redirect()->route('organization.manage_Needs')->with('success', 'Need created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Need: ' . $e->getMessage());

            return redirect()->route('organization.manage_Needs')->with('error', 'An error occurred while creating the need. Please try again later.');
        }
    }



    public function editNeed($id)
    {
        $need = Need::getNeedById($id);
        $needDetails = NeedDetail::getByNeedId($id);
        $categories = Category::all();
        $languages = Language::all();
        $currentImageS = NeedImage::where('need_id', $id)->get();

        return view('dashboard.needs.edit_need', compact('need', 'needDetails', 'categories', 'languages', 'currentImageS'));
    }

    public function updateNeed(NeedRequest $request, $id)
    {
        try {
            $needData = $request->only([
                'quantity_needed',
                'urgency',
                'status',
                'category_id',
            ]);
            $need = Need::updateNeed($id, $needData);

            if ($request->filled('item_name')) {
                NeedDetail::updateNeedDetails($id, $request->only(['item_name', 'description']));
            }

            if ($request->hasFile('image')) {
                NeedImage::uploadNeedImage($id, $request->file('image'));
            }

            return redirect()->route('organization.manage_Needs')->with('success', 'Need updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Need: ' . $e->getMessage());

            return redirect()->route('organization.manage_Needs')->with('error', 'An error occurred while updating the need. Please try again later.');
        }
    }


    public function deleteNeedImage($imageId)
    {
        $image = NeedImage::findOrFail($imageId);

        Storage::disk('public')->delete('need_images/' . $image->image);

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
