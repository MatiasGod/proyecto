<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () { return view('auth.login'); })->name('/');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();



Route::group(['middleware' => 'auth'], function () {});
    Route::group(['middleware' => ['role:admin']], function () {
    
    });
    Route::group(['middleware' => ['role:arbitro']], function () {
    });
    Route::get('/home',function () { return view('menu'); })->name('home');
    Route::get('/menu', function () { return view('menu'); })->name('menu');
    //Route::get('match_view',  function () { return view('matchs.partidos'); })->name('match_view');
    Route::get('match_view', 'ExcelController@matchs')->name('match_view');
    //cargar fichero excel y guardar en la base datos.
    Route::get('referees', 'UserController@getUsers')->name('referees');
    Route::get('updateInfo/{id}', 'UserController@updateInformation')->name('updateInfo');
    Route::get('getAllUsers', 'UserController@getAllUsers')->name('getAllUsers');

    /**
     *  USUARIOS
     */

    Route::get('profile', 'UserController@getProfile')->name('profile');
    Route::post('UpdateProfile', 'UserController@updateUser')->name('UpdateProfile');
    Route::get('deleteUser/{id}', 'UserController@delete')->name('deleteUser');
    Route::get('userTrash', 'UserController@showTrashed')->name('userTrash');
    Route::get('restore/{id}', 'UserController@restore')->name('restore');
    Route::get('buscar/{name}', 'UserController@getSomeUsers')->name('busar');
    Route::post('createUserFile', 'UserController@createUserFile')->name('createUserFile');
    Route::get('formUser', function(){
        return view('users.createUser');
    })->name('formUser');


    /**
     *  EQUIPOS
     */
    Route::get('allTeams', 'TeamController@getAllTeams')->name('allTeams');
    Route::get('getTeams', 'TeamController@getTeams')->name('getTeams');
    Route::get('getSomeTeams', 'TeamController@getSomeTeams')->name('getSomeTeams');
    Route::get('searchTeam/{name}', 'TeamController@getSomeTeams')->name('searchTeam');
    Route::get('searchCategory/{name}', 'TeamController@searchCategory')->name('searchCategory');
    Route::post('createTeams', 'TeamController@createteams')->name('createTeams');
    Route::get('teamInfo/{id}', 'TeamController@teamInfo')->name('teamInfo');
    Route::post('updateTeam', 'TeamController@updateTeam')->name('updateTeam');

    /**
     *  PARTIDOS
     */
    Route::get('matchs', 'MatchController@getMatchs')->name('matchs');
    Route::get('matchsDay', 'MatchController@getMatchsDay')->name('matchs');
    
    Route::get('searchMatchByLocation/{location}', 'MatchController@getMatchs')->name('matchs');
    Route::get('searchMatchByTeam/{team}', 'MatchController@getMatchs')->name('matchs');
    Route::get('searchMatchByTime/{time}', 'MatchController@getMatchs')->name('matchs');
    Route::get('searchMatchByReferee/{referee}', 'MatchController@getMatchs')->name('matchs');

    Route::get('setReferees', 'MatchController@getMatchs')->name('matchs');

    Route::post('loadMatchs', 'MatchController@loadMatchs')->name('matchs');


    /**CUIDADO ES PARA CARGAR PARTIDOS NO PARA FUNCIONALIDAD */
