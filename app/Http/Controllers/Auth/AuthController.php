<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

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
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

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

        if (!session()->has('redirect_after_login')) {
            $previousUrl = url()->previous();

            // If `url()->previous()` is the login page, set a default redirect URL
            if ($previousUrl === route('login')) {
                $previousUrl = route('index'); // Replace `index` with your desired fallback route
            }

            session()->put('redirect_after_login', $previousUrl);
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

    public function showLinkRequestForm()
    {
        return view('Auth.passwords_email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email'),
            function ($user, $token) {
                // Create a reset link
                $resetLink = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));

                // Send the email using the custom mailable
                Mail::to($user->email)->send(new PasswordResetMail($resetLink));
            }
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('Auth.passwords_reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
