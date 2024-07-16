@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-2 text-center">
            <img class="avatar avatar-xxl border-radius-section shadow" src="{{asset('assets/img/bruce-mars.jpg')}}" alt="doctor_photo">
        </div>
        <div class="col-3">
            <h6 class="card-title">Dr. {{ $doctor->lastName }} {{ $doctor->firstName }}</h6>
            <p class="card-text text-sm"><i class="fas fa-notes-medical mx-2"></i>{{ $doctor->speciality }}</p>
            <p class="card-text text-sm mt-3"><i class="fas fa-map-marker-alt mx-2"></i>{{ $doctor->city }} {{ $doctor->country }}</p>
            <p class="card-text text-sm"><i class="fas fa-phone-alt mx-2"></i>{{ $doctor->phone_number }}</p>
        </div>
        <div class="col-6">
            <p class="text-dark text-bold text-sm">Disponibilité: </p>
            <p class="text-sm">{{ $doctor->doctor_info->formattedDays() }}</p>
            <p class="text-sm">{{ $doctor->doctor_info->formattedTime() }}</p>
        </div>
    </div>

    <hr class="horizontal dark mt-2">
    <div class="container-fluid py-4">
        <form action="{{ route('appointment.sendRequest', ['doctor_id' => $doctor->id])  }}" method="POST" role="form text-left">
            @csrf
            @if($errors->any())
                <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                    </span>
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

            <div class="row d-flex">
                <div class="col-4 mb-3">
                    <label for="start_time">Date et heure :</label>
                    <div class="@error('date')border border-danger rounded-3 @enderror">
                        <input type="datetime-local" id="start_time" name="start_time" class="form-control" required>
                        @error('start_time')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

{{--                <div class="col-4 mb-3">--}}
{{--                    <label for="time">Heure :</label>--}}
{{--                    <div class="@error('time')border border-danger rounded-3 @enderror">--}}
{{--                        <input type="time" id="time" name="time" class="form-control" required>--}}
{{--                        @error('time')--}}
{{--                        <p class="text-danger text-xs mt-2">{{ $message }}</p>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="col-4 mb-3">
                    <label for="consultation_type">Type de consultation :</label>
                    <select id="consultation_type" name="consultation_type" class="form-control" required>
{{--                        <option value="Online">En ligne</option>--}}
{{--                        <option value="In Person">En cabinet</option>--}}
{{--                        <option value="Home Service">Service à domicile</option>--}}
                        @foreach(App\Enums\ConsultationType::getValues() as $type)
                            <option value="{{ $type }}" {{ $type === $consultation_info->type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row d-flex">
                <div class="col-4 mb-3">
                    <label for="consultation_reason">Motif de consultation :</label>
                    <div class="@error('consultation_reason')border border-danger rounded-3 @enderror">
                        <textarea id="consultation_reason" name="consultation_reason" class="form-control" rows="4" placeholder="{{ __('Pourquoi vous voulez un rendez-vous?') }}" required></textarea>
                        @error('consultation_reason')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Envoyer la demande de rendez-vous</button>
        </form>
    </div>
@endsection
