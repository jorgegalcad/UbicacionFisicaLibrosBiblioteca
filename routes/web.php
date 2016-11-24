<?php
//use Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/ejemplo',function()
{
$qrcode=QrCode::format('png');
$qrcode->size(800)->generate(1,public_path('/codigos_qr/ejemplo.png'));
});
Route::group(['middleware'=>['estaAutenticado']],function(){
///estantes
Route::get('/bibliotecas/{id}/estantes','EstantesController@getEstantes');
Route::post('/estantes','EstantesController@agregarEstante');
Route::get('/', function () {
  return view('home.home');
});
Route::get('/codigos/download/{id}',['as'=>'descargarCodigo' ,function($id)
{
  $file = public_path('codigos_qr').'/'.$id.'.png'; // or wherever you have stored your PDF files
  if(File::exists($file))
  {
    return response()->download($file);
  }
  else {
    return redirect()->back()->withErrors("El archivo no se encontró");
  }
}]);
Route::put('/estantes/{estante}','EstantesController@actualizarEstante');
Route::put('/estantes/{estante}/posicion','EstantesController@moverEstante');
Route::delete('/estantes/{estante}','EstantesController@eliminarEstante');

//codigos

Route::get('/bibliotecas/{id}/codigossinuso','CodigosController@getCodigosSinUso');
Route::resource('/codigos','CodigosController');
Route::resource('/bibliotecas','BibliotecasController');
//codigos ubicados
Route::get('/bibliotecas/{id}/codigosubicados','CodigoUbicadoController@getCodigosUbicados');
Route::post('/codigosubicados','CodigoUbicadoController@agregarCodigoUbicado');
Route::put('/codigosubicados/{codigo}','CodigoUbicadoController@actualizarCodigoUbicado');
Route::delete('/codigosubicados/{codigo}','CodigoUbicadoController@eliminarCodigoUbicado');
//home
Route::get('/home',['as'=>'home',function()
{
  return view('home.home');
}]);
//Ventana para la visualización de la biblioteca virtual
Route::get('/bibliotecaVirtual/{id}',['as'=>'bibliotecaVirtual','uses'=>'BibliotecasController@getBibliotecaVirtual']);
Route::get('/logout',['as'=>'logout','uses'=>'LoginController@logout']);

});
//////////////////////////////////////////////////////////
//Ventana principal sin logueo
Route::get('/principal',['as'=>'principal',function()
{
  return view('principal');
}]);
//Ventana de registro
Route::get('/usuarios/biblioteca/create','UsersController@getVistaRegistrarse');
Route::post('/usuarios/biblioteca/store',['as'=>'crearUsuario','uses'=>'UsersController@registrarse']);
Route::post('/login','LoginController@login');
