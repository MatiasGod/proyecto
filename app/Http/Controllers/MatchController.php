<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Validator;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Category;
use App\Teams;
use App\Match;
use App\User;
use Hash;
use Auth;
use DB;
use Illuminate;

        

class MatchController extends Controller
{
    public function getMatchs(){
        //return ['matchs' => Match::with('user')->get()];
        return view('matchs.matchs',
            ['matchs' => Match::with('teams')->with('users')->orderBy('date', 'desc')->get(),
            'referees' => User::all()]);
    }
    public function getMatchsAxiosLocation(){
        //return ['matchs' => Match::with('user')->get()];
        return ['matchs' => Match::with('teams')->with('users')->orderBy('date', 'desc')->get(),
            'referees' => User::all()];
    }
    public function getMatchsAxiosCategory(){
        //return ['matchs' => Match::with('user')->get()];
        return ['matchs' => Match::with('teams')->with('users')->orderBy('date', 'desc')->get(),
            'referees' => User::all()];
    }
    public function getMatchsDay(){
        //return ['matchs' => Match::with('teams')->orderBy('date', 'desc')->get()];
        return view('matchs.matchs',
            ['matchs' => Match::where('date',$date)->with('teams')->with('users')->orderBy('date', 'desc')->get(),
            'referees' => User::all()]);
    }
    
    public function loadMatchs(Request $request){
        if (!$request->file('excel')) {
            return redirect()->route('matchs')->with("error" ,'No existe el archivo');
        }

        $file = $request->file('excel');
        $arrMatchs=[];
        $array = Excel::toArray(new Excel, $file);
        
        $rules = array(
            '0' => 'required',
            '1' => 'required',
            '2' => 'required',
            '3' => 'required',
            '4' => 'required',
            '5' => 'required',
        );    
        $messages = array(
            '0.required' => 'La fecha es requerida',
            '1.required' => 'El número de partido es requerido',
            '2.required' => 'La categoría es requerida',
            '3.required' => 'El equipo B es requerido',
            '4.required' => 'El equipo A es requerido',
            '5.required' => 'La localidad es requerida',
        );
        /**COMPROBAMOS QUE LA ESTRUCTURA DEL EXCEL ES LA CORRECTA */
        foreach ($array[0] as $rows) {
            $date = Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[0]));
            $row=[
               0 => $date, 1 => $rows[1], 
               2 => $rows[2], 3 => $rows[3], 
               4 => $rows[4], 5 => $rows[5], 
            ];
            $validator = Validator::make($rows, $rules, $messages);
        
            if ($validator->fails()) {
                return redirect()->route('matchs')->with("error" ,'el formato del excel no es el correcto');
            }
        }

        /**LEEMOS EL EXCEL Y LO ALMACENAMOS EN LA BASE DE DATOS */
        foreach ($array[0] as $rows) {
            $match = Match::create([
                "matchNumber" => (int)$rows[1],
                "date" => Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[0])),
                "category" => $rows[2],
                "location" => $rows[5]    
            ]);
            $this->teamAttach($match,$rows[3]);
            $this->teamAttach($match,$rows[4]);
            

        }
        return redirect()->route('matchs')->with('message' ,'Se han actalizado los partidos');

    }

    public function dateTimeValidator($dateTime){
        $dateTime = explode(' ', $dateTime);
        $date = explode('-', $dateTime[0]);
        $time = explode(':', $dateTime[1]);
        //dd($date);
        if(count($date) == 3 && $date[1] > 0 && $date[1] <= 12  && $date[2] > 0
            && $date[1] <= 31 && count($time) == 3 && $time[0] >= 0 && $time[0]<=24 
            && $time[1] >= 0 && $time[1]<=60 && $time[2] >= 0 && $time[2]<=60){
            return true;
        }
        return false;
    }

    private function teamAttach($match,$name){
        $team=Teams::where('name',$name)->get();
        if (empty($team)) {
            $team=Teams::create([
                'name' => $name,
            ]);
        }
        $match->teams()->attach($team);
    }

    public function updateMatch(Request $request){
        
        $match = Match::where('id',$request->id)->first();
        if (!$match) {
            return redirect()->route('matchs')->with('error', "No existe el partido");
        }
        //dd($request->id);
        $match->update([
            'matchNumber' => $request->match,
            'date' => $request->date,
            'location' => $request->location,
            'category' => $request->category
        ]);
        
        $match->users()->detach();
        if ($request->principal) {
            $referee = User::where('name',$request->principal)->first();
            $match->users()->attach($referee);
        }
        if ($request->auxiliar) {
            $referee = User::where('name',$request->auxiliar)->first();
            $match->users()->attach($referee);
        }
        if ($request->anotador) {
            $referee = User::where('name',$request->anotador)->first();
            $match->users()->attach($referee);
        }
        if ($request->crono) {
            $referee = User::where('name',$request->crono)->first();
            $match->users()->attach($referee);
        }
        return redirect()->route('matchs')->with('message', "Se han actualizado los datos del perfil");
        //dd($match);
    }

    public function searchMatchByLocation(Request $request){
        if (empty($request->location)) {
            return redirect()->route('matchs')->with('error', "Debes añadir una localización");
        }
        return ['matchs' => Match::where('location','like','%'.$request->location.'%')->get()];
    }
    public function searchMatchByCategory(Request $request){
        if (empty($request->category)) {
            return redirect()->route('matchs')->with('error', "Debes añadir una categoría");
        }
        return ['matchs' => Match::where('category','like','%'.$request->category.'%')->get()];
    }
}
