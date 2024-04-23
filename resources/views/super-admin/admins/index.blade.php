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
                                <h5 class="mb-0">Administrateurs</h5>
                            </div>
                            <a href="{{ route('admins.create') }}" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Nouveau Admin</a>
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
                                @foreach($admins as $admin)
                                <tr>
                                    <td>
                                        <div>
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                        </div>
{{--                                        <div>--}}
{{--                                            <img src="{{ asset('path/to/admin/photos/'.$admin->avatar) }}" class="avatar avatar-sm me-3">--}}
{{--                                        </div>--}}
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->lastName }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->firstName }}</p>
                                    </td>
                                    @if ($admin->status === 0)
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-secondary">Désactivé</span>
                                        </td>
                                    @else
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">Activé</span>
                                        </td>
                                    @endif
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $admin->created_at->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admins.edit', $admin->id) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Modifier">
                                            <i class="fa fa-user-edit text-secondary"></i>
                                        </a>
                                        @if ($admin->status === 0)
                                        <form id="activate-status" action="{{ route('admins.activate', $admin->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="mx-3 border-0" data-bs-toggle="tooltip" data-bs-original-title="Activer">
                                                <i class="fa fa-check text-secondary"></i>
                                            </button>
                                        </form>
                                        @else
                                            <form id="deactivate-status" action="{{ route('admins.deactivate', $admin->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                            <button type="submit" class="mx-3 border-0" data-bs-toggle="tooltip" data-bs-original-title="Désactiver">
                                                <i class="fa fa-close text-secondary"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form id="deactivate-status" action="{{ route('admins.destroy', $admin->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mx-3 border-0" data-bs-toggle="tooltip" data-bs-original-title="Supprimer">
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
    </div>
    <script>
        document.getElementById('status').addEventListener('click', function() {
            document.getElementById('activate-status').style.display = 'none';
            document.getElementById('deactivate-status').style.display = 'block';
        });
        document.getElementById('activate-status').addEventListener('click', function() {
            document.getElementById('deactivate-status').style.display = 'none';
            document.getElementById('activate-status').style.display = 'block';
        });
    </script>
@endsection
