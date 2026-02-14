<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\DriverController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\TripSearchController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/
Route::view('/', 'pages.home')->name('home');

Route::prefix('trips')->name('trips.')->group(function () {

   
    Route::get('/search', [TripSearchController::class, 'search'])->name('search');
    Route::get('/results', [TripSearchController::class, 'result'])->name('results');
    Route::get('/{trip}', [TripSearchController::class, 'show'])->name('show');
});

/*
/*
|--------------------------------------------------------------------------
| Booking (Voyageur)
|--------------------------------------------------------------------------
*/
Route::prefix('booking')->name('booking.')->middleware('auth')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');

    Route::post('/{trip}', [BookingController::class, 'store'])->name('store');
    Route::view('/success', 'pages.booking.success')->name('success');
});

/*
|--------------------------------------------------------------------------
| Auth 
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::get('/driver/register', [DriverController::class, 'create'])->name('driver.register');
    Route::post('/driver/register', [DriverController::class, 'store'])->name('driver.register.store');

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});

// LOGOUT
Route::delete('/logout', [SessionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Driver Area
|--------------------------------------------------------------------------
*/
Route::prefix('driver')->name('driver.')->middleware(['auth', 'role:driver'])->group(function () {

    Route::view('/dashboard', 'driver.dashboard')->name('dashboard');

    Route::prefix('trips')->name('trips.')->group(function () {
        Route::view('/', 'driver.trips.index')->name('index');        
        Route::get('create', [TripController::class, 'showCities'])->name('create'); 
        Route::post('/', fn () => redirect()->route('driver.trips.index'))->name('store'); 
    });

    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::view('/', 'driver.bookings.index')->name('index');
        Route::post('/{booking}/validate', fn () => back())->name('validate');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::prefix('drivers')->name('drivers.')->group(function () {
        Route::get('/pending', [AdminController::class, 'drivers'])->name('pending');
        Route::get('/{driver}', [AdminController::class, 'showDriver'])->name('show');

        Route::post('/{driver}/approve', [AdminController::class, 'validateDriver'])->name('approve');
        Route::post('/{driver}/reject', [AdminController::class, 'rejectDriver'])->name('reject');
    });
    
    Route::get('/drivers', [AdminController::class, 'listDrivers'])->name('drivers.list');
    Route::delete('/drivers/{driver}', [AdminController::class, 'deleteDriver'])->name('drivers.delete');
    
    Route::get('/routes', [AdminController::class, 'listRoutes'])->name('routes.list');
    Route::delete('/routes/{route}', [AdminController::class, 'deleteRoute'])->name('routes.delete');
    Route::get('/routes/create', [AdminController::class, 'createRoute'])->name('routes.create');
    Route::post('/routes', [AdminController::class, 'storeRoute'])->name('routes.store');
});

Route::fallback(fn () => response()->view('errors.404', [], 404));
