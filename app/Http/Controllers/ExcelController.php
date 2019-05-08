<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Category;
use App\User;
use App\Match;
use App\Teams;
use DB;

class ExcelController extends Controller
{
    public function getMatch(){
        $arrMatchs=[];
        $array = Excel::toArray(new Excel, 'excel/prubea.xlsx');
        /* foreach ($array[0] as $rows) {
            $arrMatch=[
                "date" => Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[0])),
                "match_number" => (int)$rows[1],
                "category" => $rows[2],
                "team_local" => $rows[3],
                "team_visitor" => $rows[4],
                "location" => $rows[5]    
            ];
            array_push($arrMatchs, $arrMatch);
        } */
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
        
        //return view('matchs.partidos',['asd' => $match]);
        return view('matchs.partidos',['partidos' => Match::find(1)->first()]);

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
    public function matchs(){
        //return $users = User::all();
        return view('matchs.partidos',['partidos' => User::all()]);
    }
}
