@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-8">
                <div class="card">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar')
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'fr',
                initialView: 'dayGridMonth',
                events: {
                    url: '{{ route('appointments.calendar', ['doctor_id' => auth()->user()->id]) }}',
                    method: 'GET'
                }
            });
            calendar.render();
        })

    </script>
@endsection


