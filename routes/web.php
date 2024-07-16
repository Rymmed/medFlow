<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\AssistantDoctorController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorInfoController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
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

Route::middleware(['has.role:super-admin'])->group(function () {
    Route::get('super-admin', function () {
        return view('super-admin.home');
    })->name('super-admin.home');

    Route::resource('admins', AdminController::class);
    Route::put('admins/{admin}/activate', [AdminController::class, 'activate'])->name('admins.activate');
    Route::put('admins/{admin}/deactivate', [AdminController::class, 'deactivate'])->name('admins.deactivate');

});

Route::middleware(['has.role:admin'])->group(function () {
    Route::get('admin', function () {
        return view('admin.home');
    })->name('admin.home');

});

Route::middleware(['has.role:super-admin,admin'])->group(function () {

    Route::resource('patients', PatientController::class);
    Route::put('patients/{patient}/activate', [PatientController::class, 'activate'])->name('patients.activate');
    Route::put('patients/{patient}/deactivate', [PatientController::class, 'deactivate'])->name('patients.deactivate');

    Route::resource('doctors', DoctorController::class);
    Route::put('doctors/{doctor}/activate', [DoctorController::class, 'activate'])->name('doctors.activate');
    Route::put('doctors/{doctor}/deactivate', [DoctorController::class, 'deactivate'])->name('doctors.deactivate');

    Route::resource('assistants', AssistantController::class);
    Route::put('assistants/{assistant}/activate', [AssistantController::class, 'activate'])->name('assistants.activate');
    Route::put('assistants/{assistant}/deactivate', [AssistantController::class, 'deactivate'])->name('assistants.deactivate');
});

Route::middleware(['has.role:doctor'])->group(function () {
    Route::get('doctor', function () {
        return view('doctor.home');
    })->name('doctor.home');

    Route::resource('doctor-assistants', AssistantDoctorController::class);
    Route::put('doctor-assistants/{assistant}/activate', [AssistantDoctorController::class, 'activate'])->name('doctor-assistants.activate');
    Route::put('doctor-assistants/{assistant}/deactivate', [AssistantDoctorController::class, 'deactivate'])->name('doctor-assistants.deactivate');

    Route::get('myAppointments', [AppointmentController::class, 'myAppointments'])->name('appointments.myAppointments');
    Route::put('myAppointments/updateStatus', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    Route::put('doctor_infos/{doctor_info}', [DoctorInfoController::class, 'update'])->name('doctor_infos.update');

    Route::get('/myCalendar', [FullCalendarController::class, 'index'])->name('myCalendar');
    Route::get('/myCalendar/appointments', [FullCalendarController::class, 'getAppointments'])->name('myCalendar.appointments');
    Route::post('/myCalendar/update-appointment/{id}', [FullCalendarController::class, 'updateAppointment'])->name('myCalendar.update-appointment');
    Route::post('/myCalendar/cancel-appointment/{id}', [FullCalendarController::class, 'updateAppointment'])->name('myCalendar.cancel-appointment');
    Route::post('/myCalendar/add-appointment', [FullCalendarController::class, 'createAppointment'])->name('myCalendar.add-appointment');
});

Route::middleware(['has.role:patient'])->group(function () {
    Route::get('patient', function () {
        return view('patient.home');
    })->name('patient.home');
});


//Route::get('search', [DoctorController::class, 'search'])->name('search');
Route::match(['get', 'post'], 'search_doctors', [DoctorController::class, 'searchDoctors'])->name('search_doctors');

Route::get('/appointment/request/{doctor_id}', [AppointmentController::class, 'index'])->name('appointment.request');
Route::post('/appointment/send-request/{doctor_id}', [AppointmentController::class, 'sendAppointmentRequest'])->name('appointment.sendRequest');

Route::middleware(['has.role:assistant'])->group(function () {
    Route::get('assistant', function () {
        return view('assistant.home');
    })->name('assistant.home');

});

Route::middleware('auth')->group(function(){
    Route::get('myProfile', [ProfileController::class, 'index'])->name('myProfile');
    Route::put('update-profile', [ProfileController::class, 'update'])->name('update-profile');
    Route::put('update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    Route::put('updateProfileImg', [ProfileController::class, 'updateProfileImg'])->name('updateProfileImg');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

