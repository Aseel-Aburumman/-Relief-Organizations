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

        // dd($request);
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;

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
        $countries = countries();

        // dd($request->all());
        $locale = session('locale', 'en');
        $languageMap = [
            'en' => 1, // English language_id
            'ar' => 2, // Arabic language_id
        ];

        $languageId = $languageMap[$locale] ?? 1;
        // Step 1: Create the user

        $userData = $request->only(['email', 'password']);
        // $userData['password'] = bcrypt($userData['password']);
        $user = User::createUser($userData);

        // Step 2: Create the organization using the model's static method
        $organizationData = [
            'user_id' => $user->id,
            'contact_info' => $request->contact_info,
        ];
        $organization = Organization::createOrganization($organizationData);
        if (!$organization) {
            return response()->json(['error' => 'Failed to create organization'], 500);
        }
        $role = Role::where('name', 'organization')->first();
        $user->assignRole($role);

        // Step 3: Add organization details using the model's method
        $details = [
            [
                'name' => $request->name,
                'description' => $request->description ?? '',
                'address' => $request->address,
                'language_id' => $languageId,
                'organization_id' => $organization->id,

            ],

        ];
        // $organization->addOrganizationDetails($details);
        UserDetail::createMultipleUserDetails($details);


        // Step 5: Return response
        // return new OrganizationResource($organization);
        return view('Auth.signup_org', ['success' => 'Organization registered successfully'], compact('countries'));
    }



    public function showLoginForm()
    {
        return view('Auth.login');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user = User::find(Auth::user()->id);


            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard')->with([
                    'success' => 'Admin login successful',
                ]);
            } elseif ($user->hasRole('doner')) {
                return redirect()->route('index')->with([
                    'success' => 'Login successful',
                    // 'user' => new UserResource($user)
                ]);
            } elseif ($user->hasRole('orgnization')) {
                return redirect()->route('index')->with([
                    'success' => 'Login successful',
                ]);
            }
        }


        return back()->withErrors(['login_error' => 'Invalid email or password']);
    }

    public function logout()
    {
        Auth::logout();


        return redirect()->route('login.view')->with('success', 'Logged out successfully');
    }
}
