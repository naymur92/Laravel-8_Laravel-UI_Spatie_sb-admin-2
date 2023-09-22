<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // roles
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class, ['except' => ['destroy']]);
    Route::put('/change-user-status/{user}', [UserController::class, 'changeStatus'])->name('users.change-status');
    Route::get('/user-profile', [UserController::class, 'userProfile'])->name('user-profile.show');
    Route::get('/edit-profile', [UserController::class, 'editUserProfile'])->name('user-profile.edit');
    Route::put('/edit-profile', [UserController::class, 'updateUserProfile'])->name('user-profile.update');
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('user-profile.change-password');
    Route::put('/change-password', [UserController::class, 'updatePassword'])->name('user-profile.update-password');
    Route::post('/change-profile-picture', [UserController::class, 'changeProfilePicture'])->name('user-profile.change-profile-picture');
});

Route::get('/', function () {
    return view('app.home');
})->name('home');

// Auth::routes();
Auth::routes(['register' => false]);

Route::any('{slug}', function () {
    return redirect()->route('home');
})->where('slug', '.*');


// Route::get('/home', [HomeController::class, 'index'])->name('home');
