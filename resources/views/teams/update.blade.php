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
        <div class="card col-md-7 pt-2">
            <div class="card-head">
                Información personal
            </div>
            <div class="card-body row justify-content-center">
                <form action="{{ url('updateTeam') }}" method="post">
                    {{ csrf_field() }}
                    
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="hidden" name="id" :value="team.id">
                            <label for="Nombre" class="col-md-5 d-inline col-form-label">Nombre Equipo</label>
                            <input type="text" name="name" v-model="team.name" class="col-md-6 d-inline form-control-plaintext" :disabled="disabled == 1 ? true : false"id="staticEmail" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6" v-for="(category, key) in categories">
                            <label for="Nombre" class="col-md-10 col-form-label">@{{category.category}}</label>
                            <input type="checkbox" :name="category.category" :value="category.id" v-model="arr[key]" class="col-md-1" :disabled="disabled == 1 ? true : false">
                        </div>
                    </div>
                    
                    <input class="btn btn-primary btn-block" type="submit" value="Modificar" v-if="disabled == 0 ? true : false">
                </form>
                <button class="col-md-8 btn btn-block" @click="disabled = (disabled + 1) % 2" v-if="disabled == 0 ? true : false">Terminar</button>
                <button class="col-md-8 btn btn-block" @click="disabled = (disabled + 1) % 2" v-if="disabled == 0 ? false : true">Editar</button>
            </div>
            
        </div>
    </div>


    
    <script>

    var teams_vue = new Vue({
        el: '#app',
        data: {
            arr: {!! $arr !!},
            team: {!! $teams !!},
            categories: {!! $categories !!},
            disabled: 1,
            iteration:0
        }, 
        methods: {
            
        },
        mounted: function(){
            
            console.log(this.team)
            console.log(this.checkeds)
            //console.log(this.categories)
        },
    });
    </script> 

@endsection