@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-end">
            {{--        <h2>Doctor Dashboard</h2>--}}
            {{--        <h3>Appointment Requests</h3>--}}
            {{--        <ul>--}}
            {{--            @foreach($appointments as $appointment)--}}
            {{--                @if(!$appointment->status= \App\Enums\AppointmentStatus::CONFIRMED)--}}
            {{--                    <li>--}}
            {{--                        <a href="#">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</a>--}}
            {{--                    </li>--}}
            {{--                @endif--}}
            {{--            @endforeach--}}
            {{--        </ul>--}}
            {{--        <h3>Confirmed Appointments</h3>--}}
            {{--        <ul>--}}
            {{--            @foreach($appointments as $appointment)--}}
            {{--                @if($appointment->status= \App\Enums\AppointmentStatus::CONFIRMED)--}}
            {{--                    <li>--}}
            {{--                        <a href="#">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</a>--}}
            {{--                    </li>--}}
            {{--                @endif--}}
            {{--            @endforeach--}}
            {{--        </ul>--}}
        </div>
    </div>
@endsection


