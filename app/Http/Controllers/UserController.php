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
        if (empty($request->id)) {
            return redirect()->route('referees')->with("error" ,"La id es requerido");
        }
        $users = User::find($request->id)->delete();
        return ['users' => User::all()];
    }

    public function restore(Request $request){
        if (empty($request->id)) {
            return redirect()->route('referees')->with("error" ,"La id es requerido");
        }
        //RECUPERAMOS LOS USUARIOS ELIMINADOS
        $users = User::onlyTrashed()->find($request->id)->restore();
        return ['users' => User::all()];
    }

    public function showTrashed (){
        //MOSTRAMOS LOS USUARIOS ELIMINADOS POR SOFTDELETES
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
        if (empty($request->id)) {
            return redirect()->route('referees')->with("error" ,"La id es requerido");
        }
        return view('users.update',['users' => User::find($request->id)]);
    }

    public function createUserFile(Request $request){
        
        $file = $request->file('excel');
        $users=[];
        $array = Excel::toArray(new Excel, $file);
        $rules = array(
            '0' => 'required',
            '1' => 'required',
            '2' => 'required',
            '3' => 'required|email',
        );    
        $messages = array(
            '0.required' => 'La codigo del árbitro es requerida',
            '1.required' => 'El nombre es requerido',
            '2.required' => 'El apellido es requerido',
            '3.required' => 'El email es requerido',
            '3.email' => 'El formato del email es incorrecto',
        );
        /**COMPROBAMOS QUE LA ESTRUCTURA DEL EXCEL ES LA CORRECTA */
        foreach ($array[0] as $rows) {
            $row=[
               0 => $rows[0], 
               1 => $rows[1],
               2 => $rows[2], 
               3 => $rows[3], 
            ];
            $validator = Validator::make($rows, $rules, $messages);
        
            if ($validator->fails()) {
                return redirect()->route('referees')->with("error" ,"el formato del excel no es el correcto");   
            }
        }

        /**LEEMOS EL EXCEL Y LO ALMACENAMOS EN LA BASE DE DATOS */
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
        return redirect()->route('referees')->with("message" ,"Se han añadido los árbitros");
    }

    public function updateUser(Request $request){
        if (!$request->id) {
            $user=User::find(Auth::id());
        }else{
            if (Auth::id()->role()=='admin') {
                $user=User::find($request->id);
            }else{
                return redirect()->route('referees')->with("error" ,"No tienes permisos para editar este perfil");
            }
        }
        //return $request->all();
        $user->update([
            "arb_cod" => $request->cod_arb,
            "name" => $request->name,
            "surname" => $request->surname,
            "email" => $request->email,
        ]);
        return redirect()->route('referees')->with("message" ,"Se han actualizado los datos del perfil");
    }


}
