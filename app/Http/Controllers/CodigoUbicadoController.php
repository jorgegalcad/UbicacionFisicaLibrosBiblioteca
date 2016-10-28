<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Codigoubicado;
use DB;
use App\Plano;
use App\Biblioteca;
use Auth;
class CodigoUbicadoController extends Controller
{
  /**
  * Obtiene los codigos del usuario en sesion
  */
  public function getCodigosUbicados()
  {
    $idUsuario=Auth::user()->id;
    $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();
    if($idBiblioteca!=null)
    {
      $idPlano=DB::table('planos')->select('id')->where('id_biblioteca','=',$idBiblioteca->id)->get()->first();
      if($idPlano!=null)
      {
        $codigos=DB::table('codigoubicados')->select()->where('id_plano','=',$idPlano->id)->get();
        return response(['codigos'=>$codigos],200);
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
  * Almacena un codigo ubicado
  * @param $request contenedor de parametros para crear el codigo ubicado
  */
  public function agregarCodigoUbicado(Request $request)
  {

    $this->validate($request, [
      'coorX'        => 'required | numeric| between:-500,500',
      'coorY' => 'required | numeric| between:-500,500',
      'id_codigo'=>'required | integer',
      'id_plano'=>'required|integer'
      ]);
    $idUsuario=Auth::user()->id;
    $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();

    if($idBiblioteca!=null)
    {


        /**  $planos=DB::table('planos')->select('id')->where('id_biblioteca','=',$idBiblioteca->id)->get();
        $planosArray=array();
        foreach($planos as $plano)
        {
        array_push($planosArray,$plano->id);
      }*/
      $codigo=DB::table('codigoubicados')->select()->where('id_codigo','=',$request->get('id_codigo'))->get()->first();
      if($codigo==null)
      {
        $input=$request->all();
        $codigo=Codigoubicado::create($input);
        return response(['codigo'=>$codigo,'mensaje'=>'Código agregado'],201);
      }
      else {
        return response([['El código QR ya se encuentra asignado']],400);

      }
    }
    else {
      return response([['No se encontró la biblioteca']],404);
    }
  }
  /**
  * Actualiza el codigo ubicado
  * @param $id   el identificador del codigo que se quiere actualizar
  * @param $request contenedor de los parametros para actualizar
  */
  public function actualizarCodigoUbicado(Request $request,$id)
  {
    $this->validate($request, [
      'coorX'        => 'required | numeric| between:-500,500',
      'coorY' => 'required | numeric| between:-500,500',
      ]);
      $codigoubicado=Codigoubicado::find($id);
      if($codigoubicado!=null)
      {
        $codigoubicado->coorX=$request->get('coorX');
        $codigoubicado->coorY=$request->get('coorY');
        $codigoubicado->save();
        return response(['codigo'=>$codigoubicado,'mensaje'=>'Código actualizado'],200);

      }
      else {
      return response([['No se encontró el código']],404);
      }
    }
    /**
    * Elimina un codigo en especifico
    * @param $id  identificador del codigo ubicado
    */
    public function eliminarCodigoUbicado($id)
    {
      $codigoubicado=Codigoubicado::find($id);
      if($codigoubicado!=null)
      {
          $codigoubicado->delete();
          return response(['mesaje'=>'Código eliminado'],200);
      }
      else {
          return response([['No se encontró el código']],404);
      }
    }
      /**
      * Obtiene los codigos ubicados para el plano que estan en determinada biblioteca
      * @param $idBiblioteca identificador de la biblioteca
      */
      public function getCodigosUbicadoDesdeBibliotecaYPlano($idBiblioteca,$idPlano)
      {
        $biblioteca=Biblioteca::find($idBiblioteca);
        if($biblioteca!=null)
        {
          $plano=Plano::find($idPlano);
          if($plano!=null)
          {
            if($plano->id_biblioteca==$biblioteca->id)
            {
              $codigos=DB::table('codigoubicados')->select()->where('id_plano','=',$plano->id)->get();
              return response()->json(['codigos'=>$codigos],200);
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

    }
