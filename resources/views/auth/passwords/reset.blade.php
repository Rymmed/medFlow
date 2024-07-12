@extends('layouts.user_type.guest')

@section('content')
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-8">
                        <div class="card-header pb-0 text-left bg-transparent">
                            <h4 class="mb-0">{{ __('Changer le mot de passe') }}</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{ route('password.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div>
                                    <label for="email">Email</label>
                                    <div class="">
                                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" aria-label="Email" aria-describedby="email-addon">
                                        @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="password">{{ __('Nouveau mot de passe') }}</label>
                                    <div class="mb-3 position-relative">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('Entrez votre mot de passe') }}" aria-label="Password" aria-describedby="password-addon">
                                        <x-show-password></x-show-password>
                                        @error('password')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="password-confirm">{{ __('Confirmer le mot de passe') }}</label>
                                    <div class="mb-3 position-relative align-content-center">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirmez votre mot de passe') }}" required autocomplete="new-password">
                                        <x-show-password></x-show-password>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">{{ __('Récupérer votre
                                        mot de passe') }}</button>
                                </div>
                            </form>
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
