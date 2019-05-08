@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            
                            
                        </div>
                    @endif
                        {{ Auth::user()->name }}  
                        [
                            @if(Auth::user()->hasRole('admin'))
                                admin
                            @elseif(Auth::user()->hasRole('arbitro'))
                                arbitro
                            @elseif(Auth::user()->hasRole('informador'))
                                informador
                            @endif
                        ]
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
