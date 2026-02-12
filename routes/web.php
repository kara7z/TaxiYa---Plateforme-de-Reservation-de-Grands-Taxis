<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\Auth\SessionsController;

/*
|--------------------------------------------------------------------------
| Public (Voyageur)
|--------------------------------------------------------------------------
*/

Route::view('/', 'pages.home')->name('home');
Route::view('/welcome', 'welcome')->name('welcome');

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

Route::prefix('booking')->name('booking.')->group(function () {
    Route::view('/', 'pages.booking.index')->name('index');        

    // Placeholder: later replace with BookingController@store
    Route::post('/', function (Request $request) {
        return redirect()->route('booking.success', [
            'email' => $request->input('email'),
        ]);
    })->name('store');

    Route::view('/success', 'pages.booking.success')->name('success'); 
});

/*
|--------------------------------------------------------------------------
| Auth (Voyageur)
|--------------------------------------------------------------------------
*/



Route::middleware('guest')->group(function () {
    // Auth pages (guest only)
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});

// Logout (auth only)
Route::delete('/logout', [SessionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Driver Auth + Driver Area
|--------------------------------------------------------------------------
*/

Route::prefix('driver')->name('driver.')->group(function () {
    Route::view('/login', 'auth.driver-login')->name('login');         
    Route::view('/register', 'auth.driver-register')->name('register'); 

    // Placeholders
    Route::post('/login', fn () => redirect()->route('driver.dashboard'))->name('login.submit');
    Route::post('/register', fn () => redirect()->route('driver.dashboard'))->name('register.submit');
    Route::post('/logout', fn () => redirect()->route('home'))->name('logout');

    Route::view('/dashboard', 'driver.dashboard')->name('dashboard'); 

    Route::prefix('trips')->name('trips.')->group(function () {
        Route::view('/', 'driver.trips.index')->name('index');        
        Route::get('create', [TripController::class, 'showCities'])->name('create'); 
        // Route::view('/create', 'driver.trips.create')->name('create'); 
        Route::post('/', fn () => redirect()->route('driver.trips.index'))->name('store'); 
    });

    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::view('/', 'driver.bookings.index')->name('index'); 
        Route::post('/{booking}/validate', fn () => back())->name('validate'); 
    });
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard'); 

    Route::prefix('drivers')->name('drivers.')->group(function () {
        Route::view('/pending', 'admin.drivers.pending')->name('pending');
        Route::view('/{driver}', 'admin.drivers.show')->name('show');      

        // Placeholders
        Route::post('/{driver}/approve', fn () => redirect()->route('admin.drivers.pending'))->name('approve');
        Route::post('/{driver}/reject', fn () => redirect()->route('admin.drivers.pending'))->name('reject');
    });
});

/*
|--------------------------------------------------------------------------
| Fallback / Errors
|--------------------------------------------------------------------------
*/

Route::fallback(fn () => response()->view('errors.404', [], 404)); 
