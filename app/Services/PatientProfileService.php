<?php
namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\User;
use App\Models\ConsultationReport;

class PatientProfileService
{
    public function getProfileData($patientId, $doctor_id = null)
    {
        $patient = User::findOrFail($patientId);
        $medicalRecord = $patient->medicalRecord;

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

        return compact(
            'patient',
            'medicalRecord',
            'familialMedicalHistories',
            'familialSurgicalHistories',
            'personalMedicalHistories',
            'personalSurgicalHistories'
        );
    }
}
