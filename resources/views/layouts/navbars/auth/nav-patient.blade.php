<!-- Navbar Dark -->
<nav class="navbar navbar-main navbar-expand-lg navbar-dark  bg-gradient-blue px-0  shadow-none border-radius-sm" id="navbarBlur" navbar-scroll="false">
    <div class="container-fluid py-1 px-3">
        <a class="navbar-brand text-white" href="" rel="tooltip" title="Designed and Coded by Envast" data-placement="bottom" target="_blank">
            {{ config('app.name', 'Laravel') }}
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link  {{ (Request::is('home') ? 'active' : '') }}" href="{{ route('home') }}">
{{--                    <i style="font-size: 1rem;" class="fas fa-solid fa-house-user ps-1 pe-1 text-center " aria-hidden="true"></i>--}}
                    <span class="nav-link-text ms-1 d-sm-inline d-none text-white font-weight-normal {{ (Request::is('home') ? 'font-weight-bolder' : 'font-weight-normal') }}">Tableau de bord</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ (Request::is('user/profile') ? 'active' : '') }} " href="{{ route('user.profile') }}">
{{--                    <i style="font-size: 1rem;" class="fa fa-solid fa-id-card"></i>--}}
                    <span class="nav-link-text ms-1 d-sm-inline d-none text-white font-weight-normal {{ (Request::is('user/profile') ? 'font-weight-bolder' : 'font-weight-normal') }}">Mon Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ (Request::is('user/profile') ? 'active' : '') }} " href="{{ route('user.profile') }}">
{{--                    <i class="fas fa-search" aria-hidden="true"></i></span>--}}
                    <span class="nav-link-text ms-1 d-sm-inline d-none text-white font-weight-normal {{ (Request::is('user/profile') ? 'font-weight-bolder' : 'font-weight-normal') }}">Trouver un médecin</span>
                </a>
            </li>
        </ul>
{{--        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}
        <div class="mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navigation">

{{--            <div class="nav-item px-3 d-flex align-items-center">--}}
{{--                <div class="input-group">--}}
{{--                    <input type="text" class="form-control" placeholder="Type here...">--}}
{{--                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>--}}
{{--                </div>--}}
{{--            </div>--}}

            <ul class="navbar-nav justify-content-end">
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0">
                        <i class="fa fa-cog text-white fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:" class="nav-link  p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell text-white cursor-pointer"></i>
                    </a>
{{--                    <ul class="dropdown-menu dropdown-menu-right px-2 py-3 ms-n4" aria-labelledby="dropdownMenuButton">--}}
{{--                        <li class="mb-2">--}}
{{--                            <a class="dropdown-item border-radius-md" href="javascript:;">--}}
{{--                                <div class="d-flex py-1">--}}
{{--                                    <div class="my-auto">--}}
{{--                                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex flex-column justify-content-center">--}}
{{--                                        <h6 class="text-sm font-weight-normal mb-1">--}}
{{--                                            <span class="font-weight-bold">New message</span> from Laur--}}
{{--                                        </h6>--}}
{{--                                        <p class="text-xs text-secondary mb-0">--}}
{{--                                            <i class="fa fa-clock me-1"></i>--}}
{{--                                            13 minutes ago--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="mb-2">--}}
{{--                            <a class="dropdown-item border-radius-md" href="javascript:;">--}}
{{--                                <div class="d-flex py-1">--}}
{{--                                    <div class="my-auto">--}}
{{--                                        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex flex-column justify-content-center">--}}
{{--                                        <h6 class="text-sm font-weight-normal mb-1">--}}
{{--                                            <span class="font-weight-bold">New album</span> by Travis Scott--}}
{{--                                        </h6>--}}
{{--                                        <p class="text-xs text-secondary mb-0">--}}
{{--                                            <i class="fa fa-clock me-1"></i>--}}
{{--                                            1 day--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a class="dropdown-item border-radius-md" href="javascript:;">--}}
{{--                                <div class="d-flex py-1">--}}
{{--                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">--}}
{{--                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">--}}
{{--                                            <title>credit-card</title>--}}
{{--                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">--}}
{{--                                                    <g transform="translate(1716.000000, 291.000000)">--}}
{{--                                                        <g transform="translate(453.000000, 454.000000)">--}}
{{--                                                            <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>--}}
{{--                                                            <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>--}}
{{--                                                        </g>--}}
{{--                                                    </g>--}}
{{--                                                </g>--}}
{{--                                            </g>--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                    <div class="d-flex flex-column justify-content-center">--}}
{{--                                        <h6 class="text-sm font-weight-normal mb-1">--}}
{{--                                            Payment successfully completed--}}
{{--                                        </h6>--}}
{{--                                        <p class="text-xs text-secondary mb-0">--}}
{{--                                            <i class="fa fa-clock me-1"></i>--}}
{{--                                            2 days--}}
{{--                                        </p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
                </li>
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ route('logout') }}" class="nav-link font-weight-bold px-0" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt text-white me-sm-1"></i>
                        <span class="d-sm-inline d-none text-white">Sign Out</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
