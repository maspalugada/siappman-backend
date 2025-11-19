<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;

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

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard/admin', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard.admin');

    // User Management
    Route::resource('/dashboard/users', \App\Http\Controllers\UserController::class, [
        'names' => [
            'index' => 'dashboard.users.index',
            'create' => 'dashboard.users.create',
            'store' => 'dashboard.users.store',
            'show' => 'dashboard.users.show',
            'edit' => 'dashboard.users.edit',
            'update' => 'dashboard.users.update',
            'destroy' => 'dashboard.users.destroy',
        ]
    ]);

    // QR Codes Management
    Route::get('/dashboard/qr-codes', [DashboardController::class, 'qrCodes'])->name('dashboard.qr-codes');
    Route::get('/dashboard/qr-codes/create', [DashboardController::class, 'createQrCode'])->name('dashboard.qr-codes.create');
    Route::post('/dashboard/qr-codes', [DashboardController::class, 'storeQrCode'])->name('dashboard.qr-codes.store');
    Route::post('/dashboard/qr-codes/combined', [DashboardController::class, 'storeCombinedQrCode'])->name('dashboard.qr-codes.combined.store');
    Route::get('/dashboard/qr-codes/{id}', [DashboardController::class, 'showQrCode'])->name('dashboard.qr-codes.show');
    Route::get('/dashboard/qr-codes/{id}/edit', [DashboardController::class, 'editQrCode'])->name('dashboard.qr-codes.edit');
    Route::put('/dashboard/qr-codes/{id}', [DashboardController::class, 'updateQrCode'])->name('dashboard.qr-codes.update');
    Route::delete('/dashboard/qr-codes/{id}', [DashboardController::class, 'destroyQrCode'])->name('dashboard.qr-codes.destroy');

    // Asset Management
    Route::resource('/dashboard/assets', AssetController::class, [
        'names' => [
            'index' => 'dashboard.assets.index',
            'create' => 'dashboard.assets.create',
            'store' => 'dashboard.assets.store',
            'show' => 'dashboard.assets.show',
            'edit' => 'dashboard.assets.edit',
            'update' => 'dashboard.assets.update',
            'destroy' => 'dashboard.assets.destroy',
        ]
    ]);
    Route::get('/dashboard/assets/{asset}/qr', [AssetController::class, 'generateQr'])->name('dashboard.assets.qr');

    // Instrument Set Management
    Route::resource('/dashboard/instrument-sets', \App\Http\Controllers\InstrumentSetController::class, [
        'names' => [
            'index' => 'dashboard.instrument-sets.index',
            'create' => 'dashboard.instrument-sets.create',
            'store' => 'dashboard.instrument-sets.store',
            'show' => 'dashboard.instrument-sets.show',
            'edit' => 'dashboard.instrument-sets.edit',
            'update' => 'dashboard.instrument-sets.update',
            'destroy' => 'dashboard.instrument-sets.destroy',
        ]
    ]);

    // Master Data Management
    Route::resource('/dashboard/instrument-types', \App\Http\Controllers\InstrumentTypeController::class, [
        'names' => [
            'index' => 'dashboard.instrument-types.index',
            'create' => 'dashboard.instrument-types.create',
            'store' => 'dashboard.instrument-types.store',
            'show' => 'dashboard.instrument-types.show',
            'edit' => 'dashboard.instrument-types.edit',
            'update' => 'dashboard.instrument-types.update',
            'destroy' => 'dashboard.instrument-types.destroy',
        ]
    ]);
    Route::resource('/dashboard/units', \App\Http\Controllers\UnitController::class, [
        'names' => [
            'index' => 'dashboard.units.index',
            'create' => 'dashboard.units.create',
            'store' => 'dashboard.units.store',
            'show' => 'dashboard.units.show',
            'edit' => 'dashboard.units.edit',
            'update' => 'dashboard.units.update',
            'destroy' => 'dashboard.units.destroy',
        ]
    ]);
    Route::resource('/dashboard/locations', \App\Http\Controllers\LocationController::class, [
        'names' => [
            'index' => 'dashboard.locations.index',
            'create' => 'dashboard.locations.create',
            'store' => 'dashboard.locations.store',
            'show' => 'dashboard.locations.show',
            'edit' => 'dashboard.locations.edit',
            'update' => 'dashboard.locations.update',
            'destroy' => 'dashboard.locations.destroy',
        ]
    ]);

    // Scan History
    Route::get('/dashboard/scan-history', [DashboardController::class, 'scanHistory'])->name('dashboard.scan-history');

    // Profile
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::put('/dashboard/profile/password', [DashboardController::class, 'updatePassword'])->name('dashboard.profile.password');

    // Scanner
    Route::get('/scanner', function () {
        return view('scanner');
    })->name('scanner');
});
