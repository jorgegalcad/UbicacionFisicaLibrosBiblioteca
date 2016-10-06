<?php

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

Route::get('/', function () {
    return view('principal');
});
//Ventana principal sin logueo
Route::get('/principal',['as'=>'principal',function()
{
  return view('principal');
}]);
//Ventana de registro
Route::get('/registro',['as'=>'registro',function()
{
  return view('autenticacion.registro');
}]);
//home
Route::get('/home',['as'=>'home',function()
{
  return view('home.home');
}]);
//home con post
Route::post('/home',['as'=>'home',function()
{
  return view('home.home');
}]);
//Ventana para la visualización de la biblioteca virtual
Route::get('/bibliotecaVirtual',['as'=>'bibliotecaVirtual', function()
{
  return view('home.bibliotecaVirtual');
}]);
//Ventana para agregar un codigo
Route::get('/codigos/agregar',['as'=>'agregarCodigo',function()
{
  return view('codigos.agregarCodigo');
}]);
//Ventana para agregar un codigo post
Route::post('/codigos/agregar',['as'=>'agregarCodigo',function()
{
  return view('codigos.agregarCodigo');
}]);
//Ventana para listar los codigos
Route::get('/codigos/listar',['as'=>'listarCodigos',function()
{
  return view('codigos.listarCodigos');
}]);
Route::get('/codigos/editar',['as'=>'editarCodigo',function()
{
  return view('codigos.editarCodigo');
}]);
