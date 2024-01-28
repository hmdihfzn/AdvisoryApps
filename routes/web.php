<?php

use App\Http\Controllers\ListingController;
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

Route::view('/', 'welcome');
Route::get('/dashboard', [ListingController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard'); 
// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function() {
    Route::post('/listings/upsert', [ListingController::class, 'create']);
    Route::post('/listing/update', [ListingController::class, 'update'])->name('listings.update');
    Route::get('/listings/edit/{id}', [ListingController::class, 'edit']);
    Route::delete('/listings/delete/{id}', [ListingController::class, 'delete'])->name('listings.delete');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
