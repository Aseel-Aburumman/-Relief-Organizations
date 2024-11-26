<?php

namespace App\Http\Controllers\Organization;
use Rinvex\Country\CountryLoader;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Need;
use App\Models\OrganizationImage;
use App\Models\Language;
use Spatie\Permission\Models\Role;

use App\Models\NeedDetail;
use App\Models\Post;
use App\Models\User;
use App\Models\UserDetail;

use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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

            return view('organization.organization_profile', compact('organization', 'OrganizationImages', 'needs', 'posts'));
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
    $countries = countries();

    $languages = Language::all();
    return view('dashboard.organization.create_organization',compact('languages','countries'));
}

public function store(Request $request)
{
        // dd('Request received', $request->all());

    // try {
        // التحقق من صحة البيانات
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'contact_info' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'proof_image' => 'required',
            'organization_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // رفع الصور
        $proofImagePath = null;
        $organizationImagePath = null;



        $userData = $request->only(['email', 'password']);
        $userData['password'] = bcrypt($userData['password']); // Hash password
        $user = User::create($userData);

        $organizationData = [];
        if ($request->hasFile('proof_image')) {
            $proofImagePath = $request->file('proof_image')->store('certificate_images', 'public');
            // Prepare organization data
            $organizationData = [
                'user_id' => $user->id,
                'contact_info' => $request->contact_info,
                'certificate_image' => $proofImagePath,
                'status' => 'Approved', // Change status to "Pending" for initial submission
            ];

            // Create organization
            $organization = Organization::create($organizationData);

            if (!$organization) {
                return response()->json(['error' => 'Failed to create organization'], 500);
            }

            // Assign organization role to the user
            $role = Role::where('name', 'organization')->first();
            if ($role) {
                $user->assignRole($role);
            }

            // Add organization details
            $details = [
                [
                    'name' => $request->name_en,
                    'description' => $request->description_en ?? '',
                    'address' => $request->address,
                    'language_id' => 1,
                    'organization_id' => $organization->id,
                ],
                [
                    'name' => $request->name_ar,
                    'description' => $request->description_ar ?? '',
                    'address' => $request->address,
                    'language_id' => 2,
                    'organization_id' => $organization->id,
                ],
            ];
            UserDetail::createMultipleUserDetails($details); // Assuming this method exists
            if ($request->hasFile('organization_image')) {
                $organizationImagePath = $request->file('organization_image')->store('organization_images', 'public');

                OrganizationImage::create([
                    'organization_id' => $organization->id,
                'image' => $organizationImagePath,

                ]);


            }
        }




        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('organization.manage_organization')->with('success', 'Organization created successfully.');
    // } catch (\Exception $e) {
    //     // تسجيل الخطأ وإعادة التوجيه مع رسالة خطأ
    //     Log::error('Error creating organization: ' . $e->getMessage());
    //     return redirect()->back()->with('error', 'An error occurred while creating the organization. Please try again.');
    // }
}


public function index()
{
    // عرض المنظمات التي حالتها "approved" فقط
    $organizations = Organization::where('status', 'approved')->get();

    // تمرير المنظمات إلى الواجهة (view)
    return view('dashboard.organization.manage_organization', compact('organizations'));
}
public function edit($id)
{
    $organization = Organization::with(['userDetail.language', 'image'])->findOrFail($id);
    $languages = Language::all();
    $organizationDetails = $organization->userDetail;

    return view('dashboard.organization.edit_organization', compact('organization', 'languages', 'organizationDetails'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|array',
        'name.*' => 'required|string|max:255',
        'description' => 'nullable|array',
        'description.*' => 'nullable|string',
        'contact_info' => 'nullable|string|max:255',
        'address' => 'nullable|string|max:255',
        'proof_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'organization_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $organization = Organization::findOrFail($id);

    // Update general fields
    $organization->contact_info = $request->contact_info;
    $organization->save();

    // Update details per language
    foreach ($request->name as $languageId => $name) {
        $detail = $organization->userDetail->where('language_id', $languageId)->first();
        if ($detail) {
            $detail->update([
                'name' => $name,
                'adress' => $request->adress[$languageId] ?? null,

                'description' => $request->description[$languageId] ?? null,
            ]);
        }
    }

    // Update images
    if ($request->hasFile('proof_image')) {
        $proofImagePath = $request->file('proof_image')->store('certificate_images', 'public');
        $organization->certificate_image = $proofImagePath;
        $organization->save();
    }

    if ($request->hasFile('organization_image')) {
        $organizationImagePath = $request->file('organization_image')->store('organization_images', 'public');
        $organization->image()->create(['image' => $organizationImagePath]);
    }

    return redirect()->route('organization.manage_organization')->with('success', 'Organization updated successfully.');
}



    public function destroy($id)
{
    // منطق الحذف هنا
    $organization = Organization::findOrFail($id); // استبدل Organization بالنموذج الخاص بك
    $organization->delete();

    return redirect()->route('organization.manage_organization')
                     ->with('success', 'Organization deleted successfully!');
}
public function showPendingOrganizations()
{
    $languageId = Language::getLanguageIdByLocale();

    // استعلام لجلب المنظمات التي حالتها "Pending"
    $organizations = Organization::with(['userDetail'])
    ->where('status', 'pending')
    ->get();
    // dd( $organizations );
    // عرض المنظمات في الصفحة
    return view('dashboard.organization.pending', compact('organizations'));
}

// تحديث حالة المنظمة (Approve / Reject)
public function updateOrganizationStatus($id, Request $request)
{
    // تحديث حالة المنظمة باستخدام استعلام مباشر
    DB::table('organizations')
        ->where('id', $id)
        ->update(['status' => $request->status]);

    // إعادة توجيه إلى صفحة المنظمات "Pending"
    return redirect()->route('organization.pending');
}
}



