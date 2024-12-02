<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Need\NeedController;
use App\Http\Controllers\main\MainController;
// use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\Post\PostController;

use Illuminate\Support\Facades\Log;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// language routs
Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]); // Set locale in session
        Log::info('Locale stored in session: ' . $locale);
    } else {
        Log::info('Invalid locale: ' . $locale);
    }
    return redirect()->route('index'); // or another route that you know is safe
});

// صفحة About
Route::get('/about', function () {
    return view('About');
})->name('about');

// صفحة Blog
Route::get('/blog', function () {
    return view('blog');
})->name('blog');







// صفحة needs


Route::get('/needs', [NeedController::class, 'index'])->name('need');
Route::get('/needs/{id}', [NeedController::class, 'show'])->name('need.show');








// صفحة Elements
Route::get('/elements', function () {
    return view('elements');
})->name('elements');

// صفحة Index (الصفحة الرئيسية)


// صفحة Main
Route::get('/main', function () {
    return view('main');
})->name('main');






Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.view');
Route::get('register', [AuthController::class, 'showRegisterFormUser'])->name('register.view');
Route::post('/register/donor', [AuthController::class, 'register'])->name('register.donor'); // Signup route
Route::get('register0', [AuthController::class, 'showRegisterFormOrganization'])->name('register.view.Organization');
Route::post('/register/organization', [AuthController::class, 'registerOrganization'])->name('register.organization');
Route::post('/login', [AuthController::class, 'login'])->name('login');      // Login route
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');
//
Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('This is a test email.', function ($message) {
            $message->to('aburummanaseel8@gmail.com')
                ->subject('Test Email');
        });
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


//donation
use App\Http\Controllers\Donation\DonationController;

Route::get('/donation/{id}', [DonationController::class, 'show'])->name('donation.show');

Route::post('/donate', [DonationController::class, 'store'])->name('donate.store');

Route::get('/donate', function () {
    return redirect()->route('donation.show', session('redirect_need_id', 1));
});



Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['auth'],
], function () {
    Route::get('/profile', [UserController::class, 'Profile'])->name('profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/doner/dashboard', [UserController::class, 'doner_dashboard'])->name('doner.dashboard')->middleware('role:doner');



    Route::get('/organization/dashboard', [OrganizationController::class, 'dashboard'])->name('organization.dashboard')->middleware('role:organization');
    Route::get('/organization/needs', [NeedController::class, 'getallNeed'])->name('organization.manage_Needs')->middleware('role:organization|admin');
    Route::get('/organization/needs/create', [NeedController::class, 'create_Need'])->name('organization.create_Need')->middleware('role:organization|admin');

    Route::post('/organization/store-need', [NeedController::class, 'storeNeed'])->name('organization.store_need')->middleware('role:organization|admin');
    Route::get('/organization/edit-need/{id}', [NeedController::class, 'editNeed'])->name('organization.edit_need')->middleware('role:organization|admin');
    Route::put('/organization/update-need/{id}', [NeedController::class, 'updateNeed'])->name('organization.update_need')->middleware('role:organization|admin');
    Route::delete('/organization/delete_need/{id}', [NeedController::class, 'destroy'])->name('organization.delete_need')->middleware('role:organization|admin');
    Route::delete('/organization/need-image/{id}', [NeedController::class, 'deleteNeedImage'])->name('organization.delete_need_image')->middleware('role:organization|admin');

    // Donations Routes
    Route::get('/donations', [DonationController::class, 'listDonations'])->name('donations.index')->middleware('role:organization|admin');
    Route::get('/donations/create', [DonationController::class, 'showCreateForm'])->name('donations.create')->middleware('role:organization|admin');
    Route::post('/donations', [DonationController::class, 'saveDonation'])->name('donations.store')->middleware('role:organization|admin');
    Route::get('/donations/{id}/edit', [DonationController::class, 'showEditForm'])->name('donations.edit')->middleware('role:organization|admin');
    Route::put('/donations/{id}', [DonationController::class, 'updateDonation'])->name('donations.update')->middleware('role:organization|admin');
    Route::delete('/donations/{id}', [DonationController::class, 'deleteDonation'])->name('donations.destroy')->middleware('role:organization|admin');
    Route::get('/donations/{id}', [DonationController::class, 'showDonation'])->name('donations.show')->middleware('role:organization|admin');





    Route::get('/user/donations', [DonationController::class, 'listUserDonations'])->name('donations.user_donations');


    // Posts routes
    Route::prefix('posts')->group(function () {
        Route::get('/manage', [PostController::class, 'index'])->name('posts.manage')->middleware('role:organization|admin');
        Route::get('/create', [PostController::class, 'create'])->name('posts.create')->middleware('role:organization|admin');
        Route::post('/store', [PostController::class, 'store'])->name('posts.store')->middleware('role:organization|admin');
        Route::get('/view/{id}', [PostController::class, 'show'])->name('posts.show')->middleware('role:organization|admin');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit')->middleware('role:organization|admin');
        Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update')->middleware('role:organization|admin');
        Route::post('/delete/{id}', [PostController::class, 'destroy'])->name('posts.delete')->middleware('role:organization|admin');
    });
});
Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/contact', [MainController::class, 'contact'])->name('contact');
Route::post('/contact', [MainController::class, 'storeContact'])->name('contact.store');

Route::get('/organization_profile/{id}', [OrganizationController::class, 'getOne'])->name('organization.profile.one');
Route::get('/all_organization', [OrganizationController::class, 'getAll'])->name('organization.all');
Route::get('/organization_post/{id}', [PostController::class, 'getOne'])->name('organization.post.one');
Route::get('/organization_posts/{organization_id}', [PostController::class, 'getAll'])->name('organization.post.all');


Route::get('/organization_profile/{id}', [OrganizationController::class, 'getOne'])->name('organization.profile.one');

Route::prefix('organization')->group(function () {
    // صفحة تعديل منظمة
    Route::get('/edit/{id}', [OrganizationController::class, 'edit'])
        ->name('organization.edit_organization')->middleware('role:admin'); // ملف edit_organization.blade.php
    Route::get('/manage', [OrganizationController::class, 'index'])->name('organization.manage_organizations')->middleware('role:admin');
    Route::delete('/delete1/{id}', [OrganizationController::class, 'destroy'])
        ->name('organization.delete_organization')->middleware('role:admin');
    // تحديث بيانات منظمة
    Route::put('/update/{id}', [OrganizationController::class, 'update'])
        ->name('organization.update_organization')->middleware('role:admin');

    // إدارة المنظمات
    Route::get('/manage', [OrganizationController::class, 'index'])
        ->name('organization.manage_organization')->middleware('role:admin'); // ملف manage_organization.blade.php
    Route::get('/organization/create', [OrganizationController::class, 'create'])->name('organization.create_organization')->middleware('role:admin');
    Route::post('/store-organization', [OrganizationController::class, 'store'])->name('organization.store_organization')->middleware('role:admin');

    // ملف web.php

    Route::get('/organization/pending', [OrganizationController::class, 'showPendingOrganizations'])->name('organization.pending')->middleware('role:admin');

    // تحديث حالة المنظمة
    Route::put('/organization/{id}/update-status', [OrganizationController::class, 'updateOrganizationStatus'])->name('organization.updateStatus')->middleware('role:admin');

    // تخزين منظمة جديدة
    Route::post('/store', [OrganizationController::class, 'store'])
        ->name('organization.store_organization')->middleware('role:admin');

    // عرض تفاصيل منظمة
    Route::get('/view/{id}', [OrganizationController::class, 'show'])
        ->name('organization.view_organization'); // ملف view_organization.blade.php
    Route::delete('/delete/{id}', [OrganizationController::class, 'destroy'])
        ->name('organaization.delete_organization')->middleware('role:admin');
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'admin_dashbored'])->name('admin.dashboard');
});
