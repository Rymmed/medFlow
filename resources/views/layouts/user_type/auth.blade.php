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

{{--        @elseif (auth()->user()->role === 'patient')--}}
{{--            <main class="main-content position-relative max-height-vh-100 h-100 mt-0 border-radius-sm {{ (Request::is('rtl') ? 'overflow-hidden' : '') }}">--}}
{{--                @include('layouts.navbars.auth.nav-patient')--}}
{{--                <div class="container-fluid py-4">--}}
{{--                    @yield('content')--}}
{{--                </div>--}}
{{--                <div class="container-fluid py-4">--}}
{{--                    @include('layouts.footers.auth.footer')--}}
{{--                </div>--}}
{{--            </main>--}}

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
            <div class="main-content border-radius-xl bg-gray-100 position-relative h-100 my-4 me-4">
                @include('layouts.navbars.auth.nav')
                <main class="container-fluid py-4">
                    @yield('content')
                </main>
            </div>
            @include('layouts.footers.auth.footer')
        @endif
        @include('components.fixed-plugin')

@endsection
