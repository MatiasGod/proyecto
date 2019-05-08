<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matchs';
    protected $fillable = ['matchNumber','date','category','location','file_name'];
    //protected $with = ['teams'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function teams()
    {
        return $this->belongsToMany('App\Teams');
    }

    /* public function createMatchExcel($partido){
        $arrMatchs=[];
        $array = Excel::toArray(new ExcelModel, 'excel/prubea.xlsx');
        foreach ($array[0] as $rows) {
            $arrMatch=[
                //devuelve un objeto numerico, la clase PhpSpread lo castea a fecha y carbon lo castea a carbon.
                "date" => Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[0])),
                "match_number" => (int)$rows[1],
                "category" => $rows[2],
                "team_local" => $rows[3],
                "team_visitor" => $rows[4],
                "location" => $rows[5]              
            ];
            array_push($arrMatchs, $arrMatch);
        }
        return view('partidos',['partidos' => $arrMatchs]);
    } */

}
