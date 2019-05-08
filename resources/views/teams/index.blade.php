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
    
    <div class="row justify-content-start">
        <div class="col-md-7 my-auto">  
            <label for="" class="col-md-3 text-light">Buscar Equipo</label>
            <input type="text" class="col-md-4" name="busqueda" v-model="teamSearch" id="" @blur="searchTeam(teamSearch)"><br>
            <label for="" class="col-md-3 text-light">Buscar Categoría</label>
            <input type="text" class="col-md-4" name="busqueda" v-model="categorySearch" id="" @blur="searchCategory(categorySearch)">
        </div>
        @role('admin')
        <div class="col-md-1 my-auto">
            
        </div>
        <div class="col-md-4">
            <form action="{{ url('createTeams') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" class="text-light m-auto btn-block" name="excel" id="excel" class="form-control-plaintext">
                <input type="submit" class="mt-2 btn-block" value="Enviar">
            </form>
        </div>
        @endrole
    
    </div>
    <div class="row mt-2 justify-content-center" >
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>Equipo</th>
                    <th>Categorías</th>
                    @role('admin')
                    <th>Modificar</th>
                    @endrole
                </tr>
            </thead>
            <tbody v-for="team in teams"> 
                <tr>
                    <td>@{{team.name}}</td>
                    <td>
                        <button class="btn btn-primary ml-5" @click="gosh(team.name)">Mostrar</button>
                    </td>
                    @role('admin')
                    <td><a :href="'/teamInfo/' + team.id">Modificar</a></td>
                    @endrole
                    
                </tr>
                <tr v-if="team.name == disabledTeam ? true : false" v-for="category in team.categories">
                    <td></td>
                    <td>@{{category.category}}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <span v-if="message">@{{message}}</span>
    </div>
</div>
    
    <script>
    
    var teams_vue = new Vue({
        el: '#app',
        data: {
            teams: {!! $teams !!},
            message: "",
            disabledTeam: "",
            teamSearch: "",
            categorySearch: ""

        }, 
        methods: { 
            searchTeam: function(teamSearch){
                console.log(teamSearch)
                if (teamSearch != "") {
                    axios
                    .get('searchTeam/'+ teamSearch )
                    .then(response => (
                        this.teams = response.data.teams,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }else{
                    axios
                    .get('getTeams')
                    .then(response => (
                        this.teams = response.data.teams,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }
            },
            searchCategory: function(categorySearch){
                console.log(categorySearch)
                if (categorySearch != "") {
                    axios
                    .get('searchCategory/'+ categorySearch )
                    .then(response => (
                        this.teams = response.data.teams,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }else{
                    axios
                    .get('getTeams')
                    .then(response => (
                        this.teams = response.data.teams,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }
            },
            gosh: function(team){
                if (this.disabledTeam != team) {
                    this.disabledTeam = team;

                }else{
                    this.disabledTeam = 0;
                }
                console.log(this.disabledTeam);
            },
            
        },
        mounted: function(){
            console.log(this.teams)
        },
    });
    </script> 

@endsection