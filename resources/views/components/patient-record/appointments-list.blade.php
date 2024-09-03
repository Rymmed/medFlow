<div class="card-body px-0 pt-0 pb-2">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab"
                    data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="true">À
                venir
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="old-tab" data-bs-toggle="tab"
                    data-bs-target="#old" type="button" role="tab" aria-controls="old" aria-selected="false">
                Anciens
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="all-tab" data-bs-toggle="tab"
                    data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="false">Tous
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <x-patient-record.appointments-table
                :appointments="$upcomingAppointments" :tab_id="'upcoming'"></x-patient-record.appointments-table>
            @if(!Route::is('dashboard'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $upcomingAppointments->links() }}
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="old" role="tabpanel" aria-labelledby="old-tab">
            <x-patient-record.appointments-table
                :appointments="$oldAppointments" :tab_id="'old'"></x-patient-record.appointments-table>
            @if(!Route::is('dashboard'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $oldAppointments->links() }}
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
            <x-patient-record.appointments-table :appointments="$appointments"
                                                 :tab_id="'all'"></x-patient-record.appointments-table>
            @if(!Route::is('dashboard'))
                <div class="d-flex justify-content-center mt-3">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>
    </div>
    @if(Route::is('dashboard'))
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('patient.appointments') }}" class="text-info text-sm mb-0 animate-link">
                Afficher Plus <i class="fas fa-angles-down text-xs"></i>
            </a>
        </div>
    @endif
</div>

