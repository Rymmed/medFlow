@extends('layouts.user_type.auth')

@section('content')

    <div>
{{--        <div class="alert alert-secondary mx-4" role="alert">--}}
{{--        <span class="text-white">--}}
{{--            <strong>Add, Edit, Delete features are not functional!</strong> This is a--}}
{{--            <strong>PRO</strong> feature! Click <strong>--}}
{{--            <a href="https://www.creative-tim.com/live/soft-ui-dashboard-pro-laravel" target="_blank" class="text-white">here</a></strong>--}}
{{--            to see the PRO product!--}}
{{--        </span>--}}
{{--        </div>--}}

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Patients</h5>
                            </div>
                            <a href="{{ route('patients.create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Nouveau Patient</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($errors->any())
                            <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Photo
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nom
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Prénom
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Email
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Date de Création
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($patients as $patient)
                                <tr>
                                    <td>
                                        <div>
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                        </div>
{{--                                        <div>--}}
{{--                                            <img src="{{ asset('path/to/patient/photos/'.$patient->avatar) }}" class="avatar avatar-sm me-3">--}}
{{--                                        </div>--}}
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $patient->lastName }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $patient->firstName }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <x-status-badge :status="$patient->status" />
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $patient->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $patient->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('patients.edit', $patient->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Modifier">
                                            <i class="fa fa-user-edit text-secondary"></i>
                                        </a>
                                        @if ($patient->status === 0)
                                        <form id="activate-status" action="{{ route('patients.activate', $patient->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="mx-3 border-0" data-bs-toggle="tooltip" data-bs-original-title="Activer">
                                                <i class="fa fa-check text-secondary"></i>
                                            </button>
                                        </form>
                                        @else
                                            <form id="deactivate-status" action="{{ route('patients.deactivate', $patient->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                            <button type="submit" class="mx-3 border-0" data-bs-toggle="tooltip" data-bs-original-title="Désactiver">
                                                <i class="fa fa-close text-secondary"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form id="destroy" action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="mx-3 border-0" data-bs-toggle="modal" data-bs-target="#confirmationModal" data-bs-original-title="Supprimer">
                                                <i class="fa fa-trash text-secondary"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer ce patient ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn bg-gradient-danger" id="confirmDelete">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('deactivate-status').addEventListener('click', function() {
            document.getElementById('activate-status').style.display = 'none';
            document.getElementById('deactivate-status').style.display = 'block';
        });
        document.getElementById('confirmDelete').addEventListener('click', function() {
            const form = document.querySelector('#destroy');
            form.submit();
        });
    </script>
@endsection
