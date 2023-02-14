<?php

use Illuminate\Support\Facades\Route;

// Front (landing)
use App\Http\Controllers\Landing\LandingController;

// Member (dashboard)
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\RequestController;
use App\Http\Controllers\Dashboard\MyOrderController;
use App\Http\Controllers\Dashboard\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Front routes
Route::get('/explore', [LandingController::class, 'explore'])->name('explore.landing');
Route::get('/detail/{service}', [LandingController::class, 'detail'])->name('detail.landing');
Route::post('/booking/{service}', [LandingController::class, 'booking'])->name('booking.landing');
Route::get('/booking/{order}/detail', [LandingController::class, 'detail_booking'])->name('detail.booking.landing');
Route::resource('/', LandingController::class)->only('index');

// Member routes
Route::group(['prefix' => 'member', 'as' => 'member.', 'middleware' => ['auth:sanctum', 'verified']], function() {
    // Dashboard
    Route::resource('dashboard', MemberController::class)->only('index');

    // Service
    Route::resource('service', ServiceController::class)->except(['show', 'destroy']);

    // Request
    Route::post('/approve-request/{order}', [RequestController::class, 'approve'])->name('approve.request');
    Route::resource('request', RequestController::class)->only(['index', 'show']);

    // My order
    Route::get('/accept/{order}/order', [MyOrderController::class, 'accepted'])->name('accept.order');
    Route::get('/reject/{order}/order', [MyOrderController::class, 'rejected'])->name('reject.order');
    Route::resource('order', MyOrderController::class)->except(['create', 'store']);

    // Profile
    Route::get('/delete-photo/{detail_user}', [ProfileController::class, 'delete'])->name('delete.photo.profile');
    Route::resource('profile', ProfileController::class)->only(['index', 'update']);
});

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');
