<aside
    class="sidenav navbar navbar-vertical bg-gray-100 navbar-expand-xs border-0 border-radius-xl my-4 fixed-start ms-3"
    id="sidenav-main">
    <div class="sidenav-header py-2">
        <i class="fas fa-times p-2 cursor-pointer text-secondary position-absolute end-2 top-0 d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <i class="fas fa-angle-double-left p-2 cursor-pointer text-secondary position-absolute end-2 top-4 ms-2"
           id="toggleLeftButton"></i>
        <i class="fas fa-angle-double-right p-2 cursor-pointer text-secondary position-absolute end-2 top-4 ms-2"
           id="toggleRightButton" style="display: none;"></i>
        <img src="{{asset('assets/img/logos/medflow-trans.png')}}" class="navbar-logo-img mx-2 my-2" id="logo-img"
             alt="...">
        <img src="{{asset('assets/img/logos/logo-1.png')}}" class="navbar-logo-img mx-2 my-2"
             id="minimized-img"
             alt="..." style="display: none">
    </div>
    <hr class="horizontal dark mt-0">
    <div class="sidenav-body w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ (Request::is('dashboard') ? 'active' : '') }}" href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop </title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1716.000000, -439.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(0.000000, 148.000000)">
                                            <path class="color-background opacity-6"
                                                  d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                            <path class="color-background"
                                                  d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L19.5833333,46.9451667 L19.5833333,33.6066734 L27.4166667,33.6066734 L27.4166667,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Tableau de bord</span>
                </a>
            </li>
            {{--            <li class="nav-item mt-2">--}}
            {{--                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laravel Examples</h6>--}}
            {{--            </li>--}}
            <li class="nav-item">
                <a class="nav-link {{ (Request::is('myProfile') ? 'active' : '') }} "
                   href="{{ route('myProfile') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Rounded-Icons" transform="translate(-1717.000000, -291.000000)" fill="#FFFFFF"
                                   fill-rule="nonzero">
                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                                        <g id="customer-support" transform="translate(1.000000, 0.000000)">
                                            <path class="color-background"
                                                  d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"
                                                  id="Path" opacity="0.59858631"></path>
                                            <path class="color-foreground"
                                                  d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.116,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"
                                                  id="Path"></path>
                                            <path class="color-foreground"
                                                  d="M13,28 C17.432,28 21,22.529 21,18 C21,13.589 17.411,10 13,10 C8.589,10 5,13.589 5,18 C5,22.529 8.568,28 13,28 Z"
                                                  id="Path"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Mon Profil</span>
                </a>
            </li>
            <!-- Depending on the user's role, show specific items -->
            @if(auth()->user()->role === 'super-admin')
                <!-- Items for super-admin -->
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('admins') ? 'active' : '') }}"
                       href="{{ route('admins.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fa fa-solid fa-user-shield ps-2 pe-2 text-center text-dark {{ (Request::is('admins') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Administrateurs</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('patients') ? 'active' : '') }}"
                       href="{{ route('patients.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fa fa-solid fa-bed ps-2 pe-2 text-center text-dark {{ (Request::is('patients') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Patients</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('doctors') ? 'active' : '') }}"
                       href="{{ route('doctors.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fa fa-solid fa-stethoscope ps-2 pe-2 text-center text-dark {{ (Request::is('doctors') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Médecins</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('assistants') ? 'active' : '') }}"
                       href="{{ route('assistants.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fa fa-solid fa-user-nurse ps-2 pe-2 text-center text-dark {{ (Request::is('assistants') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Assistants</span>
                    </a>
                </li>
            @elseif((auth()->user()->role === 'admin'))
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('patients') ? 'active' : '') }}"
                       href="{{ route('patients.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fa fa-lg fa-bed ps-2 pe-2 text-center text-dark {{ (Request::is('patients') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Patients</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('doctors') ? 'active' : '') }}"
                       href="{{ route('doctors.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fa fa-lg fa-stethoscope ps-2 pe-2 text-center text-dark {{ (Request::is('doctors') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Médecins</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('assistants') ? 'active' : '') }}"
                       href="{{ route('assistants.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fas fa-lg fa-user-nurse ps-2 pe-2 text-center text-dark {{ (Request::is('assistants') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Assistants</span>
                    </a>
                </li>
            @elseif(auth()->user()->role === 'doctor')
                <!-- Items for doctor -->
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('myAppointments') ? 'active' : '') }}"
                       href="{{ route('appointments.myAppointments') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fas fa-business-time ps-2 pe-2 text-center text-dark {{ (Request::is('myAppointments') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Rendez-Vous</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('doctor-assistants') ? 'active' : '') }}"
                       href="{{ route('doctor-assistants.index') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fas fa-lg fa-user-nurse ps-2 pe-2 text-center text-dark {{ (Request::is('doctor-assistants') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Assistants</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('patients') ? 'active' : '') }}"
                       href="{{ route('myPatients') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fas fa-calendar-alt ps-2 pe-2 text-center text-dark {{ (Request::is('patients') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Patients</span>
                    </a>
                </li>
                <li class="nav-item pb-2">
                    <a class="nav-link {{ (Request::is('myCalendar') ? 'active' : '') }}"
                       href="{{ route('myCalendar') }}">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i style="font-size: 1rem;"
                               class="fas fa-calendar-alt ps-2 pe-2 text-center text-dark {{ (Request::is('myCalendar') ? 'text-white' : 'text-dark') }} "
                               aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Mon Calendrier</span>
                    </a>
                </li>
            @elseif(auth()->user()->role === 'patient')
                <!-- Items for patient -->
                <li class="nav-item pb-2">

                </li>
            @elseif(auth()->user()->role === 'assistant')
                <!-- Items for assistant -->
                <li class="nav-item">

                </li>
            @endif
{{--            <li class="nav-item pb-2">--}}
{{--                <a class="nav-link {{ (Request::is('myMessages') ? 'active' : '') }}"--}}
{{--                   href="javascript:;">--}}
{{--                    <div--}}
{{--                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">--}}
{{--                        <i style="font-size: 1rem;"--}}
{{--                           class="fa fa-envelope ps-2 pe-2 text-center text-dark {{ (Request::is('myMessages') ? 'text-white' : 'text-dark') }}"></i>--}}
{{--                    </div>--}}
{{--                    <span class="nav-link-text ms-1">Messages</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="nav-item pb-2">--}}
{{--                <a class="nav-link {{ (Request::is('settings') ? 'active' : '') }}"--}}
{{--                   href="javascript:;">--}}
{{--                    <div--}}
{{--                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">--}}
{{--                        <i style="font-size: 1rem;"--}}
{{--                           class="fa fa-bell ps-2 pe-2 text-center text-dark {{ (Request::is('settings') ? 'text-white' : 'text-dark') }}"></i>--}}
{{--                    </div>--}}
{{--                    <span class="nav-link-text ms-1">Notifications</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item pb-2">--}}
{{--                <a class="nav-link {{ (Request::is('settings') ? 'active' : '') }}"--}}
{{--                   href="javascript:;">--}}
{{--                    <div--}}
{{--                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">--}}
{{--                        <i style="font-size: 1rem;"--}}
{{--                           class="fas fa-cog fixed-plugin-button-nav ps-2 pe-2 text-center text-dark {{ (Request::is('settings') ? 'text-white' : 'text-dark') }}"></i>--}}
{{--                    </div>--}}
{{--                    <span class="nav-link-text ms-1">Paramètres</span>--}}
{{--                </a>--}}
{{--            </li>--}}

        </ul>

        {{--        </div>--}}
    </div>
    <!-- Profile section at the bottom -->
    <div class="sidenav-footer w-auto">
        <hr class="horizontal dark">
        <ul class="navbar-nav">
            <li class="nav-item pb-2">
                <a class="nav-link"
                   href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                           class="fas fa-sign-out-alt fixed-plugin-button-nav ps-2 pe-2 text-center text-dark "></i>
                    </div>
                    <span class="nav-link-text ms-1">Se déconnecter</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    @push('scripts')
        <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            var logoImg = document.getElementById("logo-img");
            var minimizedLogoImg = document.getElementById("minimized-img");
            var toggleLeftButton = document.getElementById("toggleLeftButton");
            var toggleRightButton = document.getElementById("toggleRightButton");
            var sidenav = document.getElementById("sidenav-main");
            var mainContent = document.getElementById("main-content");

            toggleLeftButton.addEventListener("click", function () {
                sidenav.classList.toggle("collapsed");
                mainContent.classList.add("expanded");
                logoImg.style.display = "none";
                minimizedLogoImg.style.display = "block";
                toggleRightButton.style.display = "block";
                toggleLeftButton.style.display = "none";
            });
            toggleRightButton.addEventListener("click", function () {
                sidenav.classList.remove("collapsed");
                mainContent.classList.remove("expanded");
                logoImg.style.display = "block";
                minimizedLogoImg.style.display = "none";
                toggleLeftButton.style.display = "block";
                toggleRightButton.style.display = "none";
            });
        });
    </script>
    @endpush
</aside>
