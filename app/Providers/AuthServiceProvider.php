<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\ConsultationReport;
use App\Models\VitalSign;
use App\Policies\ConsultationReportPolicy;
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
