@extends('errors::layout')

@section('message')
<style>
*{
    color: white;
}
.enlaceboton {    
   font-size: 18pt; 
   padding: 10px 20px; 
   
   border-radius: 25px;
   background-color: #8515a1; 
   color: white; 
   text-decoration: none; 
} 
.enlaceboton:hover { 
   background-color: white; 
   color: #8515a1;  
}
body{
    background: rgba(133,21,161,0.9);
    background: -moz-linear-gradient(top, rgba(133,21,161,0.9) 0%, rgba(77,79,115,0.94) 39%, rgba(33,34,56,0.98) 75%, rgba(33,34,56,1) 100%);
    background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(133,21,161,0.9)), color-stop(39%, rgba(77,79,115,0.94)), color-stop(75%, rgba(33,34,56,0.98)), color-stop(100%, rgba(33,34,56,1)));
    background: -webkit-linear-gradient(top, rgba(133,21,161,0.9) 0%, rgba(77,79,115,0.94) 39%, rgba(33,34,56,0.98) 75%, rgba(33,34,56,1) 100%);
    background: -o-linear-gradient(top, rgba(133,21,161,0.9) 0%, rgba(77,79,115,0.94) 39%, rgba(33,34,56,0.98) 75%, rgba(33,34,56,1) 100%);
    background: -ms-linear-gradient(top, rgba(133,21,161,0.9) 0%, rgba(77,79,115,0.94) 39%, rgba(33,34,56,0.98) 75%, rgba(33,34,56,1) 100%);
    background: linear-gradient(to bottom, rgba(133,21,161,0.9) 0%, rgba(77,79,115,0.94) 39%, rgba(33,34,56,0.98) 75%, rgba(33,34,56,1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8515a1', endColorstr='#212238', GradientType=0 );
}
</style>
    <h1>Uups...</h1>
    <h3>No hemos encontrado la página Web</h3>
    <a href="{{ app('router')->has('home') ? route('home') : url('/') }}" class="enlaceboton">
        Volver
    </a>
@endsection