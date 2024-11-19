<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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


