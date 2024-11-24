<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Post;
use App\Models\Donation;
use App\Models\Need;
use App\Models\UserDetail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function Profile()
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;

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





        return view('dashboard.profile', compact('user', 'userDetail', 'organizationDetail','countries'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user = User::find(Auth::user()->id);

        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'contact_info' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Update organization details for organizations
        if ($user->hasRole('orgnization') && $user->organization) {
            $organization = $user->organization;
            $organization->contact_info = $request->input('contact_info');
            $organization->description = $request->input('description');

            // Handle profile image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('orgnization_images', 'public');
                $organization->image()->updateOrCreate(
                    ['orgnization_id' => $organization->id],
                    ['image' => $imagePath]
                );
            }

            $organization->save();
        }

        // Update user details (name, address) in multiple languages
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];
        foreach ($languageMap as $lang => $langId) {
            $user->userDetail()->updateOrCreate(
                ['language_id' => $langId],
                ['address' => $request->input('address')]
            );
        }

        // Redirect back with a success message
        return redirect()->route('profile.view')->with('success', 'Profile updated successfully.');
    }


    public function doner_dashboard()
    {
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;


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
}
