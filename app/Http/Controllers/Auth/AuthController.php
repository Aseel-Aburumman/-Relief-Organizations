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

class AuthController extends Controller
{

    public function showRegisterFormUser()
    {
        return view('Auth.signup');
    }

    public function register(RegisterRequest $request)
    {

        $user = User::createUser($request->validated());


        $role = Role::where('name', 'doner')->first();
        $user->assignRole($role);

        $details = [
            [
                'name' => $request->name_en,
                'location' => $request->location_en,
                'user_id' => $user->id,
                'language_id' => 1, // English
            ],
            [
                'name' => $request->name_ar,
                'user_id' => $user->id,
                'location' => $request->location_ar,
                'language_id' => 2, // Arabic
            ],
        ];


        UserDetail::createMultipleUserDetails($details);

        // $user->givePermissionTo('create order');
        // return new UserResource($user);

        return redirect()->route('register.view')->with('success', 'User registered successfully');
    }

    public function showRegisterFormOrganization()
    {
        return view('Auth.signup_org');
    }

    public function registerOrganization(RegisterOrganizationRequest $request)
    {
        // dd($request->all());
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
                'name' => $request->name_en,
                'description' => $request->description_en ?? '',
                'location' => $request->location_en,
                'language_id' => 1, // English
                'organization_id' => $organization->id,

            ],
            [
                'name' => $request->name_ar,
                'description' => $request->description_ar ?? '',
                'location' => $request->location_ar,
                'language_id' => 2, // Arabic
                'organization_id' => $organization->id,

            ],
        ];
        // $organization->addOrganizationDetails($details);
        UserDetail::createMultipleUserDetails($details);


        // Step 5: Return response
        // return new OrganizationResource($organization);
        return view('Auth.signup_org', ['success' => 'Organization registered successfully']);
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
