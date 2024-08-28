@extends('layouts.user_type.auth')

@section('content')
    <x-prescription.createOrUpdate :prescription="$prescription" :report="$report"></x-prescription.createOrUpdate>
@endsection
