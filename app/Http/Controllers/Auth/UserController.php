<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Organization;

use App\Models\User;
use App\Models\Post;
use App\Models\Donation;
use App\Models\Need;
use App\Models\UserDetail;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function Profile()
    {
        $languageId = Language::getLanguageIdByLocale();


        $user = Auth::id();

        if ($user) {
            $user = User::with(['userDetail' => function ($query) use ($languageId) {
                $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
            }])->find($user);
        }
        // $userDetail = $user->userDetail->first();
        $userDetail = $user->userDetail ?? [];
        $organizationDetail = $user->organization->userDetail ?? [];
        $countries = countries();
        $languages = Language::all();





        return view('dashboard.profile', compact('user', 'userDetail', 'organizationDetail', 'countries', 'languages'));
    }


    public function updateProfile(Request $request)
    {
        try {
            $user = Auth::user();
            $user = User::find(Auth::user()->id);
            // Update general user fields
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // Handle multilingual fields
            $languages = $request->input('name', []);
            foreach ($languages as $langKey => $name) {
                $languageId = Language::where('key', $langKey)->first()->id;

                if ($user->hasRole('organization')) {
                    UserDetail::updateOrCreate(
                        [
                            'organization_id' => $user->organization->id,
                            'language_id' => $languageId,
                        ],
                        [
                            'name' => $name,
                            'description' => $request->input("description.$langKey", ''),
                        ]
                    );
                } elseif ($user->hasRole('doner')) {
                    UserDetail::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'language_id' => $languageId,
                        ],
                        [
                            'name' => $name,
                        ]
                    );
                }
            }

            // Update organization-specific fields
            if ($user->hasRole('organization') && $request->has('contact_info')) {
                $user->organization->contact_info = $request->contact_info;
                $user->organization->save();
            }

            return redirect()->route('profile.view')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the profile. Please try again.');
        }
    }



    public function doner_dashboard(Request $request)
    {
        try {
            $languageId = Language::getLanguageIdByLocale();
            $user = Auth::user();
            $user = User::find($user->id);
            $search = $request->input('search');
            $filterDate = $request->input('filter_date');

            $donationsQuery = Donation::with([
                'need.needDetail' => function ($query) use ($languageId) {
                    $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
                },
                'need.organization'
            ])
                ->where('donor_id', $user->id);

            // Apply search filter by need name
            if ($search) {
                $donationsQuery->whereHas('need.needDetail', function ($query) use ($search) {
                    $query->where('item_name', 'like', '%' . $search . '%');
                });
            }

            // Apply date filter
            if ($filterDate) {
                $donationsQuery->whereDate('created_at', $filterDate);
            }

            $donations = $donationsQuery->orderBy('created_at', 'desc')->paginate(5);

            // Fetch recently added needs
            $needs = Need::with(['needDetail' => function ($query) use ($languageId) {
                $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
            }])
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            // Fetch latest posts (news or updates)
            $posts = Post::with('images')
                ->where('lang_id', $languageId)
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get();

            return view('dashboard.doner_dashboard', compact('donations', 'needs', 'posts'));
        } catch (\Exception $e) {
            Log::error('Error loading donor dashboard: ' . $e->getMessage());
            return redirect()->route('index')->with('error', 'An error occurred while loading the dashboard.');
        }
    }


    public function admin_dashbored()
    {
        $totalUsers = User::count();
        $totalOrganizations = Organization::count();
        $totalPosts = Post::count();
        $fullyDonatedNeedsCount = Need::whereColumn('quantity_needed', 'donated_quantity')->count();

        // عدد المستخدمين حسب الأسبوع
        $weeklyUsers = DB::table('users')
            ->selectRaw('WEEK(created_at) as week, COUNT(*) as count')
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // حالة التبرعات
        $needsStatus = DB::table('needs')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // عدد المنظمات حسب حالة الحساب
        $organizationsStatus = DB::table('organizations')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return view('dashboard.admin_dashboard', compact(
            'totalUsers',
            'totalOrganizations',
            'totalPosts',
            'fullyDonatedNeedsCount',
            'weeklyUsers',
            'needsStatus',
            'organizationsStatus'
        ));
    }
}
