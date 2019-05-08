@extends('layouts.app')

@section('content')
<div class="row">

    <a href="{{ url('matchs') }}"class="col-md-4" id="cards">
        <div class="card bg-dark text-white" id="card">
            <img class="card-img" id="card-img" src="{{ asset('images/match.jpg') }}" alt="Card image">
            <div class="card-img-overlay" id="card-text">
                <span class="card-title">Partidos</span>
            </div>
        </div>
    </a>

    <a href="{{ url('referees') }}"class="col-md-4" id="cards">
        <div class="card bg-dark text-white" id="card">
            <img class="card-img" id="card-img" src="{{ asset('images/arb1.jpg') }}" alt="Card image">
            <div class="card-img-overlay" id="card-text">
                <span class="card-title">Árbitros</span>
            </div>
        </div>
    </a>

    <a href=" {{ url('allTeams') }}" class="col-md-4" id="cards">
        <div class="card bg-dark text-white" id="card">
            <img class="card-img" id="card-img" src="{{ asset('images/biblio.jpg') }}" alt="Card image">
            <div class="card-img-overlay" id="card-text">
                <span class="card-title">Equipos</span>
            </div>
        </div>
    </a>

</div>
@endsection