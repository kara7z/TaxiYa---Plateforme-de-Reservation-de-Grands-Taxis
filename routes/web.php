<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\Auth\DriverController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\BookingContorller;

/*
|--------------------------------------------------------------------------
| Public (Voyageur)
|--------------------------------------------------------------------------
*/
Route::view('/', 'pages.home')->name('home');

Route::prefix('trips')->name('trips.')->group(function () {
    Route::view('/search', 'pages.search')->name('search');
    Route::view('/results', 'pages.results')->name('results');
    Route::view('/{trip}', 'pages.trip.show')->name('show');
});

/*
|--------------------------------------------------------------------------
| Booking (Voyageur)
|--------------------------------------------------------------------------
*/
// Route::get('/booking',[BookingContorller::class,'show'])->name('show');
Route::prefix('booking')->name('booking.')->group(function () {
    Route::view('/', 'pages.booking.index')->name('index');

    Route::post('/', function (Request $request) {
        return redirect()->route('booking.success', [
            'email' => $request->input('email'),
        ]);
    })->name('store');

    Route::view('/success', 'pages.booking.success')->name('success');
});

/*
|--------------------------------------------------------------------------
| Auth (ONE login/logout)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // passenger register
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    // driver register (still creates user with role=driver)
    Route::get('/driver/register', [DriverController::class, 'create'])->name('driver.register');
    Route::post('/driver/register', [DriverController::class, 'store'])->name('driver.register.store');

    // login for everyone
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});

// Logout for everyone
Route::delete('/logout', [SessionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Driver Area (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::prefix('driver')->name('driver.')->middleware(['auth', 'role:driver'])->group(function () {

    Route::view('/dashboard', 'driver.dashboard')->name('dashboard');

    Route::prefix('trips')->name('trips.')->group(function () {
        Route::view('/', 'driver.trips.index')->name('index');        
        Route::get('create', [TripController::class, 'showCities'])->name('create'); 
        Route::get('create', [RouteController::class, 'getBasePrice'])->name('route_base_price'); 
        // Route::view('/create', 'driver.trips.create')->name('create'); 
        Route::post('/', fn () => redirect()->route('driver.trips.index'))->name('store'); 
        Route::view('/', 'driver.trips.index')->name('index');
        Route::post('/', fn () => redirect()->route('driver.trips.index'))->name('store');
    });

    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::view('/', 'driver.bookings.index')->name('index');
        Route::post('/{booking}/validate', fn () => back())->name('validate');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Area (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    Route::prefix('drivers')->name('drivers.')->group(function () {
        Route::view('/pending', 'admin.drivers.pending')->name('pending');
        Route::view('/{driver}', 'admin.drivers.show')->name('show');

        Route::post('/{driver}/approve', fn () => redirect()->route('admin.drivers.pending'))->name('approve');
        Route::post('/{driver}/reject', fn () => redirect()->route('admin.drivers.pending'))->name('reject');
    });
});

Route::fallback(fn () => response()->view('errors.404', [], 404));
