<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Biblioteca;
use App\Plano;
use Auth;
use Session;
use App\User;
use File;
class BibliotecasController extends Controller
{

  /**
  * Guarda una biblioteca en la base de datos
  * @param $request contenedor de parametros para crear y guardar la biblioteca
  */
  public function store(Request $request)
  {
    $this->validate($request, [
      'nombre'        => 'required | string| min:5|max:80',
      'pais' => 'required | string| min:5|max:20',
      'departamento'=>'required | string| min:5|max:20',
      'municipio'=>'required | string| min:5|max:20',
      'direccion'=>'required | string| min:5|max:100'
      ]);
      $data=$request->all();
      $data['id_user']=Auth::user()->id;
      $biblioteca=Biblioteca::create($data);
      $plano=new Plano();
      $plano->nivel=1;
      $plano->id_biblioteca=$biblioteca->id;
      $plano->save();
      Session::flash('flash_message', 'Biblioteca registrada');
      return redirect()->back();
    }

    /**
    * Retorna la vista para crear una biblioteca
    */
    public function create()
    {
      return view('bibliotecas.agregarBiblioteca');
    }
    /**
    * Lista las bibliotecas
    *
    */
    public function index()
    {
      $bibliotecas=Biblioteca::where('id_user','=',Auth::user()->id)->get();
      return view('bibliotecas.listarBibliotecas',['bibliotecas'=>$bibliotecas]);
    }
    /**
    * Muestra una biblioteca determinada
    * @param $id  el identificador de la biblioteca
    */
    public function show($id)
    {
      $biblioteca=Biblioteca::find($id);
      if($biblioteca!=null)
      {
        return view('bibliotecas.verBiblioteca',['biblioteca'=>$biblioteca]);
      }
      else {
        return redirect()->back()->withErrors("No se encontro la biblioteca");
      }
    }
    /**
    * Obtiene la biblioteca con los planos
    * @param $id identificador de la biblioteca
    */
    public function getBibliotecaVirtual($id)
    {
      $biblioteca=Biblioteca::find($id);
      if($biblioteca!=null)
      {
        $planos=Plano::where('id_biblioteca','=',$biblioteca->id)->get();
        return view('bibliotecas.bibliotecaVirtual',['biblioteca'=>$biblioteca]);
      }
      else {
        return redirect()->back()->withErrors("No se encontro la biblioteca");
      }
    }
    /**
    * Muestra la vista para editar una biblioteca
    * @param $id  identificador de la biblioteca
    */
    public function edit($id)
    {
      $biblioteca=Biblioteca::find($id);
      return view('bibliotecas.editarBiblioteca');
    }
    /**
    * Actualiza una biblioteca
    * @param $request  cotenedor de parametros a actualizar
    * @param $id identificador de la biblioteca
    */
    public function update(Request $request,$id)
    {
      $this->validate($request, [
        'nombre'        => 'required | string| min:5|max:80',
        'pais' => 'required | string| min:5|max:20',
        'departamento'=>'required | string| min:5|max:20',
        'municipio'=>'required | string| min:5|max:20',
        'direccion'=>'required | string| min:5|max:100'
        ]);
        $biblioteca=Biblioteca::find($id);
        if($biblioteca!=null)
        {
          $data=$request->only('nombre','pais','departamento','municipio','direccion');
          $biblioteca->update($data);
          Session::flash('flash_message', 'Biblioteca Actualizada');
        }
        else {
          return redirect()->back()->withErrors('Biblioteca no registrada');
        }
      }
      /**
      * Modifica el administrador de la biblioteca
      * @param $request    contenedor de paramtros
      *
      */
      public function modificarAdministradorBiblioteca(Request $request)
      {
        $this->validate($request, [
          'id_user'        => 'required | integer',
          'id_biblioteca' => 'required |integer',
          ]);
          $biblioteca=Biblioteca::find($request->get('id_biblioteca'));
          if($biblioteca!=null)
          {
            $usuario=User::find($request->get('id_user'));
            if($usuario!=null)
            {
              $biblioteca->id_user=$usuario->id;
              $biblioteca->save();
              Session::flash("flash_message","Administrador de biblioteca actualizado");
            }
            else {
              return redirect()->back()->withErrors("El usuario no se encuentra registrado");
            }
          }
          else {
            return redirect()->back()->withErrors("La biblioteca no se encuentra registrada");
          }
        }
        /**
        * Obtiene las bibliotecas de un usuario determinado, y la informacion del usuario
        * @aram $id identificador del usuarios
        */
        public function getBibliotecasUsario($id)
        {
          $usuario=User::find($id);
          if($usuario!=null)
          {
            $bibliotecas=Biblioteca::where('id_user','=',$id)->get();
            //retornar vista con usuario y sus bibliotecas
          }
          else {
            return redirect()->back()->withErrors("Usuario no registrado");
          }
        }
        /**
        * Retorna la vista para que un usuario administrador pueda
        * editar esa información
        * @param $id   el idnetificador de la biblioteca a editar
        */
        public function editarBibliotecaAdministrador($id)
        {
          $biblioteca=Biblioteca::find($id);
          if($biblioteca!=null)
          {
            $usuarios=User::all();
            //retornar vista con biblioteca y usuarios
          }
          else {
            return redirect()->back()->withErrors("Biblioteca no registrada");
          }
        }
        /**
        * Muestra la biblioteca del administrador
        * @param $id   identificador de la biblioteca
        */
        public function mostrarBibliotecaAdministrador($id)
        {
          $biblioteca=Biblioteca::find($id);
          if($biblioteca!=null)
          {
            $user=User::find($biblioteca->id_user);
            //retornar vista con biblioteca y usuario asignado
          }
          else {
            return redirect()->back()->withErrors("La biblioteca no se encuentra registrada");
          }
        }
        /**
        * Obtiene los planos asociados a la biblioteca
        * @param $idBiblioteca   identificador de la biblioteca
        */
        public function getPlanosBiblioteca($idBiblioteca)
        {
          $biblioteca=Biblioteca::find($idBiblioteca);
          if($biblioteca!=null)
          {
            $planos=Plano::where('id_biblioteca',$idBiblioteca)->get();
            return response()->json(['planos'=>$planos],200);
          }
          else {
            return response()->json(['Error'=>'Biblioteca no encontrada'],404);
          }
        }
        /**
        * Elimina una biblioteca
        * @param $id
        */
        public function destroy($id)
        {
          $biblioteca=Biblioteca::find($id);
          if($biblioteca!=null)
          {
            $this->eliminarBiblioteca($biblioteca);
            Session::flas('flash_message','Biblioteca eliminada');
            return redirect()->back();
          }
          else {
            return redirect()->back()->withErrors("La biblioteca no existe");
          }

        }
        /**
        * Elimina una biblioteca
        * @param $biblioteca   biblioteca a eliminar
        */
        public function eliminarBiblioteca($biblioteca)
        {
          $codigos=Codigo::where('id_biblioteca','=',$biblioteca->id)->get();
          foreach($codigos as $cod)
          {
            File::delete(public_path().$cod->imagen);
          }
          $biblioteca->delete();
        }
      }
