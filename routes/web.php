<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
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


//Route::group(['middleware' => 'auth'], function () {
//
//    Route::get('/', [HomeController::class, 'home']);
//	Route::get('dashboard', function () {
//		return view('dashboard');
//	})->name('dashboard');
//
//	Route::get('billing', function () {
//		return view('billing');
//	})->name('billing');
//
//	Route::get('profile', function () {
//		return view('profile');
//	})->name('profile');
//
//	Route::get('rtl', function () {
//		return view('rtl');
//	})->name('rtl');
//
//	Route::get('user-management', function () {
//		return view('laravel-examples/user-management');
//	})->name('user-management');
//
//	Route::get('tables', function () {
//		return view('tables');
//	})->name('tables');
//
//    Route::get('virtual-reality', function () {
//		return view('virtual-reality');
//	})->name('virtual-reality');
//
//    Route::get('static-sign-in', function () {
//		return view('static-sign-in');
//	})->name('sign-in');
//
//    Route::get('static-sign-up', function () {
//		return view('static-sign-up');
//	})->name('sign-up');
//
//    Route::get('/logout', [SessionsController::class, 'destroy']);
//	Route::get('/user-profile', [InfoUserController::class, 'create']);
//	Route::post('/user-profile', [InfoUserController::class, 'store']);
//    Route::get('/login', function () {
//		return view('dashboard');
//	})->name('sign-up');
//});



//Route::group(['middleware' => 'guest'], function () {
//    Route::get('/register', [RegisterController::class, 'create']);
//    Route::post('/register', [RegisterController::class, 'store']);
//    Route::get('/login', [SessionsController::class, 'create']);
//    Route::post('/session', [SessionsController::class, 'store']);
//	Route::get('/login/forgot-password', [ResetController::class, 'create']);
//	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
//	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
//	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
//
//});
//
//Route::get('/login', function () {
//    return view('session/login-session');
//})->name('login');
//


Route::get('/', function () {
    return view('welcome');
});

Route::get('superadmin',function(){
    return view('superadmin');
})->name('superadmin')->middleware('superadmin');

Route::get('admin',function(){
    return view('admin');
})->name('admin')->middleware('admin');

Route::get('doctor',function(){
    return view('doctor');
})->name('doctor')->middleware('doctor');

Route::get('patient',function(){
    return view('patient');
})->name('patient')->middleware('patient');

Route::get('assistant',function(){
    return view('assistant');
})->name('assistant')->middleware('assistant');

// Route::resource('permissions', \App\Http\Controllers\PermissionController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
