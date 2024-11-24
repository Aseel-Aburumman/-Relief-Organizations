<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Orgnization\OrgnizationController;
use App\Http\Controllers\Need\NeedController;
use App\Http\Controllers\main\MainController;
use App\Http\Controllers\OrganizationController;
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

// Route::get('/needs', function () {
//     return view('need.needs');
// })->name('need');

// صفحة needs


Route::get('/needs', [NeedController::class, 'index'])->name('need');
Route::get('/needs/{id}', [NeedController::class, 'show'])->name('need.show');

// Route::get('/needs', function () {
//     return view('need.needs');
// })->name('need');


// صفحة Cause Details
Route::get('/cause-details', function () {
    return view('cause_details');
})->name('cause.details');

// صفحة Contact Process
Route::get('/contact-process', function () {
    return view('contact_process');
})->name('contact.process');



// صفحة Elements
Route::get('/elements', function () {
    return view('elements');
})->name('elements');

// صفحة Index (الصفحة الرئيسية)


// صفحة Main
Route::get('/main', function () {
    return view('main');
})->name('main');

// صفحة Single Blog
Route::get('/single-blog', function () {
    return view('single-blog');
})->name('single.blog');




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


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['auth'],
], function () {
    Route::get('/orgnization/dashboard', [OrgnizationController::class, 'dashboard'])->name('orgnization.dashboard')->middleware('role:orgnization');
    Route::get('/orgnization/needs', [NeedController::class, 'getallNeed'])->name('orgnization.manage_Needs');
    Route::get('/orgnization/needs/create', [NeedController::class, 'create_Need'])->name('orgnization.create_Need')->middleware('role:orgnization|admin');
    Route::patch('/admin/disable-all-needs/{organization_id}', [NeedController::class, 'disableAllNeeds'])->name('orgnization.disable_need');

    Route::post('/organization/store-need', [NeedController::class, 'storeNeed'])->name('organization.store_need');
    Route::get('/organization/edit-need/{id}', [NeedController::class, 'editNeed'])->name('organization.edit_need')->middleware('role:orgnization|admin');
    Route::put('/organization/update-need/{id}', [NeedController::class, 'updateNeed'])->name('organization.update_need');
    Route::delete('/organization/delete_need/{id}', [NeedController::class, 'destroy'])->name('organization.delete_need')->middleware('role:orgnization|admin');
    Route::delete('/organization/need-image/{id}', [NeedController::class, 'deleteNeedImage'])->name('organization.delete_need_image')->middleware('role:orgnization|admin');

    // Donations Routes
    Route::get('/donations', [DonationController::class, 'listDonations'])->name('donations.index');
    Route::get('/donations/create', [DonationController::class, 'showCreateForm'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'saveDonation'])->name('donations.store');
    Route::get('/donations/{id}/edit', [DonationController::class, 'showEditForm'])->name('donations.edit');
    Route::put('/donations/{id}', [DonationController::class, 'updateDonation'])->name('donations.update');
    Route::delete('/donations/{id}', [DonationController::class, 'deleteDonation'])->name('donations.destroy');
    Route::get('/donations/{id}', [DonationController::class, 'showDonation'])->name('donations.show');


    Route::get('/user/donations', [DonationController::class, 'listUserDonations'])->name('donations.user_donations');




  Route::get('/orgnization/profile', [OrgnizationController::class, 'Profile'])->name('orgnization.profile');

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

Route::get('/organization_profile/{id}', [OrgnizationController::class, 'getOne'])->name('orgnization.profile.one');
Route::get('/all_organization', [OrgnizationController::class, 'getAll'])->name('orgnization.all');


Route::prefix('organization')->group(function () {
    Route::get('/edit/{id}', [OrgnizationController::class, 'edit'])->name('orgnization.edit_organization');
    Route::put('/update/{id}', [OrgnizationController::class, 'update'])->name('orgnization.update_organization');
    Route::get('/manage', [OrgnizationController::class, 'index'])->name('orgnization.manage_organization');
    Route::get('/create', [OrgnizationController::class, 'create'])->name('orgnization.create_organization');
    Route::post('/store', [OrgnizationController::class, 'store'])->name('orgnization.store_organization');
});


