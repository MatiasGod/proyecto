@extends('layouts.app')

@section('content')
<div id="login">
    <div class="row justify-content-around">
        <div class="col-md-6">
            <img class="mx-auto" style="height:60%;width:60%;" src="{{ asset('images/logo2.svg') }}" alt="" srcset="" >
        </div>
        <div class="col-md-6 align-items-center">
            <div id="body-login">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Guacamole!</strong>  {{ implode('', $errors->all(':message')) }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group row justify-content-md-center">
                        <div class="col-md-6 ">
                            <input id="email" type="email" class="form-control @if($errors->any()) is-invalid @endif" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row justify-content-md-center">
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @if($errors->any()) is-invalid @endif" name="password" placeholder="Password" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-group row  justify-content-md-center">
                        <div class="col-md-6 ">
                            <button type="submit" class="btn btn-primary btn-block" id="log-btn">
                                {{ __('Login') }}
                            </button>
                        </div>    
                    </div>

                    <div class="row justify-content-md-center">
                        <div class="col-md-8">
                            <hr class="my-4 bg-white">
                        </div>
                    </div>

                    <div class="row justify-content-md-center">
                        <div class="col-md-4">
                            @if (Route::has('password.request'))
                                <a class="btn btn-primary btn-block" href="{{ route('password.request') }}" id="log-btn">
                                    {{ __('Recuperar Contraseña') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection
