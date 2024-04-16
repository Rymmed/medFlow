@extends('layouts.user_type.auth')

@section('content')

    <div>
        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('{{url('../assets/img/bg/pngtree.jpg')}}'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{asset('assets/img/bruce-mars.jpg')}}" alt="..." class="w-100 border-radius-lg shadow-sm">
                            <a href="javascript:;" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-sm">
                                {{ auth()->user()->role }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab" href="javascript:;"--}}
{{--                                       role="tab" aria-controls="overview" aria-selected="true">--}}
{{--                                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 42 42" version="1.1"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">--}}
{{--                                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none"--}}
{{--                                               fill-rule="evenodd">--}}
{{--                                                <g id="Rounded-Icons" transform="translate(-2319.000000, -291.000000)"--}}
{{--                                                   fill="#FFFFFF" fill-rule="nonzero">--}}
{{--                                                    <g id="Icons-with-opacity"--}}
{{--                                                       transform="translate(1716.000000, 291.000000)">--}}
{{--                                                        <g id="box-3d-50" transform="translate(603.000000, 0.000000)">--}}
{{--                                                            <path class="color-background" d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474453 38.8987261,9.45068056 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z" id="Path"></path>--}}
{{--                                                            <path class="color-background" d="M23.625,22.429159 L23.625,39.8805372 C23.625,40.4328219 24.0727153,40.8805372 24.625,40.8805372 C24.7802551,40.8805372 24.9333778,40.8443874 25.0722402,40.7749511 L41.2741875,32.673375 L41.2741875,32.673375 C41.719125,32.4515625 42,31.9974375 42,31.5 L42,14.241659 C42,13.6893742 41.5522847,13.241659 41,13.241659 C40.8447549,13.241659 40.6916418,13.2778041 40.5527864,13.3472318 L24.1777864,21.5347318 C23.8390024,21.7041238 23.625,22.0503869 23.625,22.429159 Z" id="Path" opacity="0.7"></path>--}}
{{--                                                            <path class="color-background" d="M20.4472136,21.5347318 L1.4472136,12.0347318 C0.953235098,11.7877425 0.352562058,11.9879669 0.105572809,12.4819454 C0.0361450918,12.6208008 6.47121774e-16,12.7739139 0,12.929159 L0,30.1875 L0,30.1875 C0,30.6849375 0.280875,31.1390625 0.7258125,31.3621875 L19.5528096,40.7750766 C20.0467945,41.0220531 20.6474623,40.8218132 20.8944388,40.3278283 C20.963859,40.1889789 21,40.0358742 21,39.8806379 L21,22.429159 C21,22.0503869 20.7859976,21.7041238 20.4472136,21.5347318 Z" id="Path" opacity="0.7"></path>--}}
{{--                                                        </g>--}}
{{--                                                    </g>--}}
{{--                                                </g>--}}
{{--                                            </g>--}}
{{--                                        </svg>--}}
{{--                                        <span class="ms-1">{{ __('Informations personnelles') }}</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="javascript:;" role="tab" aria-controls="teams" aria-selected="false">--}}
{{--                                        <svg class="text-dark" width="16px" height="16px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">--}}
{{--                                            <title>document</title>--}}
{{--                                            <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                                <g id="Rounded-Icons" transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF" fill-rule="nonzero">--}}
{{--                                                    <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">--}}
{{--                                                        <g id="document" transform="translate(154.000000, 300.000000)">--}}
{{--                                                            <path class="color-background" d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z" id="Path" opacity="0.603585379"></path>--}}
{{--                                                            <path class="color-background" d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z" id="Shape"></path>--}}
{{--                                                        </g>--}}
{{--                                                    </g>--}}
{{--                                                </g>--}}
{{--                                            </g>--}}
{{--                                        </svg>--}}
{{--                                        <span class="ms-1">{{ __('Dossier Medical') }}</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Profile Information') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user.update-profile') }}" method="POST" role="form text-left">
                        @csrf
                        @method('PUT')
                        @if($errors->any())
                            <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="firstName" class="form-control-label">{{ __('Prénom') }}</label>
                                    <div class="@error('user.firstName')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->firstName}}" type="text" placeholder="Prénom" id="firstName" name="firstName">
                                        @error('firstName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lastName" class="form-control-label">{{ __('Nom') }}</label>
                                    <div class="@error('user.lastName')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->lastName}}" type="text" placeholder="Nom" id="lastName" name="lastName">
                                        @error('lastName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user.email" class="form-control-label">{{ __('Email') }}</label>
                                    <div class="@error('email')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->email }}" type="email" placeholder="@example.com" id="email" name="email">
                                        @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user.dob" class="form-control-label">{{ __('Date de naissance') }}</label>
                                    <div class="@error('dob')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->dob }}" type="date" placeholder="@example.com" id="dob" name="dob">
                                        @error('dob')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user.phone_number" class="form-control-label">{{ __('Numéro  de téléphone') }}</label>
                                    <div class="@error('user.phone_number')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="text" placeholder="" id="phone_number" name="phone_number" value="{{ auth()->user()->phone_number }}">
                                        @error('phone_number')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user.cin_number" class="form-control-label">{{ __('Numéro de CIN') }}</label>
                                    <div class="@error('user.cin_number')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="text" placeholder="" id="cin_number" name="cin_number" value="{{ auth()->user()->cin_number }}">
                                        @error('cin_number')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user.insurance_number" class="form-control-label">{{ __('Numéro dassurance') }}</label>
                                    <div class="@error('user.insurance_number')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="text" placeholder="" id="insurance_number" name="insurance_number" value="{{ auth()->user()->insurance_number }}">
                                        @error('insurance_number')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-md-4">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="user.location" class="form-control-label">{{ __('Adresse') }}</label>--}}
{{--                                    <div class="@error('user.location') border border-danger rounded-3 @enderror">--}}
{{--                                        <input class="form-control" type="text" placeholder="Location" id="name" name="location" value="{{ auth()->user()->location }}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Sauvegarder' }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
