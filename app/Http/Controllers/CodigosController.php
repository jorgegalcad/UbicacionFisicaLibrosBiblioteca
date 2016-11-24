<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Biblioteca;
use App\Codigo;
use App\Codigoubicado;
use App\Plano;
use Session;
use Auth;
use File;
use QrCode;
class CodigosController extends Controller
{

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
  public function getCodigosSinUso($idBiblioteca)
  {
    /**$idUsuario=Auth::user()->id;
    $idBiblioteca=DB::table('bibliotecas')->select('id')->where('id_user','=',$idUsuario)->get()->first();
    if($idBiblioteca!=null)
    {*/
    $idPlanos=DB::table('planos')->select('id')->where('id_biblioteca','=',$idBiblioteca)->get();
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
      $codigos=DB::table('codigos')->select()->where('id_biblioteca','=',$idBiblioteca)->whereNotIn('id',$codigosArray)->get();
      return response(['planos'=>$idPlanosArray,'codigos'=>$codigos],200);
    }
    else {
      return response(['error'=>'No se encontraron planos'],404);
    }
    /**  }
    else {
    return response(['error'=>"No se encontró la biblioteca"],200);
  }*/

}
/**
* Obtiene el codigo QR a partir de la lectura
* @param $id el identificador del codigo
* @return una respuesta json, con cuatro objetos, un objeto codigo, un objeto biblioteca
* un objeto plano, y la ubicación del codigo
*/
public function getCodigo($id)
{
  $codigo=Codigo::find($id);
  if($codigo!=null)
  {
    $codigoUbicado=Codigoubicado::where('id_codigo','=',$codigo->id)->get()->first();
    if($codigoUbicado!=null)
    {
      $plano=Plano::find($codigoUbicado->id_plano);
      $biblioteca=Biblioteca::find($codigo->id_biblioteca);
      return response()->json(['codigo'=>$codigo,'biblioteca'=>$biblioteca,'codigoUbicado'=>$codigoUbicado,'plano'=>$plano],200);
    }
    else {
      return response()->json(['Error'=>'El código no esta ubicado'],404);

    }
  }
  else {
    return response()->json(['Error'=>'No se encontró el código'],404);
  }
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
  $bibliotecas=Biblioteca::where('id_user','=',Auth::user()->id)->get();
  return view('codigos.agregarCodigo',['bibliotecas'=>$bibliotecas]);
}
/**
* Crea y Almacena un nuevo codigo
* @param $request parametros para crear el codigo
*/
public function store(Request $request)
{
  $this->validate($request, [
    'contenido' => 'required | string| max:200|min:5',
    'id_biblioteca'=>'required|integer'
    ]);
    $idBiblioteca=$request->get('id_biblioteca');

    $codigo=new Codigo();
    $codigo->contenido=$request->get('contenido');
    $codigo->id_biblioteca=$idBiblioteca;
    $codigo->save();
    $qrcode=QrCode::format('png');
    $qrcode->size(800)->generate($codigo->id,public_path('/codigos_qr/'.$codigo->id.'.png'));
    $codigo->imagen='/codigos_qr/'.$codigo->id.'.png';
    $codigo->update();
    Session::flash('flash_message', 'Código registrado');
    return redirect()->back();

  }
  public function show($id)
  {
    $codigo=Codigo::find($id);
    if($codigo!=null)
    {
      return view('codigos.verCodigo',['codigo'=>$codigo]);
    }
    else {
      return redirect()->back()->withErrors("No se encontró el código");
    }

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
      'contenido' => 'required | string| max:200|min:5',
      ]);
      $codigo=Codigo::find($id);
      if($codigo!=null)
      {
        $data=$request->all();
        $codigo->update($data);
        Session::flash('flash_message', 'Código actualizado');
        return redirect()->back();
      }
      else {
        return redirect()->back()->withErrors("El código no existe");
      }
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
        File::delete(public_path().$codigo->imagen);
        $codigo->delete();
        Session::flash('flash_message', 'Código eliminado');
        return redirect()->back();
      }
      else {
        return redirect()->back()->withErrors("No se encontró el código");
      }
    }

  }
