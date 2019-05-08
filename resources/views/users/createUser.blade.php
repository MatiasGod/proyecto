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
<div class="" id="app">
    <div class="row mt-5 justify-content-center">
        <div class="card col-md-5 pt-2">
            <div class="card-head">
                Información personal
            </div>
            <img class="card-img-top m-auto mt-2" src="{{ asset('images/user.png') }}" style="width:100px;height:100px;" alt="">
            <div class="card-body row justify-content-center">

                <form action="{{ url('createUserFile') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="ArchivoExcel" class="col-md-4 col-form-label">Cargar Archivo</label>
                        <div class="col-md-8">
                            <input type="file" name="excel" id="excel" class="form-control-plaintext">
                        </div>
                    </div>
                    <input type="submit" value="Enviar">
                </form>

                <!-- <form action="{{ url('createUser') }}" method="post">
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

                    <input class="btn btn-primary btn-block" type="submit" value="Modificar" v-if="disabled == 0 ? true : false">
                </form> -->
                    <button class="col-md-8 btn btn-block" @click="disabled = (disabled + 1) % 2" v-if="disabled == 0 ? true : false">Terminar</button>
                    <button class="col-md-8 btn btn-block" @click="disabled = (disabled + 1) % 2" v-if="disabled == 0 ? false : true">Editar</button>
            </div>
        </div>
    </div>
</div>
    
    <script>
    
    var users_vue = new Vue({
        el: '#app',
        data: {
            
            usersTrash: [],
            disabled: 0,
            message: ""

        }, 
        methods: { 
            deleteUser: function(user_id){
                console.log(user_id)
                axios
                    .get('deleteUser/'+ user_id )
                    .then(response => (
                        this.message = response.data.message,
                        this.users = response.data.users,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
            },
            gosh: function(){
                if (this.disabled == 0) {
                    this.disabled = 1;
                    axios.get('userTrash')
                    .then(response => (
                        this.usersTrash = response.data.userTrash,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))

                }else{
                    this.disabled = 0;
                }
                console.log(this.disabled);
            },
            recovery: function(user_id){
                console.log(user_id)
                axios
                    .get('restore/'+ user_id )
                    .then(response => (
                        this.message = response.data.message,
                        this.users = response.data.users,
                        console.log(response.data),
                        this.disabled = 0
                        ))
                    .catch(error => console.log(error))

            },
            
        },
        mounted: function(){
            console.log(this.user)
        },
    });
    </script> 

@endsection