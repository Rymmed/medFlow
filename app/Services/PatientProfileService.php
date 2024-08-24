<?php
namespace App\Services;

use App\Models\User;
use App\Models\ConsultationReport;

class PatientProfileService
{
    public function getProfileData($patientId, $doctor_id = null)
    {
        $patient = User::findOrFail($patientId);
        $medicalRecord = $patient->medicalRecord;
        $appointments = $patient->patientAppointments;

        if ($doctor_id) {
            $appointments = $appointments->where('doctor_id', $doctor_id);
        }

        $familialMedicalHistories = $medicalRecord->medicalHistories
            ->where('type', \App\Enums\MedicalHistType::FAMILIAL)
            ->where('subtype', \App\Enums\MedicalHistSubtype::MEDICAL);

        $familialSurgicalHistories = $medicalRecord->medicalHistories
            ->where('type', \App\Enums\MedicalHistType::FAMILIAL)
            ->where('subtype', \App\Enums\MedicalHistSubtype::SURGICAL);

        $personalMedicalHistories = $medicalRecord->medicalHistories
            ->where('type', \App\Enums\MedicalHistType::PERSONAL)
            ->where('subtype', \App\Enums\MedicalHistSubtype::MEDICAL);

        $personalSurgicalHistories = $medicalRecord->medicalHistories
            ->where('type', \App\Enums\MedicalHistType::PERSONAL)
            ->where('subtype', \App\Enums\MedicalHistSubtype::SURGICAL);

        $consultationReports = ConsultationReport::whereHas('appointment', function ($query) use ($appointments) {
            $query->whereIn('id', $appointments->pluck('id'));
        })->paginate(10);

        return compact(
            'patient',
            'medicalRecord',
            'appointments',
            'consultationReports',
            'familialMedicalHistories',
            'familialSurgicalHistories',
            'personalMedicalHistories',
            'personalSurgicalHistories'
        );
    }
}
