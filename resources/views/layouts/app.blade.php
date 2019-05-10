<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('include.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head >
    <body id="principal">
    @if($view_name=='auth.login' || $view_name=='auth.register' || $view_name=='auth.passwords.email' )
        
        <div class="container-fluid mt-5" id="cuerpo">
            @yield('content')
        </div>

    @else
    <!-- <body id="secondary"> -->
        @include('include.header')
        
        <div class="container mt-5 mb-5" id="cuerpo" id="app">
            @yield('content')
        </div>
        
        @include('include.footer')
    @endif
</body>
</html>
