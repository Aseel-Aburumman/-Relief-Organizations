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
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    public function showRegisterFormUser()
    {
        $countries = countries();

        return view('Auth.signup', compact('countries'));
    }

    public function register(RegisterRequest $request)
    {
        try {
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
            return view('Auth.signup', ['success' => 'User registered successfully'], compact('countries'));
        } catch (\Exception $e) {
            Log::error('Error fetching needs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while registering  the User. Please try again.');
        }
    }

    public function showRegisterFormOrganization()
    {
        $countries = countries();
        return view('Auth.signup_org', compact('countries'));
    }

    public function registerOrganization(RegisterOrganizationRequest $request)
    {
        try {
            $countries = countries();
            $languageId = Language::getLanguageIdByLocale();
            // Create user data
            $userData = $request->only(['email', 'password']);
            $userData['password'] = bcrypt($userData['password']); // Hash password
            $user = User::createUser($userData);

            if (!$user) {
                return response()->json(['error' => 'Failed to create user'], 500);
            }

            // Check for file upload and store the certificate image
            $organizationData = [];
            if ($request->hasFile('certificate_image')) {
                $imagePath = $request->file('certificate_image')->store('certificate_images', 'public');
                $organizationData = [
                    'user_id' => $user->id,
                    'contact_info' => $request->contact_info,
                    'certificate_image' => $imagePath,
                    'status' => 'Pending',
                ];
                $organization = Organization::createOrganization($organizationData);
                if (!$organization) {
                    return response()->json(['error' => 'Failed to create organization'], 500);
                }
                $role = Role::where('name', 'organization')->first();
                if ($role) {
                    $user->assignRole($role);
                }
                $details = [
                    [
                        'name' => $request->name,
                        'description' => $request->description ?? '',
                        'address' => $request->address,
                        'language_id' => $languageId,
                        'organization_id' => $organization->id,
                    ],
                ];
                UserDetail::createMultipleUserDetails($details);
            }
            return view('Auth.signup_org', ['success' => 'Organization registered successfully'], compact('countries'));
        } catch (\Exception $e) {
            Log::error('Error fetching needs: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while registering  the Organization. Please try again.');
        }
    }



    public function showLoginForm()
    {
        return view('Auth.login');
    }



    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Preserve `redirect_after_login` for unauthorized access
        if (!session()->has('redirect_after_login')) {
            session()->put('redirect_after_login', url()->previous());
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user = User::find(Auth::user()->id);

            if ($user->hasRole('admin')) {
                session()->forget('redirect_after_login');
                return redirect()->route('admin.dashboard')->with(['success' => 'Admin login successful']);
            }

            if ($user->hasRole('doner')) {
                $redirectUrl = session()->get('redirect_after_login', route('index'));
                session()->forget('redirect_after_login');
                return redirect($redirectUrl)->with(['success' => 'Login successful']);
            }

            if ($user->hasRole('organization')) {
                session()->forget('redirect_after_login');
                return redirect()->route('organization.dashboard')->with(['success' => 'Login successful']);
            }
        }

        // Handle invalid login
        return back()->withErrors(['login_error' => 'Invalid email or password']);
    }


    public function logout()
    {
        Auth::logout();


        return redirect()->route('login.view')->with('success', 'Logged out successfully');
    }
}
