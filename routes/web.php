<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;

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



Route::get('/needs', [NeedController::class, 'index'])->name('need');
Route::get('/needs/{id}', [NeedController::class, 'show'])->name('need.show');



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
    Route::get('/organization/needs', [NeedController::class, 'getallNeed'])->name('organization.manage_Needs');
    Route::get('/organization/needs/create', [NeedController::class, 'create_Need'])->name('organization.create_Need')->middleware('role:organization|admin');
    Route::patch('/admin/disable-all-needs/{organization_id}', [NeedController::class, 'disableAllNeeds'])->name('organization.disable_need');

    Route::post('/organization/store-need', [NeedController::class, 'storeNeed'])->name('organization.store_need');
    Route::get('/organization/edit-need/{id}', [NeedController::class, 'editNeed'])->name('organization.edit_need')->middleware('role:organization|admin');
    Route::put('/organization/update-need/{id}', [NeedController::class, 'updateNeed'])->name('organization.update_need');
    Route::delete('/organization/delete_need/{id}', [NeedController::class, 'destroy'])->name('organization.delete_need')->middleware('role:organization|admin');
    Route::delete('/organization/need-image/{id}', [NeedController::class, 'deleteNeedImage'])->name('organization.delete_need_image')->middleware('role:organization|admin');

    // Donations Routes
    Route::get('/donations', [DonationController::class, 'listDonations'])->name('donations.index');
    Route::get('/donations/create', [DonationController::class, 'showCreateForm'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'saveDonation'])->name('donations.store');
    Route::get('/donations/{id}/edit', [DonationController::class, 'showEditForm'])->name('donations.edit');
    Route::put('/donations/{id}', [DonationController::class, 'updateDonation'])->name('donations.update');
    Route::delete('/donations/{id}', [DonationController::class, 'deleteDonation'])->name('donations.destroy');
    Route::get('/donations/{id}', [DonationController::class, 'showDonation'])->name('donations.show');


    Route::get('/user/donations', [DonationController::class, 'listUserDonations'])->name('donations.user_donations');


    // Posts routes
    Route::prefix('posts')->group(function () {
        Route::get('/manage', [PostController::class, 'index'])->name('posts.manage');
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/store', [PostController::class, 'store'])->name('posts.store');
        Route::get('/view/{id}', [PostController::class, 'show'])->name('posts.show');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');
        Route::post('/delete/{id}', [PostController::class, 'destroy'])->name('posts.delete');
    });
});
Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/contact', [MainController::class, 'contact'])->name('contact');
Route::post('/contact', [MainController::class, 'storeContact'])->name('contact.store');

Route::get('/organization_profile/{id}', [OrganizationController::class, 'getOne'])->name('organization.profile.one');
Route::get('/all_organization', [OrganizationController::class, 'getAll'])->name('organization.all');
Route::get('/organization_post/{id}', [PostController::class, 'getOne'])->name('organization.post.one');
Route::get('/organization_posts/{organization_id}', [PostController::class, 'getAll'])->name('organization.post.all');



// Route::prefix('organization')->group(function () {
//     Route::get('/edit/{id}', [OrganizationController::class, 'edit'])->name('organization.edit_organization');
//     Route::put('/update/{id}', [OrganizationController::class, 'update'])->name('organization.update_organization');
//     Route::get('/manage', [OrganizationController::class, 'index'])->name('organization.manage_organization');
//     Route::get('/create', [OrganizationController::class, 'create'])->name('organization.create_organization');
//     Route::post('/store', [OrganizationController::class, 'store'])->name('organization.store_organization');
// });
Route::get('/organization_profile/{id}', [OrganizationController::class, 'getOne'])->name('organization.profile.one');

Route::prefix('organization')->group(function () {
    // صفحة تعديل منظمة
    Route::get('/edit/{id}', [OrganizationController::class, 'edit'])
        ->name('organization.edit_organization'); // ملف edit_organization.blade.php
    Route::get('/manage', [OrganizationController::class, 'index'])->name('organization.manage_organizations');
    Route::delete('/delete1/{id}', [OrganizationController::class, 'destroy'])
    ->name('organization.delete_organization');
    // تحديث بيانات منظمة
    Route::put('/update/{id}', [OrganizationController::class, 'update'])
        ->name('organization.update_organization');

    // إدارة المنظمات
    Route::get('/manage', [OrganizationController::class, 'index'])
        ->name('organization.manage_organization'); // ملف manage_organization.blade.php
        Route::get('/organization/create', [OrganizationController::class, 'create'])->name('organization.create_organization');
        Route::post('/store-organization', [OrganizationController::class, 'store'])->name('organization.store_organization');

// ملف web.php

Route::get('/organization/pending', [OrganizationController::class, 'showPendingOrganizations'])->name('organization.pending');

// تحديث حالة المنظمة
Route::put('/organization/{id}/update-status', [OrganizationController::class, 'updateOrganizationStatus'])->name('organization.updateStatus');

    // تخزين منظمة جديدة
    Route::post('/store', [OrganizationController::class, 'store'])
        ->name('organization.store_organization');

    // عرض تفاصيل منظمة
    Route::get('/view/{id}', [OrganizationController::class, 'show'])
        ->name('organization.view_organization'); // ملف view_organization.blade.php
        Route::delete('/delete/{id}', [OrganizationController::class, 'destroy'])
        ->name('organaization.delete_organization');
    });
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard', [UserController::class, 'admin_dashbored'])->name('admin.dashboard');
    });
  
