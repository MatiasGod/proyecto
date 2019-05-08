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

class TeamController extends Controller
{
    public function getAllTeams(){
        return view('teams.index',['teams' => Teams::with('categories')->get()]);
    }
    public function getTeams(){
        return ['teams' => Teams::with('categories')->get()];
    }

    public function getTeam(Request $request){
        return ['teams' => Teams::find($request->id)];
    }

    public function getSomeTeams(Request $request){
        return ['teams' => Teams::where('name','like','%'.$request->name.'%')->with('categories')->get()];
    }

    public function searchCategory(Request $request){
        $name = $request->name;
        //buscamos dentro de los equipos la categoría pasada por request a por un scope
        $teams = Teams::whereHas('categories', function ($q) use ($name) {
            $q->where('category', 'like','%'.$name.'%');
        })->with('categories')->get();
        
        return ['teams' => $teams];
    }
    public function createteams(Request $request){
        
        $file = $request->file('excel');
        $users=[];
        $array = Excel::toArray(new Excel, $file);
        foreach ($array[0] as $rows) {
            $category = Category::where('category',$rows[1])->first();
            $auxTeam = Teams::where('name', $rows[0])->first();
            if ($auxTeam) {
                $auxTeam->categories()->attach($category->id);
                //dump($category->id);
            }else{
                $team = Teams::create([ 'name' => $rows[0] ]);
                $team->categories()->attach($category->id);
            }
        }
        return view('teams.index',['teams' => Teams::with('categories')->get()]);
    }
    
    public function teamInfo(Request $request){
        $teams = Teams::where('id',$request->id)->with('categories')->first();
        $categories = Category::all();
        $arr=array();

        foreach ($categories as $categoryValue) {
            //dump($categoryValue->toArray()['category']);
            $value = $categoryValue->toArray()['category'];
            //dd($teams->categories()->select('category')->get()->toArray());
            if (in_array($value, $teams->categories()->pluck('category')->toArray()  )) {
                //dump("yeah");
                array_push($arr,true);
            }else
                array_push($arr,false);
        }
        //  dd($arr);
        return view('teams.update',
            [
                'teams' => $teams,
                'arr' => json_encode($arr),
                'categories' => $categories
            ]);
    }

    public function updateTeam(Request $request){
        //dd($request->all());
        $team = Teams::find($request->id);
        $team->update(["name" => $request->name ]);
        $team->categories()->detach();

        if ($request->prebenjamin)  $team->categories()->attach($request->prebenjamin);
        if ($request->benjamin)     $team->categories()->attach($request->benjamin);
        if ($request->premini)      $team->categories()->attach($request->premini);
        if ($request->mini)         $team->categories()->attach($request->mini);
        if ($request->preinfantil)  $team->categories()->attach($request->preinfantil);
        if ($request->infantil)     $team->categories()->attach($request->infantil);
        if ($request->precadete)    $team->categories()->attach($request->precadete);
        if ($request->cadete)       $team->categories()->attach($request->cadete);
        if ($request->junior)       $team->categories()->attach($request->junior);
        if ($request->cadete)       $team->categories()->attach($request->cadete);
        if ($request->sub22)        $team->categories()->attach($request->sub22);
        if ($request->senior)       $team->categories()->attach($request->senior);

        return view('teams.index',['teams' => Teams::with('categories')->get(),"message" => "Se han actualizado los datos del equipo"]);
    }
}
