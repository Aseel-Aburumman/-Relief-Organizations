<?php

namespace App\Http\Controllers\Orgnization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\OrgnizationImage;
use App\Models\Language;

use App\Models\NeedDetail;
use App\Models\Post;

use Illuminate\Support\Facades\App;

use App\Models\NeedImage;
use App\Http\Requests\OrganizationRequest;

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

        return view('dashboard.organization_dashboard', compact('organization', 'needs', 'totalDonatedQuantity', 'totalDonations'));
    }

    public function getOne($id)
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;

        $organization = Organization::with(['userDetail' => function ($query) use ($languageId) {
            $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
        }])
            ->find($id);
        $OrgnizationImages = OrgnizationImage::where('organization_id', $id)->first();

        $needs = Need::with(['needDetail' => function ($query) use ($languageId) {
            $query->where('language_id', $languageId)
                ->select('id', 'need_id', 'item_name', 'description');
        }])
            ->where('organization_id', $id)
            ->paginate(10);


        $posts = Post::with('images')
            ->where('lang_id', $languageId)
            ->where('organization_id', $id)
            ->paginate(10);
        return view('organization.organization_profile', compact('organization', 'OrgnizationImages', 'needs', 'posts'));
    }

    public function getAll()
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;

        $organizations = Organization::with(['userDetail' => function ($query) use ($languageId) {
            $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
        }])
            ->paginate(12);
        $OrgnizationImages = OrgnizationImage::get();


        return view('organization.all_orgnization', compact('organizations', 'OrgnizationImages'));
    }

    public function create()
    {
        return view('organization.create');
    }

    public function store(OrganizationRequest $request)
    {
        Organization::create($request->validated());
        return redirect()->route('organization.index')->with('success', 'Organization created successfully!');
    }
    public function index()
    {
        $organizations = Organization::all();
        return view('organization.index', compact('organizations'));
    }
    public function edit($id)
    {
        $organization = Organization::with('userDetail', 'image')->findOrFail($id);

        return view('organization.edit_organization', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        // تحقق من البيانات المدخلة
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_info' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // تحديث البيانات في جدول Organization
        $organization = Organization::findOrFail($id);
        $organization->contact_info = $request->contact_info;
        $organization->save();

        // تحديث البيانات في جدول UserDetail
        $userDetail = $organization->userDetail->first();
        if ($userDetail) {
            $userDetail->name = $request->name;
            $userDetail->location = $request->location;
            $userDetail->description = $request->description;
            $userDetail->save();
        }

        // تحديث الصورة إذا تم رفعها
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/orgnization_images'), $imageName);

            if ($organization->image->isNotEmpty()) {
                $organization->image->first()->update(['image' => $imageName]);
            } else {
                $organization->image()->create(['image' => $imageName]);
            }
        }

        return redirect()->route('orgnization.edit_organization', $id)
            ->with('success', 'Organization updated successfully.');
    }
}
