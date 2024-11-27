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

    // public function updateProfile(Request $request)
    // {
    //     try {
    //         $user = Auth::user();
    //         $user = User::find(Auth::user()->id);

    //         if ($user->hasRole('organization')) {
    //             // Update general user fields
    //             $user->email = $request->email;
    //             $user->password = Hash::make($request->password);
    //             $user->save();

    //             // Update organization-specific details
    //             if ($request->has('contact_info')) {
    //                 $user->organization->contact_info = $request->contact_info;
    //                 $user->organization->save();
    //             }

    //             // Handle multilingual organization details
    //             $organizationDetails = $request->except(['email', 'password', 'contact_info', 'image']);
    //             foreach ($organizationDetails as $key => $value) {
    //                 preg_match('/\((en|ar)\)$/', $key, $matches);
    //                 if ($matches) {
    //                     $language = $matches[1];
    //                     $attribute = strtok($key, '(');
    //                     $detail = UserDetail::updateOrCreate(
    //                         [
    //                             'organization_id' => $user->organization->id,
    //                             'language_id' => $language === 'en' ? 1 : 2,
    //                         ],
    //                         [
    //                             $attribute => $value,
    //                         ]
    //                     );
    //                 }
    //             }

    //             // Handle image upload
    //             if ($request->hasFile('image')) {
    //                 $path = $request->file('image')->store('public/images');
    //                 $user->organization->profile_picture = $path;
    //                 $user->organization->save();
    //             }
    //         } elseif ($user->hasRole('doner')) {
    //             // Update donor general fields
    //             $user->email = $request->email;
    //             $user->password = Hash::make($request->password);
    //             $user->save();

    //             // Handle multilingual donor details
    //             $donorDetails = $request->except(['email', 'password', 'address']);
    //             foreach ($donorDetails as $key => $value) {
    //                 preg_match('/\((en|ar)\)$/', $key, $matches);
    //                 if ($matches) {
    //                     $language = $matches[1];
    //                     $attribute = strtok($key, '(');
    //                     $detail = UserDetail::updateOrCreate(
    //                         [
    //                             'user_id' => $user->id,
    //                             'language_id' => $language === 'en' ? 1 : 2,
    //                         ],
    //                         [
    //                             $attribute => $value,
    //                         ]
    //                     );
    //                 }
    //             }

    //             // Update address
    //             if ($request->has('address')) {
    //                 $userDetail = UserDetail::firstOrCreate(
    //                     ['user_id' => $user->id, 'language_id' => 1],
    //                     ['address' => $request->address]
    //                 );
    //                 $userDetail->address = $request->address;
    //                 $userDetail->save();
    //             }
    //         }

    //         return redirect()->route('profile.view')->with('success', 'Profile updated successfully.');
    //     } catch (\Exception $e) {
    //         Log::error('Error updating profile: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'An error occurred while updating the profile. Please try again.');
    //     }
    // }
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



    public function doner_dashboard()
    {
        $languageId = Language::getLanguageIdByLocale();



        $user = Auth::user();
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('doner')) {


            $donations = Donation::where('user_id', $user->id);
            $needs = Need::with(['needDetail' => function ($query) use ($languageId) {
                $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
            }])
                ->take(4)
                ->get();


            $posts = Post::with('images')
                ->where('lang_id', $languageId)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return view('dashboard.doner_dashboard', compact('donations', 'needs', 'posts'));
        } else {
            return redirect()->route('index')->with('error', 'dont have the right roles');
        }
    }

    public function admin_dashbored()
    {
        $totalUsers = User::count();
        $totalOrganizations = Organization::count();
        $totalPosts = Post::count();
        $fullyDonatedNeedsCount = Need::whereColumn('quantity_needed', 'donated_quantity')->count();

        return view('dashboard.admin_dashboard', compact('totalUsers', 'totalOrganizations', 'totalPosts','fullyDonatedNeedsCount'));
    }
}
