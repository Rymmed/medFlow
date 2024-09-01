@extends('layouts.user_type.auth')

@section('content')
    <div class="container">

        <div class="row">
            <!-- Appointments -->
            <div class="col-md-12 card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Mes demandes</h5>
                        </div>
                        <button class="btn bg-gradient-primary btn-md mb-0 glow-button" type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModalMessage">
                            <i class="far fa-calendar-plus me-1"></i> Nouveau Rendez-Vous
                        </button>


                        <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="exampleModalLabel">{{ __('Trouver un médecin') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                    <span class="text-dark" aria-hidden="true"><i
                                                            class="fa fa-close"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form role="form" action="{{ route('search_doctors') }}"
                                              method="POST">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <select id="speciality" name="speciality[]"
                                                        class="form-control"
                                                        aria-label="speciality" multiple>
                                                    @foreach(config('specialities') as $speciality)
                                                        <option
                                                            value="{{ $speciality }}">{{ $speciality }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="form-group mb-3 col-6">
                                                    <input type="text" id="city" name="city"
                                                           class="form-control" aria-label="city"
                                                           placeholder="Ville">
                                                </div>
                                                <div class="form-group mb-3 col-6">
                                                    <input type="text" id="country" name="country"
                                                           class="form-control" aria-label="country"
                                                           placeholder="Pays">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit"
                                                        class="btn bg-gradient-primary">{{ __('Rechercher') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="requests-tab" data-bs-toggle="tab"
                                    data-bs-target="#requests" type="button" role="tab" aria-controls="requests" aria-selected="false">En attente</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reschedule-tab" data-bs-toggle="tab"
                                    data-bs-target="#reschedule" type="button" role="tab" aria-controls="reschedule" aria-selected="false">Reportées</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="canceled-tab" data-bs-toggle="tab"
                                    data-bs-target="#canceled" type="button" role="tab" aria-controls="canceled" aria-selected="false">Annulées</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="refused-tab" data-bs-toggle="tab"
                                    data-bs-target="#refused" type="button" role="tab" aria-controls="refused" aria-selected="false">Refusées</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="requests" role="tabpanel" aria-labelledby="requests-tab">
                            <x-patient-record.requests-table :appointments="$appointmentRequests"></x-patient-record.requests-table>
                        </div>
                        <div class="tab-pane fade" id="reschedule" role="tabpanel" aria-labelledby="reschedule-tab">
                            <x-patient-record.requests-table :appointments="$appointmentReported"></x-patient-record.requests-table>
                        </div>
                        <div class="tab-pane fade" id="canceled" role="tabpanel" aria-labelledby="canceled-tab">
                            <x-patient-record.requests-table :appointments="$canceledRequests"></x-patient-record.requests-table>
                        </div>
                        <div class="tab-pane fade" id="refused" role="tabpanel" aria-labelledby="refused-tab">
                            <x-patient-record.requests-table :appointments="$refusedRequests"></x-patient-record.requests-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
