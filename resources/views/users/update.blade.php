@extends('layouts.app')

@section('content')
<style>
*{
     
}
td,th{
    padding: 10px;
    color:white;
}
</style>
    <div class="row justify-content-center">
        <div class="col-md-6">

        </div>
    </div>
    
    <div class="row justify-content-center" id="app">
        <div class="card col-md-5 pt-2">
            <div class="card-head">
                Información personal
            </div>
            <img class="card-img-top m-auto mt-2" src="{{ asset('images/user.png') }}" style="width:100px;height:100px;" alt="">
            <div class="card-body row justify-content-center">
                <form action="{{ url('UpdateProfile') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label for="CodigoArbitro" class="col-md-4 col-form-label">Codigo del árbitro</label>
                        <div class="col-md-8">
                            <input type="number" name="cod_arb" v-model="user.arb_cod" class="form-control-plaintext" :disabled="disabled == 1 ? true : false"id="staticEmail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Nombre" class="col-md-4 col-form-label">Nombre</label>
                        <div class="col-md-8">
                            <input type="text" name="name" v-model="user.name" class="form-control-plaintext" :disabled="disabled == 1 ? true : false"id="staticEmail" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="apellido" class="col-md-4 col-form-label">Apellidos</label>
                        <div class="col-md-8">
                            <input type="text" name="surname" v-model="user.surname" class="form-control-plaintext" :disabled="disabled == 1 ? true : false"id="staticEmail">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label">Email</label>
                        <div class="col-md-8">
                            <input type="email"  name="email" v-model="user.email" class="form-control-plaintext" :disabled="disabled == 1 ? true : false"id="staticEmail">
                        </div>
                    </div>
    
                    <input class="btn btn-warning m-auto col-md-12" type="submit" value="Modificar" v-if="disabled == 0 ? true : false">
                </form>
                    <button class="col-md-9 btn mt-4 btn-dark" @click="disabled = (disabled + 1) % 2" v-if="disabled == 0 ? true : false">Terminar</button>
                    <button class="col-md-8 btn btn-dark" @click="disabled = (disabled + 1) % 2" v-if="disabled == 0 ? false : true">Editar</button>
            </div>
        </div>
    </div>


    
    <script>

    var users_vue = new Vue({
        el: '#app',
        data: {
            user: {!! $users !!},
            disabled: 1,
        }, 
        methods: {
            
        },
        mounted: function(){
            console.log(this.users)
        },
    });
    </script> 

@endsection