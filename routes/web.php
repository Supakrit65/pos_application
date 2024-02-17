<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LineItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MemberController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'addMember'])->name('members.store');
Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('members.edit');
Route::patch('/members/{id}', [MemberController::class, 'editMember'])->name('members.update');
Route::delete('/members/{id}', [MemberController::class, 'deleteMember'])->name('members.destroy');
Route::get('/members/get', [MemberController::class, 'getMember'])->name('members.getMember');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Transaction routes
Route::middleware('auth')->group(function () {
    // Adjusted to use the correct method for initiating or displaying the transaction page
    Route::post('/transactions/check-member', [TransactionController::class, 'checkMember'])->name('transactions.checkMember');
    Route::get('/transactions/open', [TransactionController::class, 'openSale'])->name('transactions.open');
    Route::post('/transactions/addLineItem', [TransactionController::class, 'addLineItemToSale'])->name('sales.addLineItem');
    Route::delete('/transactions/removeLineItem/{lineItemId}', [TransactionController::class, 'removeLineItemFromSale'])->name('sales.removeLineItem');
    Route::post('/transactions/process-payment/{sale}', [TransactionController::class, 'processPayment'])->name('transactions.processPayment');
    Route::get('/payments', [TransactionController::class, 'viewPayments'])->name('payments.view');
    Route::post('/transactions/remove-member', [TransactionController::class, 'removeMember'])->name('transactions.removeMember');
});

Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'createItem'])->name('items.createItem');
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::patch('/items/{item}', [ItemController::class, 'updateItem'])->name('items.updateItem');
Route::delete('/items/{item}', [ItemController::class, 'deleteItem'])->name('items.deleteItem');
require __DIR__.'/auth.php';
