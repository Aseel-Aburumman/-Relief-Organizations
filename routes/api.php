<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// aseeel test
// use App\Http\Controllers\Auth\AuthController;

// Route::post('/register/donor', [AuthController::class, 'register'])->name('register.donor'); // Signup route
// Route::post('/register/orgnization', [AuthController::class, 'registerOrganization'])->name('register.organization'); // Signup route
// Route::post('/login', [AuthController::class, 'loginUser']);       // Login route



// aseeel end test
