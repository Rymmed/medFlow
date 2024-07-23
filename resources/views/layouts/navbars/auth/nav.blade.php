<!-- Navbar -->
<nav
    class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none"
    id="navbarBlur" navbar-scroll="false">
    <div class="container-fluid py-1 px-3 ">
        {{--        <nav aria-label="breadcrumb">--}}
        {{--            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">--}}
        {{--            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>--}}
        {{--            <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">{{ str_replace('-', ' ', Request::path()) }}</li>--}}
        {{--            </ol>--}}
        {{--            <h6 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h6>--}}
        {{--        </nav>--}}


        <div class="d-flex justify-content-between align-items-center" id="navbar">
            <div class="pe-md-3 d-flex align-items-center ">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" placeholder="Type here...">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end">
                <div class="navbar-nav">
                    <div class="col-auto nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-auto nav-item px-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0">
                            <i class="fa fa-envelope fixed-plugin-button-nav cursor-pointer"></i>
                        </a>
                    </div>
                    <div class="col-auto nav-item dropdown pe-2 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell cursor-pointer"></i>
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">New message</span> from Laur
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                13 minutes ago
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <img src="../assets/img/small-logos/logo-spotify.svg"
                                                 class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold">New album</span> by Travis Scott
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                1 day
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                            <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>credit-card</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                       fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(453.000000, 454.000000)">
                                                                <path class="color-background"
                                                                      d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                      opacity="0.593633743"></path>
                                                                <path class="color-background"
                                                                      d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                Payment successfully completed
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                2 days
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>


                    </div>
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <div class="border-start h-100"></div>
                    </div>
                    <div class="col-auto nav-item dropdown d-flex align-items-center">

                        <a href="javascript:;" class="nav-link d-flex align-items-center mb-0 p-0 ms-2 text-sm"
                           id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <x-profile-image :class="'avatar avatar-sm border-opacity-100 border-radius-section shadow-card me-2'" :image="auth()->user()->profile_image"></x-profile-image>
                            <div class="d-flex flex-column align-items-start flex-grow-1">
                                <span class="text-dark text-bold text-md">
                                    @if(auth()->user()->role === 'doctor')
                                        Dr. {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</span>
                                    <small class="user-speciality text-black-50">
                                        {{ auth()->user()->doctor_info->speciality }}
                                    </small>
                                @else
                                <span class="text-dark text-bold text-md">
                                    {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                                </span>
                                @endif

                            </div>

                            <span class="ms-2"><i class="fas fa-solid fa-angle-down"></i></span>
                        </a>

                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item border-radius-md" href="{{ route('myProfile') }}">
                                    Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md" href="#">
                                    <i class="fas fa-message fa-sm"></i> Messages
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item border-radius-md" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm"></i> Se déconnecter
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

    </div>
</nav>
{{--<script>--}}
{{--    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))--}}
{{--    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {--}}
{{--        return new bootstrap.Dropdown(dropdownToggleEl)--}}
{{--    })--}}
{{--</script>--}}
