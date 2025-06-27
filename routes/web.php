<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;


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
//     return view('welcome');
// });


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('dashboard.admin');
    Route::get('/events/{event}/show', [EventController::class, 'show'])->name('events.show');
    // Other admin routes...
});







Route::get('/', [PageController::class, 'landingpage'])->name('landingpage');

Route::get('/landingpage', [PageController::class, 'landingpage'])->name('landingpage');


Route::get('/events/index', [EventController::class, 'index'])->name('events.index');

Route::get('/events/{event}/show', [EventController::class, 'show'])->name('events.show');

Route::post('/events/{event}/join', [EventController::class, 'join'])->name('events.join')->middleware('auth');

Route::post('/events/{event}/leave', [EventController::class, 'leave'])->name('events.leave')->middleware('auth');

Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit')->middleware('auth');

Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update')->middleware('auth');

Route::put('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel')->middleware('auth');

Route::get('/events/create', [EventController::class, 'create'])->name('events.create');

Route::post('/events', [EventController::class, 'store'])->name('events.store')->middleware('auth');



Route::get('/dashboard/user', [DashboardController::class, 'index'])->name('dashboard.user')->middleware('auth');


Route::post('/events/{event}/approve', [EventController::class, 'approve'])->name('events.approve')->middleware('auth');

Route::post('/events/{event}/reject', [EventController::class, 'reject'])->name('events.reject')->middleware('auth');

Route::post('/events/{event}/destroy', [EventController::class, 'destroy'])->name('events.destroy')->middleware('auth');












require __DIR__.'/auth.php';
