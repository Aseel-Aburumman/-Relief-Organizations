<?php

namespace App\Http\Controllers\Orgnization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\Category;
use App\Models\Language;

use App\Models\NeedDetail;
use Illuminate\Support\Facades\App;

use App\Models\NeedImage;
use App\Http\Requests\NeedRequest;

use Illuminate\Http\Request;

use App\Models\Donation;

class OrgnizationController extends Controller
{


    public function dashboard()
    {
        // dd(auth()->id());
        $organization = Organization::with(['need.donations'])->where('user_id', auth()->id())->first();
        // dd($organization);
        if (!$organization) {
            return redirect()->back()->with('error', 'No organization found for the logged-in user.');
        }
        $needs = $organization->need;
        $totalDonatedQuantity = $needs->sum('donated_quantity');
        $totalDonations = Donation::whereIn('need_id', function ($query) use ($organization) {
            $query->select('id')
                ->from('needs')
                ->where('organization_id', $organization->id);
        })->count();

        return view('orgnization.dashboard', compact('organization', 'needs', 'totalDonatedQuantity', 'totalDonations'));
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



        return view('orgnization.needs.manage_needs', compact('needs'));
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
        return view('orgnization.needs.create_need', compact('categories', 'organization', 'languages'));
    }

    public function storeNeed(NeedRequest  $request)
    {
        // $validated = $request->validate([
        //     'item_name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'quantity_needed' => 'required|integer',
        //     'urgency' => 'required|string',
        //     'status' => 'required|string',
        //     'organization_id' => 'required|string',
        //     'category_id' => 'required|integer',
        //     'language_id' => 1,
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
        $need = Need::create([
            'organization_id' => $request->organization_id,
            'quantity_needed' => $request->quantity_needed,
            'urgency' => $request->urgency,
            'status' => $request->status,
            'donated_quantity' => 0,
            'category_id' => $request->category_id,
        ]);

        // $needDetails = NeedDetail::createMultipleNeedDetails(
        //     [
        //         'need_id' => $need->id,
        //         'item_name' => $request->item_name_en,
        //         'description' => $request->description_en,
        //         'language_id' => 1,
        //     ],
        //     [
        //         'need_id' => $need->id,
        //         'item_name' => $request->item_name_ar,
        //         'description' => $request->description_ar,
        //         'language_id' => 2,
        //     ]
        // );

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
        // Create the Need
        // $need = Need::createNeed($validated);

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
        return view('orgnization.needs.create_need', compact('categories', 'organization', 'languages'));
    }
}
