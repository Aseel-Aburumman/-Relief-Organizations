<?php

namespace App\Http\Controllers\Need;


use App\Models\User;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NeedRequest;
use App\Services\NeedNotificationService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Need;
use App\Models\Language;
use App\Models\NeedDetail;
use App\Models\NeedImage;
use App\Models\Organization;
use Illuminate\Support\Facades\App;

class NeedController extends Controller
{
    protected $notificationService;
    public function __construct(NeedNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
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
        $languageId = Language::getLanguageIdByLocale();

        $user = Auth::user();
        $user = User::find($user->id);
        if ($user->hasRole('admin')) {
            $organization = Organization::fetchOrganizationWithUserDetailsApproved($languageId);
        } elseif ($user->hasRole('organization')) {
            $organization = Organization::where('user_id', auth()->id())->first();
        }
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

            $needDetails = [
                'organization_id' => $request->input('organization_id'),

                'item_name' => $request->input('item_name'),
                'description' => $request->input('description'),
                'category' => Category::find($request->input('category_id'))->name,
                'quantity_needed' => $request->input('quantity_needed'),
                'link' => route('donation.show', ['id' => $need->id]),
            ];
            $this->notificationService->notifyUsers($needDetails);


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













    public function index(Request $request)
    {
        try {
            $languageId = Language::getLanguageIdByLocale();

            $needs = Need::with(['needDetail' => function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            }])->paginate(12);
            return view('need.needs', compact('needs'));
        } catch (\Exception $e) {
            Log::error('Error fetching needs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching the needs.');
        }
    }


    public function show($id)
    {
        try {
            $languageId = Language::getLanguageIdByLocale();

            $need = Need::with(['needDetail' => function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            }])->findOrFail($id);

            return view('need.show', compact('need'));
        } catch (\Exception $e) {
            Log::error('Error fetching need details: ' . $e->getMessage());
            return redirect()->route('need')->with('error', 'An error occurred while fetching the need details.');
        }
    }


    public function create()
    {
        $languages = Language::all();
        $categories = Category::all();

        return view('need.create', compact('categories', 'languages'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_id' => 'required|integer',
            'category_id' => 'required|integer',
            'quantity_needed' => 'required|integer',
            'urgency' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:open,closed',
        ]);

        try {
            $need = Need::create($data);

            foreach ($request->input('item_name') as $languageId => $itemName) {
                NeedDetail::create([
                    'need_id' => $need->id,
                    'language_id' => $languageId,
                    'item_name' => $itemName,
                    'description' => $request->input("description.$languageId"),
                ]);
            }

            if ($request->hasFile('image')) {
                NeedImage::uploadNeedImage($need->id, $request->file('image'));
            }

            return redirect()->route('need')->with('success', 'Need created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating Need: ' . $e->getMessage());
            return redirect()->route('need')->with('error', 'An error occurred while creating the need.');
        }
    }


    public function edit($id)
    {
        $need = Need::findOrFail($id);
        $needDetails = NeedDetail::where('need_id', $id)->get();
        $categories = Category::all();
        $languages = Language::all();

        return view('need.edit', compact('need', 'needDetails', 'categories', 'languages'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'category_id' => 'required|integer',
            'quantity_needed' => 'required|integer',
            'urgency' => 'required|string|in:low,medium,high',
            'status' => 'required|string|in:open,closed',
        ]);

        try {
            $need = Need::findOrFail($id);
            $need->update($data);

            foreach ($request->input('item_name') as $languageId => $itemName) {
                NeedDetail::updateOrCreate(
                    ['need_id' => $id, 'language_id' => $languageId],
                    ['item_name' => $itemName, 'description' => $request->input("description.$languageId")]
                );
            }

            if ($request->hasFile('image')) {
                NeedImage::uploadNeedImage($id, $request->file('image'));
            }

            return redirect()->route('need')->with('success', 'Need updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating Need: ' . $e->getMessage());
            return redirect()->route('need')->with('error', 'An error occurred while updating the need.');
        }
    }
}
