<?php

use App\Http\Controllers\admin\AdminHomeController;
use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Controllers\admin\auth\AdminRegisterController;
use App\Http\Controllers\AdminController;
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
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('admin/dashboard/home', [AdminHomeController::class, 'index'])->name('admin.dashboard.home');

Route::get('admin/dashboard/login', [AdminLoginController::class, 'login'])->name('admin.dashboard.login');

Route::post('admin/dashboard/login', [AdminLoginController::class, 'checkLogin'])->name('admin.dashboard.check');

Route::get('admin/dashboard/register', [AdminRegisterController::class, 'register'])->name('admin.dashboard.register');

Route::post('admin/dashboard/register', [AdminRegisterController::class, 'store'])->name('admin.dashboard.store');
