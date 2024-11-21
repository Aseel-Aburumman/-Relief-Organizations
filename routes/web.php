<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Orgnization\OrgnizationController;

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

// صفحة Cause
Route::get('/cause', function () {
    return view('Cause');
})->name('cause');

// صفحة Cause Details
Route::get('/cause-details', function () {
    return view('cause_details');
})->name('cause.details');

// صفحة Contact Process
Route::get('/contact-process', function () {
    return view('contact_process');
})->name('contact.process');

// صفحة Contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

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

// صفحة Welcome
Route::get('/', function () {
    return view('index');
})->name('index');


Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.view');
Route::get('register', [AuthController::class, 'showRegisterFormUser'])->name('register.view');
Route::post('/register/donor', [AuthController::class, 'register'])->name('register.donor'); // Signup route
Route::get('register0', [AuthController::class, 'showRegisterFormOrganization'])->name('register.view.Organization');
Route::post('/register/organization', [AuthController::class, 'registerOrganization'])->name('register.organization');
Route::post('/login', [AuthController::class, 'login'])->name('login');      // Login route
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['auth'],
], function () {
    Route::get('/orgnization/dashboard', [OrgnizationController::class, 'dashboard'])->name('orgnization.dashboard');
    Route::get('/orgnization/needs', [OrgnizationController::class, 'getallNeed'])->name('orgnization.manage_Needs');
    Route::get('/orgnization/needs/create', [OrgnizationController::class, 'create_Need'])->name('orgnization.create_Need');
    Route::patch('/admin/disable-all-needs/{organization_id}', [OrgnizationController::class, 'disableAllNeeds'])->name('orgnization.disable_need');

    Route::post('/organization/store-need', [OrgnizationController::class, 'storeNeed'])->name('organization.store_need');
    Route::get('/organization/edit-need/{id}', [OrgnizationController::class, 'editNeed'])->name('organization.edit_need');
    Route::put('/organization/update-need/{id}', [OrgnizationController::class, 'updateNeed'])->name('organization.update_need');
    Route::delete('/organization/delete_need/{id}', [OrgnizationController::class, 'deleteNeed'])->name('organization.delete_need');




    Route::get('/orgnization/profile', [OrgnizationController::class, 'Profile'])->name('orgnization.profile');
});
