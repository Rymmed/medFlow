<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\ConsultationReport;
use App\Models\ExamResult;
use App\Models\Insurance;
use App\Models\MedicalHistory;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\PrescriptionLine;
use App\Models\Vaccination;
use App\Models\VitalSign;
use App\Policies\ConsultationReportPolicy;
use App\Policies\ExamResultPolicy;
use App\Policies\InsurancePolicy;
use App\Policies\MedicalHistoryPolicy;
use App\Policies\MedicalRecordPolicy;
use App\Policies\PrescriptionLinePolicy;
use App\Policies\PrescriptionPolicy;
use App\Policies\VaccinationPolicy;
use App\Policies\VitalSignPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ConsultationReport::class => ConsultationReportPolicy::class,
        VitalSign::class => VitalSignPolicy::class,
        Prescription::class => PrescriptionPolicy::class,
        PrescriptionLine::class => PrescriptionLinePolicy::class,
        MedicalRecord::class => MedicalRecordPolicy::class,
        MedicalHistory::class => MedicalHistoryPolicy::class,
        ExamResult::class => ExamResultPolicy::class,
        Insurance::class => InsurancePolicy::class,
        Vaccination::class => VaccinationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
