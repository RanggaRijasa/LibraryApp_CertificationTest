<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberLoanController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

Route::get('/dashboard', function () {
    $role = auth()->user()->role ?? 'member';

    if (in_array($role, ['staff', 'admin'], true)) {
        return redirect()->route('loans.index');
    }

    return redirect()->route('catalog');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->prefix('member')->name('member.')->group(function () {
    // Peminjaman saya (member)
    Route::get('/loans', [MemberLoanController::class, 'index'])->name('loans.index');

    // Pinjam buku (7 hari)
    Route::post('/borrow/{book}', [MemberLoanController::class, 'borrow'])->name('borrow');
});

Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::resource('books', BookController::class)->except(['show']);

    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
});

require __DIR__ . '/auth.php';
