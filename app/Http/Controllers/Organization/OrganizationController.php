<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\OrganizationImage;
use App\Models\Language;

use App\Models\NeedDetail;
use App\Models\Post;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

use App\Models\NeedImage;
use App\Http\Requests\OrganizationRequest;

use Illuminate\Http\Request;

use App\Models\Donation;

class OrganizationController extends Controller
{


    public function dashboard()
    {
        // dd(auth()->id());
        $organization = Organization::fetchOrganizationWithNeedsAndDonations(auth()->id());
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
        try {
            $languageId = Language::getLanguageIdByLocale();

            // Fetch organization with user details
            $organization = Organization::fetchOrganizationWithUserDetails($id, $languageId);

            // Fetch the first organization image
            $OrganizationImages = OrganizationImage::fetchFirstImage($id);

            // Fetch needs with their details
            $needs = Need::fetchNeedsWithDetails($id, $languageId);

            // Fetch posts with images
            $posts = Post::fetchPostsWithImages($id, $languageId);

            return view('organization_profile', compact('organization', 'OrganizationImages', 'needs', 'posts'));
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error fetching organization data: ' . $e->getMessage());

            // Redirect with an error message
            return redirect()->back()->with('error', 'An error occurred while fetching the organization profile. Please try again later.');
        }
    }

    public function getAll()
    {
        $languageId = Language::getLanguageIdByLocale();


        $organizations = Organization::with(['userDetail' => function ($query) use ($languageId) {
            $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
        }])
            ->paginate(12);
        $OrganizationImages = OrganizationImage::get();


        return view('organization.all_organization', compact('organizations', 'OrganizationImages'));
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
            $request->image->move(public_path('storage/organization_images'), $imageName);

            if ($organization->image->isNotEmpty()) {
                $organization->image->first()->update(['image' => $imageName]);
            } else {
                $organization->image()->create(['image' => $imageName]);
            }
        }

        return redirect()->route('organization.edit_organization', $id)
            ->with('success', 'Organization updated successfully.');
    }
}
