<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
class UsersController extends Controller
{
  /**
  * Obtiene la vista para el registro de un usuarios
  *
  */
  public function getVistaRegistrarse()
  {
    return view('autenticacion.registro');
  }
  /**
  * Registra un usuario administrador de biblioteca
  * @param $request contenedor de los parametros
  */
  public function registrarse(Request $request)
  {
    $this->validate($request, [
      'nombres'        => 'required | string| min:5|max:40',
      'apellidos' => 'required | string| min:5|max:40',
      'telefono'=>'required | string|max:20',
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
          $user->nombres=$request->get('nombres');
          $user->apellidos=$request->get('apellidos');
          $user->telefono=$request->get('telefono');
          $user->save();
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
      'nombres'        => 'required | string| min:5|max:40',
      'apellidos' => 'required | string| min:5|max:40',
      'telefono'=>'required | string|max:20',
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
          $user->nombres=$request->get('nombres');
          $user->apellidos=$request->get('apellidos');
          $user->telefono=$request->get('telefono');
          $user->save();
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
    /**
    * Lista los usuarios
    */
    public function index()
    {
      $usuarios=User::all();
      return view('bibliotecas.listarBibliotecas');
      //retornar vista con usuarios
    }
    /**
    * Retorna la vista para editar un usuario por parte del administrador
    * @param $id
    */
    public function edit($id)
    {
      $usuario=User::find($id);
      if($usuario!=null)
      {
        //retornar vista para edicion de administrador
      }
      else {
        return redirect()->back()->withErrors("Usuario no registrado");
      }
    }
    /**
    * Actualiza la informacion de un usuario
    * @param $id identificador del usuario
    * @param $request  contenedor de parametrso
    */
    public function update(Request $request,$id)
    {
      $this->validate($request, [
        'nombres'        => 'required | string| min:5|max:40',
        'apellidos' => 'required | string| min:5|max:40',
        'telefono'=>'required | string|max:20',
        'email'=>'required|email|min:6|max:255',
        ]);
        $user=User::where([['email','=',$request->get('email')],['id','!=',Auth::user()->id]])->get()->first();
        if($user==null)
        {
          $user=User::find(Auth::user()->id);
          $user->email=$request->get('email');
          $user->nombres=$request->get('nombres');
          $user->apellidos=$request->get('apellidos');
          $user->telefono=$request->get('telefono');
          $user->save();
          if(Auth::attempt(['email' => $user->email, 'password' => $request->get('password')]))
          {
            return redirect()->route('home');
          }
          else {
            Session::flash('flash_message', 'Usuario registrado');
            return redirect()->back();
          }
        }
      }
      /**
      * Elimina un usuario
      * @param $id  el idnetificador de la biblioteca a eliminar
      */
      public function destroy($id)
      {
        $usuario=User::find($id);
        if($usuario!=null)
        {
          $bibliotecas=Biblioteca::where('id_user','=',$usuario->id)->get();
          $bi=new BibliotecasController();
          foreach($bibliotecas as $b)
          {
            $bi->eliminarBiblioteca($b);
          }
          $usuario->delete();
        }
        else {
          return redirect()->back()->withErrors("Usuario no registrado");
        }
      }
    }
