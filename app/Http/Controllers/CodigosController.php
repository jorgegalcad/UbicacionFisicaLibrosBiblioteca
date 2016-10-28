<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Biblioteca;
use App\Codigo;
use Session;
use Auth;
class CodigosController extends Controller
{
  /**
  * Obtiene los codigos registrados para una biblioteca que pertenece a un usuario
  */
  public function getCodigos()
  {
    $idUsuario=Auth::user()->id;
    $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();
    if($idBiblioteca!=null)
    {
      $codigos=DB::table('codigos')->select()->where('id_biblioteca','=',$idBiblioteca->id)->get();
      return response(['codigos'=>$codigos],200);
    }
    else {
      return response([['No se encontró la biblioteca']],404);
    }
  }
  /**
  * Obtiene el codigo a partir de la biblioteca y el codigo serial que tiene asociado
  * @param $idBiblioteca  identificador de la biblioteca
  * @param $serial  serial que identifica el codigo QR
  */
  public function getCodigoDesdeBibliotecaYSerial($idBiblioteca,$serial)
  {
    $biblioteca=Biblioteca::find($idBiblioteca);
    if($biblioteca!=null)
    {
      $codigo=DB::table('codigos')->select()->where([['id_biblioteca','=',$idBiblioteca],['serial_identificador','=',$serial]])->get()->first();
      if($codigo!=null)
      {
        return response()->json(['codigo'=>$codigo],200);
      }
      else {
        return response()->json(['Error'=>'No se encontró el codigo'],404);
      }
    }
    else {
      return response()->json(['Error'=>'No se encontró la biblioteca'],404);
    }
  }
  /**
  * Obtiene un código de identificacion de la biblioteca
  * @param serial   el serial a buscar
  */
  public function getCodigoIdentificacion($serial)
  {
    $codigosUbicados=DB::table('codigoubicados')->select('id_codigo')->get();
    $codigosUbicadosArray=array();
    foreach($codigosUbicados as $codigoU)
    {
      array_push($codigosUbicadosArray,$codigoU->id_codigo);
    }
    $codigo=DB::table('codigos')->select()->where([['serial_identificador','=',$serial],['id_usocodigo','=','1']])->whereIn('id',$codigosUbicadosArray)->get()->first();
    if($codigo!=null)
    {
      $biblioteca=Biblioteca::find($codigo->id_biblioteca);
      if($biblioteca!=null)
      {
        return response()->json(['codigo'=>$codigo,'biblioteca'=>$biblioteca],200);
      }
      else {
        return response()->json(['error'=>'No se encontró la biblioteca para el código QR'],404);
      }
    }
    else {
      return response()->json(['error'=>'No se encontró el código QR'],404);
    }
  }
  /**
  * Obtiene los codigos del usuario en sesion, que todavia no han sido usados
  *
  */
  public function getCodigosSinUso()
  {
    $idUsuario=Auth::user()->id;
    $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();
    if($idBiblioteca!=null)
    {
      $idPlanos=DB::table('planos')->select('id')->where('id_biblioteca','=',$idBiblioteca->id)->get();
      $idPlanosArray=array();
      foreach($idPlanos as $idPlano)
      {
        array_push($idPlanosArray,$idPlano->id);
      }
      if(count($idPlanosArray)>0)
      {
        $codigosUbicados=DB::table('codigoubicados')->select('id_codigo')->whereIn('id_plano',$idPlanosArray)->get();
        $codigosArray=array();
        foreach($codigosUbicados as $codigoU)
        {
          array_push($codigosArray,$codigoU->id_codigo);
        }
        $codigos=DB::table('codigos')->select()->where('id_biblioteca','=',$idBiblioteca->id)->whereNotIn('id',$codigosArray)->get();
        return response(['planos'=>$idPlanosArray,'codigos'=>$codigos],200);
      }
      else {
        return response(['error'=>'No se encontraron planos'],404);
      }
    }
    else {
      return response(['error'=>"No se encontró la biblioteca"],200);
    }

  }
  /**
  * Obtiene los usos de los codigos
  */
  private function getUsoCodigos()
  {
    $usocodigos=DB::table('usocodigos')->select()->get();
    return $usocodigos;
  }
  /**
  * Obtiene los codigos del usuario registrado en sesion
  */
  public function index()
  {
    $idUsuario=Auth::user()->id;
    $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();
    if($idBiblioteca!=null)
    {
      $codigos=DB::table('codigos')->select()->where('id_biblioteca','=',$idBiblioteca->id)->get();
      return view('codigos.listarCodigos',['codigos'=>$codigos]);
    }
    else {
      return redirect()->back()->withErrors("No se encontró biblioteca para el usuario");
    }
  }
  /**
  * Obtiene el formulario para crear
  */
  public function create()
  {
    $usocodigos=DB::table('usocodigos')->select()->get();
    return view('codigos.agregarCodigo',['usocodigos'=>$usocodigos]);
  }
  /**
  * Crea y Almacena un nuevo codigo
  * @param $request parametros para crear el codigo
  */
  public function store(Request $request)
  {
    $this->validate($request, [
      'serial_identificador'        => 'required | string| max:20|min:5',
      'contenido' => 'required | string| max:200|min:5',
      'id_usocodigo'=>'required | integer'
      ]);
      $idUsuario=Auth::user()->id;
      $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();
      if($idBiblioteca!=null)
      {
        $eval=$this->esAptoSerial($request,$idBiblioteca->id);
        if($eval!=null)
        {
          return $eval;
        }
        $codigo=new Codigo();
        $codigo->serial_identificador=$request->get('serial_identificador');
        $codigo->contenido=$request->get('contenido');
        $codigo->id_usocodigo=$request->get('id_usocodigo');
        $codigo->id_biblioteca=$idBiblioteca->id;
        $codigo->save();
        Session::flash('flash_message', 'Código registrado');
        return redirect()->back();
      }
      else {
        return redirect()->back()->withErrors("EL usuario no tiene biblioteca asociada");
      }

    }
    public function show($id)
    {
      return redirect()->back();
    }
    /**
    * Obtiene la vista para editar el código
    */
    public function edit($id)
    {
      $codigo=Codigo::find($id);
      if($codigo!=null)
      {
        $usocodigos=DB::table('usocodigos')->select()->get();
        return view('codigos.editarCodigo',['codigo'=>$codigo,'usocodigos'=>$usocodigos]);
      }
      else {
        return redirect()->back()->withErrors("No se encontró el código");
      }
    }
    /**
    * Actualiza un codigo en la base de datos
    * @param $request  parametros para actualizar el codigo
    * @param $id   el identificador del codigo
    */
    public function update(Request $request,$id)
    {
      $this->validate($request, [
        'serial_identificador'        => 'required | string| max:20|min:5',
        'contenido' => 'required | string| max:200|min:5',
        'id_usocodigo'=>'required | integer'
        ]);
      $codigo=Codigo::find($id);
      if($codigo!=null)
      {
        if($codigo->serial_identificador!=$request->get('serial_identificador') || $codigo->id_usocodigo!=$request->get('id_usocodigo'))
        {
          $eval=$this->esAptoSerial($request,$codigo->id_biblioteca);
          if($eval!=null)
          {
            return $eval;
          }
        }
        $data=$request->all();
        var_dump($data);
        $codigo->update($data);
        Session::flash('flash_message', 'Código actualizado');
        return redirect()->back();
      }
      else {
        return redirect()->back()->withErrors("El código no existe");
      }
    }
    /**
    * determina si el serial que se quiere asignar con uncodigo no posee
    * conflictos
    */
    private function esAptoSerial(Request $request,$idBiblioteca)
    {
      if($request->get('id_usocodigo')==2)
      {
        $codigos=DB::table('codigos')->select('serial_identificador')->where([['serial_identificador',
        '=',$request->get('serial_identificador')],['id_biblioteca','=',$idBiblioteca]])->first();
        if($codigos!=null)
        {
          return redirect()->back()->withErrors("El serial para el codigo ya se encuentra registrado");
        }
      }
      else {
        $codigos=DB::table('codigos')->select('serial_identificador')->where([['serial_identificador','=',$request->get('serial_identificador')],['id_usocodigo','=',1]])->first();
        if($codigos!=null)
        {
          return redirect()->back()->withErrors("El serial para identificar la biblioteca, ya se encuentra asignado");
        }
      }
      return null;
    }
    /**
    * Elimina un código
    * @param $id el identificador del código a eliminar
    */
    public function destroy($id)
    {
      $codigo=Codigo::find($id);
      if($codigo!=null)
      {
        $codigo->delete();
        Session::flash('flash_message', 'Código eliminado');
        return redirect()->back();
      }
      else {
        return redirect()->back()->withErrors("No se encontró el código");
      }
    }

  }
