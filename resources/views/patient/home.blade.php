@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="text-center mt-5">
                    <a href="javascript:;">
                        <img class="avatar avatar-xl shadow" src="./assets/img/kit/pro/team-1.jpg">
                    </a>
                    <h6 class="card-title">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</h6>
                    <p class=" mb-0 font-weight-bold text-sm">{{ \Carbon\Carbon::parse(auth()->user()->dob)->age }}
                        {{ __('ans') }},
                        @if(auth()->user()->gender === 0)
                            {{ __('Homme') }}
                        @else
                            {{ __('Femme') }}
                        @endif
                    </p>
                </div>

                <hr class="horizontal dark mt-2">
                <div class="card-body">
                    <label>{{ __('Informations Générale') }}</label>
                    <div class="row">
                        <div class="col-6 left-0">
                            <p>{{ __('Date de naissance') }}</p>
                        </div>
                        <div class="col-6 right-0">
                            {{ auth()->user()->dob }}
                        </div>
                    </div>
                    <p class="card-description"></p>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Calendar</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="align-self-center w-100">
                            <div class="chart">
                                <div id="datetimepicker-dashboard"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
            var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
            document.getElementById("datetimepicker-dashboard").flatpickr({
                inline: true,
                prevArrow: "<span title=\"Previous month\">&laquo;</span>",
                nextArrow: "<span title=\"Next month\">&raquo;</span>",
                defaultDate: defaultDate
            });
        });
    </script>
@endsection


