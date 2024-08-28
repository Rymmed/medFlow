@extends('layouts.user_type.auth')

@section('content')
    <div class="card shadow-lg mt-2">
        <div class="card-body">
    <x-prescription.show :prescription="$prescription"></x-prescription.show>
        </div>
    </div>
@endsection
