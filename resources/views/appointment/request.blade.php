@extends('layouts.user_type.auth')

@section('content')
    <form action="{{ route('appointment.sendRequest', ['doctor_id' => $doctor_id])  }}" method="POST">
        @csrf
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
        <input type="hidden" name="patient_id" value="{{ Auth::user()->id }}">

        <div class="mb-3">
            <label for="start_date">Date de début :</label>
            <input type="datetime-local" id="start_date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="finish_date">Date de fin :</label>
            <input type="datetime-local" id="finish_date" name="finish_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="consultation_reason">Motif de consultation :</label>
            <input type="text" id="consultation_reason" name="consultation_reason" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="consultation_type">Type de consultation :</label>
            <select id="consultation_type" name="consultation_type" class="form-control" required>
                <option value="En ligne">En ligne</option>
                <option value="En présentiel">En présentiel</option>
                <option value="Service à domicile">Service à domicile</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer la demande de rendez-vous</button>
    </form>

@endsection
