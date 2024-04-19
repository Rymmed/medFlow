<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('super-admin',function(){
    return view('super-admin.home');
})->name('super-admin')->middleware('super-admin');

Route::get('admin',function(){
    return view('admin.home');
})->name('admin')->middleware('admin');

Route::get('doctor',function(){
    return view('doctor.home');
})->name('doctor')->middleware('doctor');

Route::get('patient',function(){
    return view('patient.home');
})->name('patient')->middleware('patient');

Route::get('assistant',function(){
    return view('assistant.home');
})->name('assistant')->middleware('assistant');




Route::middleware('auth')->group(function(){
    Route::get('user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('user/update-profile', [ProfileController::class, 'update'])->name('user.update-profile');
    Route::put('user/update-password', [ProfileController::class, 'updatePassword'])->name('user.update-password');
});

Auth::routes(['verify' => true]);
Route::get('/home', [HomeController::class, 'index'])->name('home');


// Route::group(['middleware' => ['role:super-admin|admin']], function() {

//     Route::resource('permissions', App\Http\Controllers\PermissionController::class);
//     Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

//     Route::resource('roles', App\Http\Controllers\RoleController::class);
//     Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
//     Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
//     Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

//     Route::resource('users', App\Http\Controllers\UserController::class);
//     Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

// });

// Route::group(['middleware' => ['auth', 'role.guard:admin']], function () {

// });

// Route::group(['middleware' => ['auth', 'role.guard:doctor']], function () {

// });

// Route::group(['middleware' => ['auth', 'role.guard:patient']], function () {

// });

// Route::group(['middleware' => ['auth', 'role.guard:assistant']], function () {

// });
