<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Biblioteca;
use App\Plano;
class BibliotecasController extends Controller
{
  /**
  * Crea y almacena una nueva biblioteca
  * @param $request   parametros para crear la biblioteca
  * @param $idUser   el identificador del usuario asociado a la biblioteca
  */
    public function store(Request $request,$idUser)
    {
      $data=$request->all();
      $data['id_user']=$idUser;
      $biblioteca=Biblioteca::create($data);
      $plano=new Plano();
      $plano->nivel=1;
      $plano->id_biblioteca=$biblioteca->id;
      $plano->save();
      return $biblioteca;
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
}
