<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Estante;
use App\Plano;
use App\Biblioteca;
use Auth;
class EstantesController extends Controller
{
  /**
  * Obtiene todos los estantes de la biblioteca del usuario en sesion
  *
  */
  public function getEstantes()
  {
    $idUsuario=Auth::user()->id;
    $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();
    if($idBiblioteca!=null)
    {
      $idPlano=DB::table('planos')->select('id')->where('id_biblioteca','=',$idBiblioteca->id)->get()->first();
      if($idPlano!=null)
      {
        $estantes=DB::table('estantes')->select()->where('id_plano','=',$idPlano->id)->get();
        return response(['estantes'=>$estantes],200);
      }
      else {
        return response([['No se encontró el plano de la biblioteca']],404);
      }
    }
    else {
      return response([['No se encontró la biblioteca']],404);
    }

  }
  /**
  * Obtiene los estantes desde el plano indicado
  */
  public function getEstantesDesdeBibliotecaYPlano($idBiblioteca,$idPlano)
  {
    $biblioteca=Biblioteca::find($idBiblioteca);
    if($biblioteca!=null)
    {
      $plano=Plano::find($idPlano);
      if($plano!=null)
      {
        if($plano->id_biblioteca==$biblioteca->id)
        {
          $estantes=DB::table('estantes')->select()->where('id_plano','=',$plano->id)->get();
          return response()->json(['estantes'=>$estantes],200);
        }
        else {
          return response()->json(['Error'=>'El plano no pertenece a la biblioteca'],403);
        }
      }
      else {
        return response()->json(['Error'=>'No se encontró el plano'],404);
      }
    }
    else {
      return response()->json(['Error'=>'No se encontró la biblioteca'],404);
    }
  }
  /**
  * Agrega un nuevo estante
  * @param $request contenedor de parametros
  */
  public function agregarEstante(Request $request)
  {
    $this->validate($request, [
      'coorX'        => 'required | numeric| between:-500,500',
      'coorY' => 'required | numeric| between:-500,500',
      'ancho'=>'required | numeric| between:-500,500',
      'alto'=>'required | numeric| between:-500,500',
      'largo'=>'required | numeric| between:-500,500',
      'codigo'=>'required | string',
      'id_plano'=>'required|integer'
      ]);
      $estante=DB::table('estantes')->select()->where([['id_plano','=',$request->get('id_plano')],['codigo','=',$request->get('codigo')]])->get()->first();
      if($estante==null)
      {
        $input=$request->all();
        $estante=Estante::create($input);
        return response(['estante'=>$estante,'mensaje'=>'Estante agregado'],201);
      }
      else {
        return response([['El codigo para el estante ya se encuentra registrado']],400);

      }
    }
    /**
    * Mueve el estante a una coordenada en X y coordenada en Y
    * @param $request contenedor en donde viene la coordenada en X y coordenada en Y
    * @param $id identificador del estante a mover
    */
    public function moverEstante(Request $request,$id)
    {
      $this->validate($request, [
        'coorX'        => 'required | numeric| between:-500,500',
        'coorY' => 'required | numeric| between:-500,500',
        ]);
        $estante=Estante::find($id);
        if($estante!=null)
        {
          $input=$request->only('coorX','coorY');
          $estante->update($input);
          return response(['estante'=>$estante,'mensaje'=>'Estante actualizado'],200);
        }
        else {
          return response([['No se encontró el estante']],404);
        }
      }
      /**
      * Actualiza la información del estante
      * @param $request contenedor de la información del estante a eliminar
      * @param $id identificador del estante a actualizar
      */
      public function actualizarEstante(Request $request,$id)
      {

        $this->validate($request, [
          'coorX'        => 'required | numeric| between:-500,500',
          'coorY' => 'required | numeric| between:-500,500',
          'ancho'=>'required | numeric| between:-500,500',
          'alto'=>'required | numeric| between:-500,500',
          'largo'=>'required | numeric| between:-500,500',
          'codigo'=>'required | string',
          'id_plano'=>'required|integer'
          ]);
          $estante=Estante::find($id);
          if($estante!=null)
          {
            $input=$request->all();
            $estante->update($input);
            return response(['estante'=>$estante,'mensaje'=>'Estante actualizado'],200);
          }
          else {
            return response([['No se encontró el estante']],404);
          }
        }

        /**
        * Elimina un estante
        * @param $id el identificador del estante
        */
        public function eliminarEstante($id)
        {
          $estante=Estante::find($id);
          if($estante!=null)
          {
            $estante->delete();
            return response(['mensaje'=>'Estante eliminado']);
          }
          else {
            return response([['No se encontró el estante']],200);
          }
        }
      }
