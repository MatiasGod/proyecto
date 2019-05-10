@extends('layouts.app')
@section('content')
<style>
td,th{
    padding: 10px;
    color:white;
}
</style>
@include('show_messages')
<div class="" id="app">
    
    <div class="row justify-content-start">
        <div class="col-md-6 my-auto">
            <label for="" class="col-md-2 text-light">Buscar</label>
            <input type="text" name="busqueda" class="col-md-4" v-model="busqueda" @keyup.enter="search(busqueda)" @blur="search(busqueda)">

        </div>
        @role('admin')
        <div class="col-md-2 my-auto">
            <button class="btn m-auto ml-5 border border-light text-light" @click="gosh">Mostrar Eliminados</button>
        </div>
        <div class="col-md-4">
            <form action="{{ url('createUserFile') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="excel" class="text-light m-auto btn-block" id="excel" class="form-control-plaintext">
                <input type="submit" class="mt-2 btn-block" value="Enviar">
            </form>
        </div>
        @endrole
    
    </div>
    <div class="row mt-2 justify-content-center" >
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    @role('admin')
                    <th>Rol</th>
                    <th>Modificaciones</th>
                    @endrole
                </tr>
            </thead>
            <tbody> 

                <tr v-for="user in users">
                    <td>@{{user.arb_cod}}</td>
                    <td>@{{user.name}}</td>
                    <td>@{{user.surname}}</td>
                    <td>@{{user.email}}</td>

                    @role('admin')
                    <td>@{{user.roles[0].name}}</td>
                    <td><button @click="deleteUser(user.id)">Eliminar</button></td>
                    <td><a :href="'/updateInfo/' + user.id">Modificar</a></td>
                    @endrole
                    
                </tr>
            </tbody>
        </table>
        <table class="table table-dark" v-if="disabled == 1 ? true : false">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Recuperar</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="user in usersTrash">
                    <td>@{{user.arb_cod}}</td>
                    <td>@{{user.name}}</td>
                    <td>@{{user.surname}}</td>
                    <td>@{{user.email}}</td>

                    @role('admin')
                    <td>@{{user.roles[0].name}}</td>
                    <td><button @click="recovery(user.id)">Recuperar</button></td>
                    <td><a :href="'/updateInfo/' + user.id">Modificar</a></td>
                    @endrole
                    
                </tr>
            </tbody>
        </table>

        <!-- <span v-if="message">@{{message}}</span> -->
        <div v-if="message" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>@{{message}}</strong> .
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        
    </div>
</div>
    
    <script>
    
    var users_vue = new Vue({
        el: '#app',
        data: {
            users: {!! $users !!},
            usersTrash: [],
            disabled: 0,
            message: "",
            busqueda:""

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
            search: function(busqueda){
                console.log(busqueda)
                if (busqueda != "") {
                    axios
                    .get('buscar/'+ busqueda )
                    .then(response => (
                        this.users = response.data.users,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }else{
                    axios
                    .get('getAllUsers')
                    .then(response => (
                        this.users = response.data.users,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }
            },
            
        },
        mounted: function(){
            console.log(this.user)
        },
    });
    </script> 

@endsection