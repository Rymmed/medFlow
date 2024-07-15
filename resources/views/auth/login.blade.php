@extends('layouts.user_type.guest')

@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-6">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">{{ __('Bienvenue dans MedFlow') }}</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <label>{{__('Email')}}</label>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('Entrez votre adresse email') }}" aria-label="Email" aria-describedby="email-addon">
                                        @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <label>{{__('Mot de passe')}}</label>
                                    <div class="mb-3 position-relative">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('Entrez votre mot de passe') }}" aria-label="Password" aria-describedby="password-addon">
                                        <x-show-password></x-show-password>
                                        @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                                        <label class="form-check-label" for="rememberMe">{{__('Se souvenir de moi')}}</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">{{__('Se connecter')}}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                @if (Route::has('password.request'))
                                    <small class="text-muted">{{__('Mot de passe oublié ?')}} {{__('Réinitialiser votre mot
                                        de passe ')}}
                                        <a href="{{ route('password.request') }}" class="text-info text-gradient font-weight-bold">{{__('ici')}}</a>
                                    </small>
                                @endif
                                <p class="mb-4 text-sm mx-auto">
                                    {{__('Vous n’avez pas de compte ?')}}
                                    <a href="{{ route('register')}}" class="text-info text-gradient font-weight-bold">{{__('S’inscrire')}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{url('assets/img/bg/pngtree.jpg')}}')"></div>
                        </div>
                    </div>
                </div>
            </div>

@endsection
