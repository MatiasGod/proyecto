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
            <input type="text" class="col-md-4" name="busqueda" v-model="matchSearch" id="" @blur="searchmatch(matchSearch)"><br>
        </div>
        @role('admin')
        <div class="col-md-1 my-auto">
            
        </div>
        <div class="col-md-4">
            <form action="{{ url('creatematchs') }}" method="post" enctype="multipart/form-data">
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
                    <th>Número de Partido</th>
                    <th>Fecha</th>
                    <th>Localidad</th>
                    <th>Categoría</th>
                    <th>Equipo A</th>
                    <th>Equipo B</th>

                    @role('admin')
                        <th>Principal</th>
                        <th>Auxiliar</th>
                        <th>Anotador</th>
                        <th>Crono</th>
                    @endrole
                </tr>
                
            </thead>
            <tbody v-for="match in matchs"> 
                <tr>
                    <td>@{{match.matchNumber}}</td>
                    <td>@{{match.date}}</td>
                    <td>@{{match.location}}</td>
                    <td>@{{match.category}}</td>
                    <td v-for="teams in match.teams">@{{teams.name}}</td>
                </tr>
            </tbody>
        </table>
        <span v-if="message">@{{message}}</span>
    </div>
</div>

    
    <script>
    
    var matchs_vue = new Vue({
        el: '#app',
        data: {
            matchs: {!! $matchs !!},
            referees: "",
            message: "",
            disabledmatch: "",
            matchSearch: ""
        }, 
        methods: { 
            gosh: function(match){
                if (this.disabledmatch != match) {
                    this.disabledmatch = match;

                }else{
                    this.disabledmatch = 0;
                }
                console.log(this.disabledmatch);
            },
            searchTeam: function(matchSearch){
                console.log(matchSearch);
            },
            getReferees: function(){
                axios
                    .get('searchCategory/'+ categorySearch )
                    .then(response => (
                        this.referees = response.data.referees,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
            },
        },
        mounted: function(){
            console.log(this.matchs)
        },
    });
    </script> 

@endsection