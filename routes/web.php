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
Route::group(['middleware'=>['estaAutenticado']],function(){
///estantes
Route::get('/estantes','EstantesController@getEstantes');
Route::post('/estantes','EstantesController@agregarEstante');
Route::get('/', function () {
  return view('home.home');
});
Route::put('/estantes/{estante}','EstantesController@actualizarEstante');
Route::put('/estantes/{estante}/posicion','EstantesController@moverEstante');
Route::delete('/estantes/{estante}','EstantesController@eliminarEstante');

//codigos

Route::get('/codigossinuso','CodigosController@getCodigosSinUso');
Route::resource('/codigos','CodigosController');
//codigos ubicados
Route::get('/codigosubicados','CodigoUbicadoController@getCodigosUbicados');
Route::post('/codigosubicados','CodigoUbicadoController@agregarCodigoUbicado');
Route::put('/codigosubicados/{codigo}','CodigoUbicadoController@actualizarCodigoUbicado');
Route::delete('/codigosubicados/{codigo}','CodigoUbicadoController@eliminarCodigoUbicado');
//home
Route::get('/home',['as'=>'home',function()
{
  return view('home.home');
}]);
//Ventana para la visualización de la biblioteca virtual
Route::get('/bibliotecaVirtual',['as'=>'bibliotecaVirtual', function()
{
  return view('home.bibliotecaVirtual');
}]);
Route::get('/logout',['as'=>'logout','uses'=>'LoginController@logout']);

});
//////////////////////////////////////////////////////////
//Ventana principal sin logueo
Route::get('/principal',['as'=>'principal',function()
{
  return view('principal');
}]);
//Ventana de registro
Route::get('/usuarios/create','UsersController@create');
Route::post('/usuarios/store',['as'=>'crearUsuario','uses'=>'UsersController@store']);
Route::post('/login','LoginController@login');
