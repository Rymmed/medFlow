<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\AssistantDoctorController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ConsultationReportController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorInfoController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\PrescriptionLineController;
use App\Http\Controllers\user\ProfileController;
use App\Http\Controllers\VaccinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
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
        return view('super-admin.dashboard');
    })->name('super-admin.dashboard');

    Route::resource('admins', AdminController::class);
    Route::put('admins/{admin}/activate', [AdminController::class, 'activate'])->name('admins.activate');
    Route::put('admins/{admin}/deactivate', [AdminController::class, 'deactivate'])->name('admins.deactivate');

});

Route::middleware(['has.role:admin'])->group(function () {
    Route::get('admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

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
        return view('doctor.dashboard');
    })->name('doctor.dashboard');

    Route::resource('doctor-assistants', AssistantDoctorController::class);
    Route::put('doctor-assistants/{assistant}/activate', [AssistantDoctorController::class, 'activate'])->name('doctor-assistants.activate');
    Route::put('doctor-assistants/{assistant}/deactivate', [AssistantDoctorController::class, 'deactivate'])->name('doctor-assistants.deactivate');

    Route::get('myAppointments', [AppointmentController::class, 'myAppointments'])->name('appointments.myAppointments');
    Route::put('myAppointments/updateStatus', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    Route::get('myPatients', [PatientController::class, 'myPatients'])->name('myPatients');

    Route::put('doctor_infos/{doctor_info}', [DoctorInfoController::class, 'update'])->name('doctor_infos.update');

    Route::get('/myCalendar', [FullCalendarController::class, 'index'])->name('myCalendar');
    Route::get('/myCalendar/appointments', [FullCalendarController::class, 'getAppointments'])->name('myCalendar.appointments');
    Route::put('/myCalendar/update-appointment/{id}', [FullCalendarController::class, 'updateAppointment'])->name('myCalendar.update-appointment');
    Route::post('/myCalendar/drop-appointment/{id}', [FullCalendarController::class, 'dropAppointment'])->name('myCalendar.drop-appointment');
    Route::post('/myCalendar/cancel-appointment/{id}', [FullCalendarController::class, 'cancelAppointment'])->name('myCalendar.cancel-appointment');
    Route::post('/myCalendar/add-appointment', [FullCalendarController::class, 'createAppointment'])->name('myCalendar.add-appointment');
});

Route::middleware(['has.role:patient'])->group(function () {
    Route::get('patient', function () {
        return view('patient.dashboard');
    })->name('patient.dashboard');
});


//Route::get('search', [DoctorController::class, 'search'])->name('search');
Route::match(['get', 'post'], 'search_doctors', [DoctorController::class, 'searchDoctors'])->name('search_doctors');

Route::get('/appointment/request/{doctor_id}', [AppointmentController::class, 'requestForm'])->name('appointment.request');
Route::post('/appointment/send-request/{doctor_id}', [AppointmentController::class, 'sendAppointmentRequest'])->name('appointment.sendRequest');

Route::middleware(['has.role:assistant'])->group(function () {
    Route::get('assistant', function () {
        return view('assistant.dashboard');
    })->name('assistant.dashboard');

});


Route::middleware(['auth'])->group(function () {
    Route::get('myProfile', [ProfileController::class, 'index'])->name('myProfile');
    Route::put('update-profile', [ProfileController::class, 'update'])->name('update-profile');
    Route::put('update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    Route::put('updateProfileImg', [ProfileController::class, 'updateProfileImg'])->name('updateProfileImg');

    Route::get('/patient-{patient_id}/appointment-{appointment_id}/record', [PatientController::class, 'showPatientDetails'])->name('patient.record');
    Route::get('patients/{patient_id}/record', [PatientController::class, 'showPatientDetails'])->name('myPatient.record');

    Route::get('patients/{record_id}/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('consultationReport/{report_id}/medicalRecord/{record_id}/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescription.create');
    Route::post('consultationReport/{report_id}/prescriptions', [PrescriptionController::class, 'store'])->name('prescription.store');
    Route::get('/prescriptions/{prescription_id}/show', [PrescriptionController::class, 'show'])->name('prescription.show');
    Route::get('/prescriptions/{prescription_id}/edit', [PrescriptionController::class, 'edit'])->name('prescription.edit');
    Route::put('/prescriptions/{prescription_id}/update', [PrescriptionController::class, 'update'])->name('prescription.update');
    Route::delete('/prescriptions/{prescription_id}', [PrescriptionController::class, 'destroy'])->name('prescription.destroy');

    Route::resource('prescription-lines', PrescriptionLineController::class);

    Route::get('/consultationReports/{patient_id}', [ConsultationReportController::class, 'index'])->name('consultationReport.index');
    Route::get('/consultationReport/create/{appointment_id}', [ConsultationReportController::class, 'create'])->name('consultationReport.create');
    Route::post('/consultationReport/{appointment_id}', [ConsultationReportController::class, 'store'])->name('consultationReport.store');
    Route::get('/consultationReport/show/{consultationReport}', [ConsultationReportController::class, 'show'])->name('consultationReport.show');
    Route::get('/consultationReport/{consultationReport}/edit', [ConsultationReportController::class, 'edit'])->name('consultationReport.edit');
    Route::put('/consultationReport/{consultationReport}', [ConsultationReportController::class, 'update'])->name('consultationReport.update');
    Route::delete('/consultationReport/{consultationReport_id}', [ConsultationReportController::class, 'destroy'])->name('consultationReport.destroy');
    Route::get('/consultationReports/search', [ConsultationReportController::class, 'search'])->name('consultationReport.search');

    Route::post('/medicalHistories/{medicalRecord_id}', [MedicalHistoryController::class, 'store'])->name('medicalHistory.store');
    Route::put('/medicalHistory/{medicalHistory_id}', [MedicalHistoryController::class, 'update'])->name('medicalHistory.update');
    Route::delete('/medicalRecord/medicalHistories/{medicalHistory_id}', [MedicalHistoryController::class, 'destroy'])->name('medicalHistory.destroy');

    Route::post('/insurance/{medicalRecord_id}', [InsuranceController::class, 'store'])->name('insurance.store');
    Route::put('/insurance/{insurance_id}', [InsuranceController::class, 'update'])->name('insurance.update');
    Route::delete('/medicalRecord/insurance/{insurance_id}', [InsuranceController::class, 'destroy'])->name('insurance.destroy');

    Route::post('/medicalRecord/{medicalRecord_id}/vaccination', [VaccinationController::class, 'store'])->name('vaccination.store');
    Route::put('/medicalRecord/vaccinations/{vaccination_id}', [VaccinationController::class, 'update'])->name('vaccination.update');
    Route::delete('/medicalRecord/vaccinations/{vaccination_id}', [VaccinationController::class, 'destroy'])->name('vaccination.destroy');

    Route::post('/medicalRecord/{medicalRecord_id}/examResult', [ExamResultController::class, 'store'])->name('examResult.store');
    Route::put('/medicalRecord/examResults/{examResult_id}', [ExamResultController::class, 'update'])->name('examResult.update');
    Route::delete('/medicalRecord/examResults/{examResult_id}', [ExamResultController::class, 'destroy'])->name('examResult.destroy');
    Route::get('/storage/{doc}', [ExamResultController::class, 'downloadDoc'])->name('download.doc');

    Route::put('/medicalRecord/{medicalRecord_id}', [MedicalRecordController::class, 'update'])->name('medicalRecord.update');
    Route::put('/medicalRecord/{medicalRecord_id}/vitalSigns', [MedicalRecordController::class, 'updateVitalSigns'])->name('vitalSigns.update');

    Route::get('/consultation/room/{appointment_id}', [ConsultationController::class, 'showConsultationRoom'])
        ->name('consultation.room');
    Route::post('/consultations/{appointmentId}/start', [ConsultationController::class, 'startOnlineConsultation'])
        ->name('consultations.start');
    Route::get('/consultations/{appointment_id}/join', [ConsultationController::class, 'joinOnlineConsultation'])
        ->name('consultations.join');
    Route::post('/appointment/completed/{appointmentId}', [ConsultationController::class, 'completeAppointment']);

});
Auth::routes();
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

