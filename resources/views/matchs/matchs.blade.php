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
        <div class="col-md-7 my-auto">  
        <div class="row">
            <label for="" class="col-md-3 text-light">Buscar Localidad</label>
            <input type="text" class="col-md-4" name="busqueda" v-model="location" @keyup.enter="searchMatchByLocation(location)" @blur="searchMatchByLocation(location)"><br>
        </div>
        <div class="row mt-2">
            <label for="" class="col-md-3 text-light">Buscar categoría</label>
            <input type="text" class="col-md-4" name="busqueda" v-model="category" @keyup.enter="searchMatchByCategory(category)" @blur="searchMatchByCategory(category)"><br>
        </div>
        </div>
        @role('admin')
        <div class="col-md-1 my-auto">
            
        </div>
        <div class="col-md-4">
            <form action="{{ url('loadMatchs') }}" method="post" enctype="multipart/form-data">
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
                    <th>Principal</th>
                    <th>Auxiliar</th>
                    <th>Anotador</th>
                    <th>Crono</th>
                </tr>
                
            </thead>
            <tbody v-for="(match,key) in matchs"> 
                <tr>
                <td><button type="button" class="btn btn-primary" @click="setModel(key)" data-toggle="modal" data-target="#exampleModal">
                    @{{match.matchNumber}}
                </button></td>
                    <!-- <td><a :href="'/matchInfo/' + match.id">@{{match.matchNumber}}</a></td> -->
                    <td>@{{match.date}}</td>
                    <td>@{{match.location}}</td>
                    <td>@{{match.category}}</td>
                    <td v-for="teams in match.teams">@{{teams.name}}</td>
                    <td v-for="referees in match.users">@{{referees.name}}</td>
                </tr>
                
            </tbody>
        </table>

        <div v-if="message" class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Guacamoles!</strong> @{{message}}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>




<!-- VENTANA MODAL DE BOOTSTRAP -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('updateMatch')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" :value="arrModel.id">
            <div class="form-group">
                <label for="my-input">Partido</label>
                <input id="my-input" name="match" :value="arrModel.matchNumber" class="form-control" type="text">
            </div>
            <div class="form-group">
                <label for="my-input">Fecha</label>
                <input id="my-input" name="date" :value="arrModel.date" class="form-control" type="text">
            </div>
            <div class="form-group">
                <label for="my-input">Lugar</label>
                <input id="my-input" name="location" :value="arrModel.location" class="form-control" type="text">
            </div>
            <div class="form-group">
                <label for="my-input">Categoría</label>
                <input id="my-input" name="category" :value="arrModel.category" class="form-control" type="text">
            </div>
            <div class="form-group">
                <label for="my-input">Equipo A</label>
                <input id="my-input"  name="teamA" :value="arrModel.teamA" class="form-control" type="text" disabled>
            </div>
            <div class="form-group">
                <label for="my-input">Equipo B</label>
                <input id="my-input" name="teamB" :value="arrModel.teamB" class="form-control" type="text" disabled>
            </div>
            <div class="form-group">
                <label for="my-input" class="col-md-2">Principal</label>
                <select name="principal" class="col-md-3" v-model="principal" v-on:change="refereesCheck('principal')" id="prin">
                    <option v-if="arrModel.arb1 != 'No'" :selected="arrModel.arb1 != 'No'" :value="arrModel.arb1" selected="selected">@{{arrModel.arb1}}</option>
                    <option v-for="referee in referees">@{{ referee.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="my-input" class="col-md-2">Auxiliar</label>
                <select name="auxiliar" class="col-md-3" v-model="auxiliar" v-on:change="refereesCheck('auxiliar')" id="aux" >
                    <option v-if="arrModel.arb2 != 'No'" :selected="arrModel.arb2 != 'No'" :value="arrModel.arb2" selected="selected">@{{arrModel.arb2}}</option>
                    <option v-for="referee in referees">@{{ referee.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="my-input" class="col-md-2">Anotador</label>
                <select name="anotador" class="col-md-3" v-model="anotador" v-on:change="refereesCheck('anotador')" id="ano">
                    <option v-if="arrModel.arb3 != 'No'" :value="arrModel.arb3" selected="selected">@{{arrModel.arb3}}</option>
                    <option v-for="referee in referees">@{{ referee.name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label for="my-input" class="col-md-2">Crono</label>
                <select name="crono" class="col-md-3" v-model="crono" v-on:change="refereesCheck('crono')" id="crono">
                    <option v-if="arrModel.arb4 != 'No'" :value="arrModel.arb4" selected="selected">@{{arrModel.arb4}}</option>
                    <option v-for="referee in referees">@{{ referee.name }}</option>
                </select>
            </div>
            <input type="submit" class="btn btn-primary" value="Modificar">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>

    <script>
    
    
    var matchs_vue = new Vue({
        el: '#app',
        data: {
            matchs: {!! $matchs !!},
            referees: {!! $referees !!},
            message: "",
            disabledmatch: "",
            matchSearch: "",
            arrModel:"",
            principal: "",
            auxiliar: "",
            anotador: "",
            crono: ""
        }, 
        methods: { 
            refereesCheck: function(value){
                if (this.principal == this.auxiliar || this.principal == this.anotador
                    || this.principal == this.crono) {
                        $("#prin").css("border-color", "red");
                }else{
                    $("#prin").css("border-color", "");
                }
                if (this.auxiliar == this.principal || this.auxiliar == this.anotador
                    || this.auxiliar == this.crono) {
                        $("#aux").css("border-color", "red");
                }else{
                    $("#aux").css("border-color", "");
                }
                if (this.anotador == this.auxiliar || this.principal == this.anotador
                    || this.anotador == this.crono) {
                        $("#ano").css("border-color", "red");
                }else{
                    $("#ano").css("border-color", "");
                }
                if (this.crono == this.auxiliar || this.crono == this.anotador
                    || this.principal == this.crono) {
                        $("#crono").css("border-color", "red");
                }else{
                    $("#crono").css("border-color", "");
                }
            },
            gosh: function(match){
                if (this.disabledmatch != match) {
                    this.disabledmatch = match;

                }else{
                    this.disabledmatch = 0;
                }
                console.log(this.disabledmatch);
            },
            searchMatchByCategory: function(Category){
                console.log(Category)
                if (Category != "") {
                    axios
                    .get('searchMatchByCategory/'+ Category )
                    .then(response => (
                        this.matchs = response.data.matchs,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }else{
                    axios
                    .get('getMatchsAxiosCategory')
                    .then(response => (
                        this.matchs = response.data.matchs,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }
            },
            searchMatchByLocation: function(location){
                console.log(location)
                if (location != "") {
                    axios
                    .get('searchMatchByLocation/'+ location )
                    .then(response => (
                        this.matchs = response.data.matchs,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }else{
                    axios
                    .get('getMatchsAxiosLocation')
                    .then(response => (
                        this.matchs = response.data.matchs,
                        console.log(response.data)
                        ))
                    .catch(error => console.log(error))
                }
            },
            setModel: function(matchModel){
                console.log(matchModel)
                console.log(this.matchs[matchModel])
                this.arrModel = {
                    'id' : this.matchs[matchModel].id,
                    'category' : this.matchs[matchModel].category,
                    'date' : this.matchs[matchModel].date,
                    'matchNumber' : this.matchs[matchModel].matchNumber,
                    'location' : this.matchs[matchModel].location,
                    'id' : this.matchs[matchModel].id,
                    'teamA' : this.matchs[matchModel].teams[0].name,
                    'teamB' : this.matchs[matchModel].teams[1].name,
                },
                this.principal= this.matchs[matchModel].users[0] !== undefined ? this.matchs[matchModel].users[0].name : "No",
                this.auxiliar= this.matchs[matchModel].users[1] !== undefined ? this.matchs[matchModel].users[1].name : "No",
                this.anotador= this.matchs[matchModel].users[2] !== undefined ? this.matchs[matchModel].users[2].name : "No",
                this.crono= this.matchs[matchModel].users[3] !== undefined ? this.matchs[matchModel].users[3].name : "No",
                console.log(this.arrModel)
            },
            
        },
        mounted: function(){
            console.log(this.matchs)
            console.log(this.referees)
            console.log('prin: '+this.principal+' aux: '+this.auxiliar+' ano: '+this.anotador+' crono: '+this.crono)
        },
    });
    </script> 

@endsection