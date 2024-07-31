<?php

use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AdminUserController;

Route::prefix('admin')->middleware('auth')->group(function () {
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});



Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('documents', DocumentController::class);

    Route::get('generate-qr/{id}', [DocumentController::class, 'generateQR'])->name('documents.generateQR');
});

Route::middleware('auth')->group(function () {
    Route::get('view-document/{qr_code}', [DocumentController::class, 'viewDocument'])->name('documents.view');
    Route::get('profile', [UserController::class, 'profile_index'])->name('profile.index');
    Route::put('profile/{user}', [UserController::class, 'profile'])->name('profile.update');
    Route::get('document', [UserController::class, 'document'])->name('documentss.index');
    Route::get('document_show/{document}', [UserController::class, 'show'])->name('documents.show');
    Route::get('open_document/{document}', [DocumentController::class, 'openDocument'])->name('documents.open');
});



Auth::routes();
