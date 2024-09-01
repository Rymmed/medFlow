@extends('layouts.user_type.auth')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Assistants</h5>
                        </div>
                        <a href="{{ route('assistants.create') }}" class="btn bg-gradient-primary btn-sm mb-0"
                           type="button">+&nbsp; Nouveau assistant</a>
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
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success"
                             role="alert">
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
                                    Nom & Prénom
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Médecin
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Email
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    N° téléphone
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Sexe
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Date d'ajout
                                </th>
                                {{--                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">--}}
                                {{--                                        Status--}}
                                {{--                                    </th>--}}
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($assistants as $assistant)
                                <tr>
                                    <td>
                                        <div>
                                            <x-profile-image :class="'avatar avatar-sm shadow-sm'"
                                                             :image="$assistant->profile_image"></x-profile-image>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $assistant->lastName }} {{ $assistant->firstName }}</p>
                                    </td>
                                    <td class="text-center">
                                        @if ($assistant->doctor)
                                            <p class="text-xs font-weight-bold mb-0">
                                                Dr. {{ $assistant->doctor->firstName }} {{ $assistant->doctor->lastName }}</p>
                                        @else
                                            <p class="text-xs font-weight-bold mb-0">Aucun médecin associé</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $assistant->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $assistant->phone_number ? : '---' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">@if($assistant->gender === 0)
                                                {{ __('Homme') }}
                                            @else
                                                {{ __('Femme') }}
                                            @endif</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $assistant->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    {{--                                    <td class="align-middle text-center text-sm">--}}
                                    {{--                                        <x-status-badge :status="$assistant->status" />--}}
                                    {{--                                    </td>--}}
                                    <td class="text-center">
                                        <a href="{{ route('assistants.edit', $assistant->id) }}"
                                           data-bs-toggle="tooltip" data-bs-original-title="Modifier">
                                            <i class="fa fa-user-edit text-blue"></i>
                                        </a>
                                        {{--                                        @if ($assistant->status === 0)--}}
                                        {{--                                        <form id="activate-status" action="{{ route('assistants.activate', $assistant->id) }}" method="POST" class="d-inline">--}}
                                        {{--                                            @csrf--}}
                                        {{--                                            @method('PUT')--}}
                                        {{--                                            <button type="submit" class="mx-3 border-0" data-bs-toggle="tooltip" data-bs-original-title="Activer">--}}
                                        {{--                                                <i class="fa fa-check text-secondary"></i>--}}
                                        {{--                                            </button>--}}
                                        {{--                                        </form>--}}
                                        {{--                                        @else--}}
                                        {{--                                            <form id="deactivate-status" action="{{ route('assistants.deactivate', $assistant->id) }}" method="POST" class="d-inline">--}}
                                        {{--                                                @csrf--}}
                                        {{--                                                @method('PUT')--}}
                                        {{--                                            <button type="submit" class="mx-3 border-0" data-bs-toggle="tooltip" data-bs-original-title="Désactiver">--}}
                                        {{--                                                <i class="fa fa-close text-secondary"></i>--}}
                                        {{--                                            </button>--}}
                                        {{--                                        </form>--}}
                                        {{--                                        @endif--}}
                                        <form id="destroy-{{ $assistant->id }}" action="{{ route('assistants.destroy', $assistant->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <a type="button" class="mx-3 border-0" data-bs-toggle="modal" data-bs-target="#confirmationModal-{{ $assistant->id }}" data-bs-original-title="Supprimer">
                                                <i class="fa fa-trash text-primary"></i>
                                            </a>
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
    <!-- Modal de confirmation -->
    <div class="modal fade" id="confirmationModal-{{ $assistant->id }}" tabindex="-1" aria-labelledby="confirmationModalLabel-{{ $assistant->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel-{{ $assistant->id }}">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce médecin ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn bg-gradient-danger" id="confirmDelete-" data-user-id="{{ $assistant->id }}">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('[id^="confirmDelete-"]').forEach(button => {
            button.addEventListener('click', function () {
                let userId = this.getAttribute('data-user-id');
                let form = document.getElementById('destroy-' + userId);
                form.submit();
            });
        });
        document.getElementById('deactivate-status').addEventListener('click', function () {
            document.getElementById('activate-status').style.display = 'none';
            document.getElementById('deactivate-status').style.display = 'block';
        });
    </script>
@endsection
