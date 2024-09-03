<div class="modal fade" id="publicProfileModal-{{ $appointment->id }}" tabindex="-1"
     role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Informations sur le patient</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <div class="modal-body mx-2">
                <div class="text-center">
                    <x-profile-image class="'avatar avatar-xl border-radius-section shadow-sm me-5'"
                                     :image="$appointment->patient->profile_image"></x-profile-image>
                    <h6 class="mt-3">{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</h6>
                    <p class="text-secondary">
                        {{ \Carbon\Carbon::parse($appointment->patient->dob)->age }} ans,
                        {{ $appointment->patient->gender === 0 ? 'Homme' : 'Femme' }}
                    </p>
                </div>
                <div class="row mt-4 text-center">
                    <div class="col-6">
                        <p class="text-sm text-secondary">{{ __('Adresse') }}</p>
                        <p class="text-dark">{{ $appointment->patient->address }}</p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm text-secondary">{{ __('Ville') }}</p>
                        <p class="text-dark">{{ $appointment->patient->city }}</p>
                    </div>
                </div>
                <div class="row mt-2 text-center">
                    <div class="col-6">
                        <p class="text-sm text-secondary">{{ __('Email') }}</p>
                        <p class="text-dark">{{ $appointment->patient->email }}</p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm text-secondary">{{ __('Numéro de téléphone') }}</p>
                        <p class="text-dark">{{ $appointment->patient->phone_number }}</p>
                    </div>
                </div>
                <div class="row mt-2 text-center">
                    <div class="col-6">
                        <p class="text-sm text-secondary">{{ __('Pays') }}</p>
                        <p class="text-dark">{{ $appointment->patient->country }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{ route('appointments.updateStatus') }}" method="POST" class="d-inline me-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="status" value="{{ \App\Enums\AppointmentStatus::CONFIRMED }}">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> {{ __('Confirmer') }}
                    </button>
                </form>
                <form action="{{ route('appointments.updateStatus') }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                    <input type="hidden" name="status" value="{{ \App\Enums\AppointmentStatus::REFUSED }}">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> {{ __('Refuser') }}
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
