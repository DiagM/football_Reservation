<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StadiumController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
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

// Route::get('/', function () {
//     return view('index');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
 Route::get('/', function () {
    return view('index');
 })->name('dashboard');
 Route::get('/chart-data', [ChartController::class, 'getPieChartData']);
 Route::get('/line-chart', [ChartController::class, 'lineChart']);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //booking
    Route::prefix('booking')->group(function () {
        Route::group(['middleware' => ['role:BookingManage']], function () {
    Route::get('/', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/submit', [BookingController::class, 'submit'])->name('booking.submit');
    Route::post('/fetch_appointments', [BookingController::class, 'fetch_appointments']);
    Route::get('/calendar', [BookingController::class, 'calendar'])->name('booking.calendar');
    Route::post('/delete/{id}', [BookingController::class, 'delete'])->name('booking.delete');
    Route::post('/update/{id}', [BookingController::class, 'update'])->name('booking.update');

    });
});
    Route::prefix('fund')->group(function () {
        Route::group(['middleware' => ['role:FundManage']], function () {
    Route::get('/', [FundController::class, 'index'])->name('fund.index');
    Route::get('/list', [FundController::class, 'getFunds'])->name('fund.list');
    Route::get('/{id}', [FundController::class, 'fetch']);
    Route::post('/update/{id}', [FundController::class, 'update']);
    Route::delete('/delete/{id}', [FundController::class, 'delete'])->name('fund.delete');

    });
});
    Route::prefix('stadium')->group(function () {
        Route::group(['middleware' => ['role:StadiumManage']], function () {
    Route::get('/', [StadiumController::class, 'index'])->name('stadium.index');
    Route::post('/submit', [StadiumController::class, 'submit'])->name('stadium.submit');
    Route::get('/{id}', [StadiumController::class, 'fetch']);
    Route::post('/update/{id}', [StadiumController::class, 'update']);
    Route::delete('/delete/{id}', [StadiumController::class, 'delete'])->name('stadium.delete');

    });
});
    Route::prefix('user')->group(function () {
        Route::group(['middleware' => ['role:UserManage']], function () {
            Route::get('/', [UserController::class, 'index'])->name('user.index');
            Route::get('/list', [UserController::class, 'getUsers'])->name('user.list');
            Route::post('/submit', [UserController::class, 'submit'])->name('user.submit');
            Route::get('/{id}', [UserController::class, 'fetch']);
            Route::post('/update/{id}', [UserController::class, 'update']);
            Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        });


    });
    Route::prefix('subscription')->group(function () {
        Route::group(['middleware' => ['role:SubscriptionManage']], function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('subscription.index');
        Route::post('/submit', [SubscriptionController::class, 'submit'])->name('subscription.submit');
        Route::get('/{id}', [SubscriptionController::class, 'fetch']);
        Route::post('/update/{id}', [SubscriptionController::class, 'update']);
        Route::delete('/delete/{id}', [SubscriptionController::class, 'delete'])->name('subscription.delete');
    });
        });

    Route::prefix('session')->group(function () {
        Route::post('/submit', [SessionController::class, 'submit'])->name('submit');
        Route::get('/', [SessionController::class, 'index'])->name('session.index');
        Route::get('/list', [SessionController::class, 'getSessions'])->name('session.list');
    });
});


require __DIR__.'/auth.php';
