<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Organization;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterOrganizationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\OrganizationResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Rinvex\Country\CountryLoader;
use App\Models\Language;

class AuthController extends Controller
{

    public function showRegisterFormUser()
    {
        $countries = countries();

        return view('Auth.signup', compact('countries'));
    }

    public function register(RegisterRequest $request)
    {
        $countries = countries();

        $languageId = Language::getLanguageIdByLocale();


        $userData = $request->only(['email', 'password']);

        $user = User::createUser($userData);


        $role = Role::where('name', 'doner')->first();
        $user->assignRole($role);

        $details = [
            [
                'name' => $request->name,
                'address' => $request->address,
                'user_id' => $user->id,
                'language_id' =>  $languageId,
            ]

        ];


        UserDetail::createMultipleUserDetails($details);

        // $user->givePermissionTo('create order');
        // return new UserResource($user);

        // return route('register.view')->with('success', 'User registered successfully');
        return view('Auth.signup', ['success' => 'User registered successfully'], compact('countries'));
    }

    public function showRegisterFormOrganization()
    {
        $countries = countries();

        return view('Auth.signup_org', compact('countries'));
    }

    public function registerOrganization(RegisterOrganizationRequest $request)
    {
        // Get countries (you might want to verify that $countries is used properly)
        $countries = countries();

        $languageId = Language::getLanguageIdByLocale();


        // Create user data
        $userData = $request->only(['email', 'password']);
        $userData['password'] = bcrypt($userData['password']); // Hash password
        $user = User::create($userData);

        if (!$user) {
            return response()->json(['error' => 'Failed to create user'], 500);
        }

        // Check for file upload and store the certificate image
        $organizationData = [];
        if ($request->hasFile('certificate_image')) {
            $imagePath = $request->file('certificate_image')->store('certificate_images', 'public');
            // Prepare organization data
            $organizationData = [
                'user_id' => $user->id,
                'contact_info' => $request->contact_info,
                'certificate_image' => $imagePath,
                'status' => 'Pending', // Change status to "Pending" for initial submission
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
                    'name' => $request->name,
                    'description' => $request->description ?? '',
                    'address' => $request->address,
                    'language_id' => $languageId,
                    'organization_id' => $organization->id,
                ],
            ];
            UserDetail::createMultipleUserDetails($details); // Assuming this method exists
        }

        // Return a success response with the countries list for the form
        return view('Auth.signup_org', ['success' => 'Organization registered successfully'], compact('countries'));
    }



    public function showLoginForm()
    {
        return view('Auth.login');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // التأكد من أن `redirect_after_login` يتم الحفاظ عليه عند الخطأ
        if (!session()->has('redirect_after_login')) {
            session()->put('redirect_after_login', url()->previous());
        }

        $redirectTo = session()->get('redirect_after_login', route('index'));

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user = User::find(Auth::user()->id);

            if ($user->hasRole('admin')) {
                session()->forget('redirect_after_login'); // تنظيف الجلسة
                return redirect()->route('admin.dashboard')->with([
                    'success' => 'Admin login successful',
                ]);
            } elseif ($user->hasRole('doner')) {
                session()->forget('redirect_after_login'); // تنظيف الجلسة
                return redirect($redirectTo)->with([
                    'success' => 'Login successful',
                    // 'user' => new UserResource($user)
                ]);
            } elseif ($user->hasRole('organization')) {
                session()->forget('redirect_after_login'); // تنظيف الجلسة
                return redirect()->route('organization.dashboard')->with([
                    'success' => 'Login successful',
                ]);
            }
        }

        // عند حدوث خطأ في تسجيل الدخول، احتفظ بالـ redirect_after_login
        return back()->withErrors(['login_error' => 'Invalid email or password']);
    }



    public function logout()
    {
        Auth::logout();


        return redirect()->route('login.view')->with('success', 'Logged out successfully');
    }
}
