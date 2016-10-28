<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
class UsersController extends Controller
{
  /**
  * Muestra la vista de registro al usuario
  */
  public function create()
  {
    return view('autenticacion.registro');
  }
  /**
  * Crea y almacena un nuevo usuario
  * @param $request  parametros para crear el usuario
  */
  public function store(Request $request)
  {
    $this->validate($request, [
      'nombre'        => 'required | string| min:5|max:80',
      'pais' => 'required | string| min:5|max:20',
      'departamento'=>'required | string| min:5|max:20',
      'municipio'=>'required | string| min:5|max:20',
      'direccion'=>'required | string| min:5|max:20',
      'email'=>'required|email|min:6|max:255',
      'password'=>'required|string|min:6|max:255',
      'confirm_passw'=>'required|string|min:6|max:255'
      ]);
      if($request->get('password')==$request->get('confirm_passw'))
      {
        $user=User::where('email',$request->get('email'))->get()->first();
        if($user==null)
        {
          $user=new User();
          $user->email=$request->get('email');
          $user->password=bcrypt($request->get('password'));
          $user->save();
          $biblioCont=new BibliotecasController();
          $biblio=$biblioCont->store($request,$user->id);
          if(Auth::attempt(['email' => $user->email, 'password' => $request->get('password')]))
          {
            return redirect()->route('home');
          }
          else {
            Session::flash('flash_message', 'Usuario registrado');
            return redirect()->back();
          }
        }
        else {
          return redirect()->back()->withInput()->withErrors("El email ya se encuentra registrado");
        }
      }
      else {
        return redirect()->back()->withInput()->withErrors("Las contraseñas no coinciden");
      }
    }
  }
