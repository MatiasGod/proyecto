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

class MatchController extends Controller
{
    public function getMatchs(){
        //return ['matchs' => Match::with('teams')->orderBy('date', 'desc')->get()];
        return view('matchs.matchs',
            ['matchs' => Match::with('teams')->orderBy('date', 'desc')->get(),
            'referees' => User::all()]);
    }
    public function getMatchsDay(){
        //return ['matchs' => Match::with('teams')->orderBy('date', 'desc')->get()];
        return view('matchs.matchs',
            ['matchs' => Match::where('date',$date)->with('teams')->orderBy('date', 'desc')->get(),
            'referees' => User::all()]);
    }
 
    public function loadMatchs(Request $request){
        $file = $request->file('excel');
        $arrMatchs=[];
        $array = Excel::toArray(new Excel, $file);
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
        return view('matchs.matchs',
            ['matchs' => Match::with('teams')->orderBy('date', 'desc')->get(),
            'referees' => User::all()]);

    }
    private function teamAttach($match,$team){
        $team=Teams::where('name',$team)->get();
            if (empty($team)) {
                Teams::create([
                    'name' => $team,
                ]);
            }
        $match->teams()->attach($team);
    }
}
