@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    --}}{{--                    <div class="card-header">Dashboard</div>--}}

{{--                    <div class="card-body">--}}
{{--                        @if (session('status'))--}}
{{--                            <div class="alert alert-success" role="alert">--}}
{{--                                {{ session('status') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div id='calendar'></div>
        </div>

    </div>
    <script src="{{ asset('assets/fullcalendar/dist/index.global.js')}} "></script>
    <script type="text/javascript">
        var calendarID = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarID, {
            headerToolbar: {
                left: 'prev next today',
                center: 'title',
                right: 'dayGridMonth timeGridWeek timeGridDay listMonth'
            },
            initialDate: '<?=date('Y-m-d') ?>',
            navLinks: true,
            editable: true,
        });

        calendar.render();
    </script>
@endsection
@section('script')

@endsection

