@extends('layouts.user_type.auth')

@section('content')
    <x-prescription.all-prescriptions :prescriptions="$prescriptions"></x-prescription.all-prescriptions>
@endsection
