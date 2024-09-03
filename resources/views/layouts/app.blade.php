<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/assets/img/logos/logo-3.png')}}">
    <link rel="icon" type="image/png" href="{{asset('/assets/img/logos/logo-3.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!--     Fonts and icons     -->
    {{--    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />--}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&display=swap"
          rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous"/>--}}
    <!-- CSS Files -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet"/>
    <link id="pagestyle" href="{{asset('assets/css/soft-ui-dashboard.css?v=1.0.3')}}" rel="stylesheet"/>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet'/>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.11.3/main.css" rel="stylesheet"/>

    <!-- Scripts -->
    <script src="{{asset('assets/js/script.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/livekit-client/dist/livekit-client.umd.min.js"></script>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/3568f1c09c.js" crossorigin="anonymous"></script>
    <!--- JQuery JS Files --->
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        Pusher.logToConsole = true;

        var pusher = new Pusher('d2c1e4dc9f95bff44a13', {
            cluster: 'eu',
            authEndpoint: '/broadcasting/auth',
        });
        var userId = "{{ Auth::id() }}"; // Assume you have access to the authenticated user's ID
        var channel = pusher.subscribe('private-patient.' + userId);
        // var channel = pusher.subscribe('medflow-channel');
        channel.bind('consultation-started', function(data) {
            // Create the notification element
            var notification = document.createElement('div');
            notification.classList.add('consultation-notification');

            // Create the message text
            var message = document.createElement('p');
            message.textContent = 'Votre médecin a commencé la consultation.';
            message.appendChild(document.createElement('br'));
            message.append('Cliquez sur le bouton ci-dessous pour rejoindre la salle de consultation:');
            notification.appendChild(message);

            // Create the button
            var button = document.createElement('button');
            button.classList.add('consultation-button');
            button.textContent = 'Joindre';

            // Attach click event to the button
            button.addEventListener('click', function() {
                window.location.href = data.joinUrl;
            });

            notification.appendChild(button);

            // Append the notification to the body
            document.body.appendChild(notification);

            // Automatically remove the notification after 10 seconds
            setTimeout(function() {
                document.body.removeChild(notification);
            }, 30000);
        });
    </script>
</head>
{{--@stack('scripts')--}}
    <body class="g-sidenav-show bg-white">
        @auth
            @yield('auth')
            <!-- Notification container -->
            <div id="notification-container" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
        @endauth

        @guest
            @yield('guest')
        @endguest

        <!--- Choices.JS Files --->
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <!--- FullCalendar Files --->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/fr.js'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
        <!--   Core JS Files   -->
        <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
        <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3')}}"></script>
        {{--    @stack('dashboard')--}}

    </body>
</html>
