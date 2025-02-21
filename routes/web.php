<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\ActivityLogController;
use App\Models\Transfer;
use App\Models\TransferredItem;

// Display the form
Route::get('/additem', [TransferController::class, 'create'])->name('additem');
Route::get('/transfer', [TransferController::class, 'index'])->name('transfer');
// Handle form submission
Route::post('/additem', [TransferController::class, 'store'])->name('transfers.store');
Route::get('/activity-history', [ActivityLogController::class, 'index'])->name('activity.history');

Route::post('/items/{item}/transfer', [TransferController::class, 'transferItem'])->name('items.transfer');
Route::get('/transferred', [TransferController::class, 'transferred'])->name('transferred');
// Show routes for transfers
Route::get('/transfers/{transfer}/show', [TransferController::class, 'show'])->name('transfers.show');
Route::get('/transferred/{transfer}/show', [TransferController::class, 'showTransferred'])->name('transferred.show');
Route::get('/transferred/{transfer}/edit', [TransferController::class, 'editTransferred'])->name('transferred.edit');
Route::get('/transferred/export/{transferId}', [TransferController::class, 'exportTransferredItems'])->name('transferred.export');

// Admin Dashboard Route
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    if (Auth::user()->role !== 'admin') {
        return redirect()->route('user.dashboard')->with('error', 'Access denied. Redirected to User Dashboard.');
    }

    // Get counts
    $userCount = \App\Models\User::count();

    // Count items in transfer (not yet transferred)
    $transferCount = Transfer::whereHas('items', function($query) {
        $query->whereDoesntHave('transferredItem');
    })->count();

    // Count transferred items
    $transferredCount = Transfer::whereHas('items.transferredItem')->count();

    return view('dashboard', compact('userCount', 'transferCount', 'transferredCount'));
})->name('dashboard');

// User Dashboard Route with Role Check
Route::middleware(['auth', 'verified'])->get('/user-dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('dashboard')->with('error', 'Admins cannot access the User Dashboard.');
    }
        // Count items in transfer (not yet transferred)
        $transferCount = Transfer::whereHas('items', function($query) {
            $query->whereDoesntHave('transferredItem');
        })->count();

        // Count transferred items
        $transferredCount = Transfer::whereHas('items.transferredItem')->count();
    return view('user-dashboard',  compact( 'transferCount', 'transferredCount'));
})->name('user.dashboard');

Route::get('/additem', [ItemController::class, 'create'])->name('additem');

// Handle form submission
Route::post('/additem', [ItemController::class, 'store'])->name('items.store');

Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
Route::get('/transfers/{transfer}/edit', [TransferController::class, 'edit'])->name('transfers.edit');
// Route to handle the edit form submission
Route::put('/transfers/{transfer}', [TransferController::class, 'update'])->name('transfers.update');

// User Management Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user-management', [UserController::class, 'index'])->name('user.management');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/transfers/{transfer}', [TransferController::class, 'destroy'])->name('transfers.destroy');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
Route::get('/transferred/{transfer_id}/items', [TransferController::class, 'getTransferredItems']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/additem', function () {
        return view('additem');
    })->name('additem');
});

// Welcome Page
Route::get('/', function () {
    return view('auth/login');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes
require __DIR__.'/auth.php';
