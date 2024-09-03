@extends('layouts.app')

@section('auth')

        @if (\Request::is('rtl'))
            @include('layouts.navbars.auth.sidebar-rtl')
            <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg overflow-hidden">
                @include('layouts.navbars.auth.nav-rtl')
                <div class="container-fluid py-4">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </div>
            </main>

        @elseif (\Request::is('profile'))
            @include('layouts.navbars.auth.sidebar')
            <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
                @include('layouts.navbars.auth.nav')
                @yield('content')
            </div>

        @elseif (\Request::is('virtual-reality'))
            @include('layouts.navbars.auth.nav')
            <div class="border-radius-xl mt-3 mx-3 position-relative" style="background-image: url('{{url('assets/img/vr-bg.jpg')}}') ; background-size: cover;">
                @include('layouts.navbars.auth.sidebar')
                <main class="main-content mt-1 border-radius-lg">
                    @yield('content')
                    @include('layouts.footers.auth.footer')
                </main>
            </div>

        @else
            @include('layouts.navbars.auth.sidebar')
            <main class="main-content border-radius-xl position-relative max-height-vh-100 h-100 bg-gray-100 me-4" id="main-content">
                @include('layouts.navbars.auth.nav')
                <div class="container-fluid py-4 mb-4">
                    @yield('content')
                </div>
            </main>
            @include('layouts.footers.auth.footer')
        @endif
{{--        @include('components.fixed-plugin')--}}

@endsection
