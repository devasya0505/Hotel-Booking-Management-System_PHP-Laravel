<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hotels\HotelsController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Test route - remove this later
// Route::get('/test', function () {
//     return 'Laravel is working!';
// });

// If using Laravel 8 or above, make sure to install laravel/ui and run auth scaffolding:
// composer require laravel/ui
// php artisan ui vue --auth
// Or define authentication routes manually as needed.

// Auth::routes(); // Uncomment if using laravel/ui package

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

if (class_exists(\Illuminate\Support\Facades\Auth::class) && method_exists(Auth::class, 'routes')) {
    Auth::routes();
}

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/services', [App\Http\Controllers\HomeController::class, 'services'])->name('services');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [App\Http\Controllers\HomeController::class, 'contactSubmit'])->name('contact.submit');


Route::group(['prefix' => 'hotels'], function () {
    //hotels
    Route::get('/rooms/{id}', [App\Http\Controllers\Hotels\HotelsController::class, 'rooms'])->name('hotel.rooms');

    Route::get('/rooms-details/{id}', [App\Http\Controllers\Hotels\HotelsController::class, 'roomsDetails'])->name('hotel.rooms.details');

    Route::post('/rooms-booking/{id}', [App\Http\Controllers\Hotels\HotelsController::class, 'roomsBooking'])->name('hotel.rooms.booking');

    // // //pay
    // Route::get('hotels/pay', [App\Http\Controllers\Hotels\HotelsController::class, 'payWithPayPal'])->name('hotel.pay');

    // Route::get('hotels/success', [App\Http\Controllers\Hotels\HotelsController::class, 'success'])->name('hotel.success');


    // No middleware needed - validation is in controller
    Route::get('/pay', [HotelsController::class, 'payWithPayPal'])->name('hotel.pay');
    Route::get('/success', [HotelsController::class, 'success'])->name('hotel.success');
});


//users
Route::get('users/my-bookings', [App\Http\Controllers\Users\UsersController::class, 'myBookings'])->name('users.bookings')->middleware('auth:web');


//admin
Route::get('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'viewLogin'])->name('view.login')->middleware(\App\Http\Middleware\CheckForLogin::class);

Route::post('admin/login', [App\Http\Controllers\Admins\AdminsController::class, 'checkLogin'])->name('check.login');


Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

    Route::get('/index', [App\Http\Controllers\Admins\AdminsController::class, 'index'])->name('admins.dashboard');

    Route::post('/logout', [App\Http\Controllers\Admins\AdminsController::class, 'logout'])->name('admin.logout');

    //admins
    Route::get('/all-admins', [App\Http\Controllers\Admins\AdminsController::class, 'allAdmins'])->name('admins.all');

    Route::get('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'createAdmins'])->name('admins.create');

    Route::post('/create-admins', [App\Http\Controllers\Admins\AdminsController::class, 'storeAdmins'])->name('admins.store');


    //hotels
    Route::get('/all-hotels', [App\Http\Controllers\Admins\AdminsController::class, 'allHotels'])->name('hotels.all');

    Route::get('/create-hotels', [App\Http\Controllers\Admins\AdminsController::class, 'createHotels'])->name('hotels.create');

    Route::post('/create-hotels', [App\Http\Controllers\Admins\AdminsController::class, 'storeHotels'])->name('hotels.store');

    Route::get('/edit-hotels/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'editHotels'])->name('hotels.edit');

    Route::post('/update-hotels/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'updateHotels'])->name('hotels.update');

    // Route::get('/delete-hotels/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteHotels'])->name('hotels.delete');
    Route::delete('/delete-hotels/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteHotels'])->name('hotels.delete');


    //rooms
    Route::get('/all-rooms', [App\Http\Controllers\Admins\AdminsController::class, 'allRooms'])->name('rooms.all');

    Route::get('/create-rooms', [App\Http\Controllers\Admins\AdminsController::class, 'createRooms'])->name('rooms.create');

    Route::post('/create-rooms', [App\Http\Controllers\Admins\AdminsController::class, 'storeRooms'])->name('rooms.store');


    // Route::get('/delete-rooms/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteRooms'])->name('rooms.delete');
    Route::delete('/delete-rooms/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteRooms'])->name('rooms.delete');

    //bookings
    Route::get('/all-bookings', [App\Http\Controllers\Admins\AdminsController::class, 'allBookings'])->name('bookings.all');

    Route::get('/edit-status/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'editStatus'])->name('bookings.edit.status');

    Route::post('/update-status/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'updateStatus'])->name('bookings.update.status');

    // Route::get('/delete-bookings/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteBookings'])->name('bookings.delete');
    Route::delete('/delete-bookings/{id}', [App\Http\Controllers\Admins\AdminsController::class, 'deleteBookings'])->name('bookings.delete');
});
