@extends('layouts.user_type.auth')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between mb-2">
                        <div>
                            <h5 class="mb-0">Patients</h5>
                        </div>
                        <!-- Formulaire de recherche -->
                        <form method="GET" action="{{ route('myPatients') }}">
                            <div class="input-group">
                                <span class="input-group-text text-body"><i class="fas fa-search"
                                                                            aria-hidden="true"></i></span>
                                <input type="text" id="search" name="search" class="form-control"
                                       placeholder="nom, prénom, email, tél" value="{{ request('search') }}">
                            </div>
                        </form>
                        <a href="{{ route('doctor-patients.create') }}"
                           class="btn bg-gradient-primary btn-sm mb-0" type="button"><i class="fa fa-plus"
                                                                                        aria-hidden="true"></i>
                            Nouveau Patient</a>
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
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Photo
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Nom et Prénom
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
                                    Age
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @include('doctor.patients.patients_table')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Create Modal -->
    <div class="modal fade" id="createAppointmentModal-" tabindex="-1"
         role="dialog" aria-labelledby="createAppointmentModalLabel-"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal"
                        id="createAppointmentModalLabel">Ajouter un
                        Rendez-vous</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close">
                        <span class="text-dark" aria-hidden="true"><i
                                class="fa fa-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-event-form" method="POST"
                          action="{{ route('myCalendar.add-appointment') }}">
                        @csrf
                        <input class="form-control" id="patient_id"
                               name="patient_id"
                               hidden>
                        <div class="mb-3">
                            <label for="patient_name" class="form-label">Patient</label>
                            <input type="text" class="form-control" id="patient_name"
                                   disabled>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Date
                                et heure de début</label>
                            <input type="datetime-local"
                                   class="form-control" id="start_date"
                                   name="start_date"
                                   required>
                            @error('start_date')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="consultation_duration"
                                   class="form-label">Durée de la
                                consultation (min)</label>
                            <input class="form-control" type="number"
                                   id="consultation_duration"
                                   name="consultation_duration">
                            @error('consultation_duration')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="consultation_type"
                                   class="form-label">Type de
                                consultation</label>
                            <select class="form-control"
                                    id="consultation_type"
                                    name="consultation_type" required>
                                @foreach(\App\Enums\ConsultationType::getValues() as $type)
                                    <option
                                        value="{{$type}}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('consultation_type')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                                class="btn bg-gradient-primary">Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#search').on('keyup', function () {
                let query = $(this).val();
                $.ajax({
                    url: "{{ route('myPatients') }}",
                    type: "GET",
                    data: {'search': query},
                    success: function (data) {
                        $('tbody').html(data);
                    }
                });
            });
        });
        document.querySelectorAll('[id^="add-appointment-btn-"]').forEach(button => {
            button.addEventListener('click', function () {
                let userId = this.getAttribute('data-user-id');
                document.getElementById('patient_id').value = userId;
                document.getElementById('patient_name').value = this.getAttribute('data-user-name');
                let form = document.getElementById('createAppointmentModal-' + userId);
                form.submit();
            });

        });
    </script>
@endsection
