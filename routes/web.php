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



Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('deleteUser/{id}', 'UserController@delete')->name('deleteUser');
        Route::get('userTrash', 'UserController@showTrashed')->name('userTrash');
        Route::get('restore/{id}', 'UserController@restore')->name('restore');
        Route::post('createUserFile', 'UserController@createUserFile')->name('createUserFile');
        
        Route::post('updateTeam', 'TeamController@updateTeam')->name('updateTeam');
        Route::post('createTeams', 'TeamController@createteams')->name('createTeams');
        
        Route::post('updateMatch', 'MatchController@updateMatch')->name('updateMatch');
        Route::post('loadMatchs', 'MatchController@loadMatchs')->name('loadMatchs');
    });

    Route::get('/home',function () { return view('menu'); })->name('home');
    Route::get('/menu', function () { return view('menu'); })->name('menu');
    
    /**
     *  USUARIOS
     */
    Route::get('updateInfo/{id}', 'UserController@updateInformation')->name('updateInfo');
    Route::get('getAllUsers', 'UserController@getAllUsers')->name('getAllUsers');
    Route::get('referees', 'UserController@getUsers')->name('referees');
    Route::get('profile', 'UserController@getProfile')->name('profile');
    Route::post('UpdateProfile', 'UserController@updateUser')->name('UpdateProfile');
    Route::get('buscar/{name}', 'UserController@getSomeUsers')->name('busar');
    
    /**
     *  EQUIPOS
     */
    Route::get('allTeams', 'TeamController@getAllTeams')->name('allTeams');
    Route::get('getTeams', 'TeamController@getTeams')->name('getTeams');
    Route::get('getSomeTeams', 'TeamController@getSomeTeams')->name('getSomeTeams');
    Route::get('searchTeam/{name}', 'TeamController@getSomeTeams')->name('searchTeam');
    Route::get('searchCategory/{name}', 'TeamController@searchCategory')->name('searchCategory');
    Route::get('teamInfo/{id}', 'TeamController@teamInfo')->name('teamInfo');
    
    /**
     *  PARTIDOS
     */
    Route::get('match_view', 'ExcelController@matchs')->name('match_view');
    Route::get('matchs', 'MatchController@getMatchs')->name('matchs');
    Route::get('getMatchsAxiosLocation', 'MatchController@getMatchsAxiosLocation')->name('getMatchsAxiosLocation');
    Route::get('searchMatchByLocation/{location}', 'MatchController@searchMatchByLocation')->name('searchMatchByLocation');
    Route::get('getMatchsAxiosCategory', 'MatchController@getMatchsAxiosCategory')->name('getMatchsAxiosCategory');
    Route::get('searchMatchByCategory/{category}', 'MatchController@searchMatchByCategory')->name('searchMatchByCategory');
    

    /**CUIDADO ES PARA CARGAR PARTIDOS NO PARA FUNCIONALIDAD */
});