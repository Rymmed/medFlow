@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Appointments -->
            <div class="col-md-12 card">
                <x-patient-record.table-header :title="'Mes Demandes'"></x-patient-record.table-header>
                <div class="card-body px-0 pt-0 pb-2">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab"
                                    data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="false">En attente</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reported-tab" data-bs-toggle="tab"
                                    data-bs-target="#reported" type="button" role="tab" aria-controls="reported" aria-selected="false">Reportées</button>
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
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                            <x-patient-record.requests-table :appointments="$pendingRequests"></x-patient-record.requests-table>
                        </div>
                        <div class="tab-pane fade" id="reported" role="tabpanel" aria-labelledby="reported-tab">
                            <x-patient-record.requests-table :appointments="$reportedRequests"></x-patient-record.requests-table>
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
