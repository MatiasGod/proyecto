<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Validator;

use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Hash;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Category;
use App\Teams;
use App\Match;
use App\User;
use DB;

class UserController extends Controller
{
    public function getUsers(){
        return view('users.users',['users' => User::all()]);
    }

    public function delete(Request $request){
        $users = User::find($request->id)->delete();
        return ['users' => User::all(),'message' => 'Se ha borrado correctamente el usuario'];
    }

    public function restore(Request $request){
        $users = User::onlyTrashed()->find($request->id)->restore();
        return ['users' => User::all(),'message' => 'Se ha recuperado correctamente el usuario'];
    }

    public function showTrashed (){
        $users = User::onlyTrashed()->get();
        return ['userTrash' => $users];
    }

    public function getAllUsers(){
        return ['users' => User::all()];
    }
    public function getSomeUsers($name){
        return ['users' => User::where('name','like','%'.$name.'%')
                    ->orWhere('surname','like','%'.$name.'%')->get()];
    }

    public function getProfile(){
        return view('users.update', ['users' => User::find(Auth::id())]);
    }
    public function updateInformation(Request $request){
        return view('users.update',['users' => User::find($request->id)]);
    }
    public function createUserFile(Request $request){
        
        $file = $request->file('excel');
        $users=[];
        $array = Excel::toArray(new Excel, $file);
        foreach ($array[0] as $rows) {
            $user = User::create([
                'arb_cod' => (int)$rows[0],
                'name' => $rows[1],
                'surname' => $rows[2],
                'email' => $rows[3],
                'password' => Hash::make($rows[0]),
            ]);
            $user->assignRole('arbitro');
        }
        //dd(User::all());
        return view('users.users',['users' => User::all()]);
    }

    public function updateUser(Request $request){
        if (!$request->id) {
            $user=User::find(Auth::id());
        }else{
            if (Auth::id()->role()=='admin') {
                $user=User::find($request->id);
            }else{
                return ["message" => "No tienes permisos para editar este perfil"];
            }
        }
        //return $request->all();
        $user->update([
            "arb_cod" => $request->cod_arb,
            "name" => $request->name,
            "surname" => $request->surname,
            "email" => $request->email,
        ]);
        return ["message" => "Se han actualizado los datos del perfil"];
    }
}
