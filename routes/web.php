<?php

use App\Http\Controllers\UploadDataController;
use App\Livewire\Pages\TransactionTypes\TransactionTypesIndex;
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

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {

    // Below mentioned routes are for transaction types
    Route::get('/transaction-types-index', TransactionTypesIndex::class)->name('transaction-types-index');

    // Below mentioned routes are for File Upload.
    Route::get('/upload-index', [UploadDataController::class, 'index'])->name('upload-index');
    Route::post('/upload-data', [UploadDataController::class, 'uploadData'])->name('upload-data');
});
