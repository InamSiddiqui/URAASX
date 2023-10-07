<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('settings.edit');
    Route::patch('/settings', [App\Http\Controllers\ProfileController::class, 'updateSettings'])->name('settings.update');

    Route::get('/profile', [App\Http\Controllers\UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::post('/users/change-photo', [App\Http\Controllers\UserController::class, 'changePhoto'])->name('user.changephoto');

    Route::resource('/documents', App\Http\Controllers\DocumentController::class);
});


//Start: Admin Routes


Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');

    Route::get('admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');

    Route::get('admin/users/{user?}/view', [AdminUserController::class, 'show'])->name('admin.user.view');

    Route::post('admin/users/{user?}/changestatus', [AdminUserController::class, 'changestatus'])->name('admin.user.changestatus');
    
});
//End: Admin Routes


require __DIR__.'/auth.php';
require __DIR__.'/admin_auth.php';
