<?php

use App\Http\Controllers\UploadDataController;
use App\Livewire\Pages\Transactions\TransactionsIndex;
use App\Livewire\Pages\Transactions\TransactionsStore;
use App\Livewire\Pages\TransactionTypes\TransactionTypeEdit;
use App\Livewire\Pages\TransactionTypes\TransactionTypesIndex;
use App\Livewire\Pages\TransactionTypes\TransactionTypeStore;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the AppServiceProvider and all of them will
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

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {

    // Below mentioned routes are for transaction types
    Route::get('/transaction-types-index', TransactionTypesIndex::class)->name('transaction-types-index');
    Route::get('/transaction-types-store', TransactionTypeStore::class)->name('transaction-types-store');
    Route::get('/transaction-types-edit/{transactionType}', TransactionTypeEdit::class)->name('transaction-types-edit');

    //Below mentioned routes are for transactions
    Route::get('/transactions-index', TransactionsIndex::class)->name('transactions-index');
    Route::get('/transactions-store', TransactionsStore::class)->name('transactions-store');

    // Below mentioned routes are for File Upload.
    Route::get('/upload-index', [UploadDataController::class, 'index'])->name('upload-index');
    Route::post('/upload-data', [UploadDataController::class, 'uploadData'])->name('upload-data');
});

Route::get('/html/{layoutName?}', function (?string $layoutName = null) {
    return ! empty($layoutName) ? view('temp.' . $layoutName) : 'No layout Found';
});

Route::fallback(function () {
    abort(404, 'You are on the wrong please find good one');
});
