<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
Route::get('/bibliotecas/codigos/{serial}','CodigosController@getCodigoIdentificacion');
Route::get('/bibliotecas/{biblioteca}/planos','BibliotecasController@getPlanosBiblioteca');
Route::get('/bibliotecas/{biblioteca}/planos/{plano}/estantes','EstantesController@getEstantesDesdeBibliotecaYPlano');
Route::get('/bibliotecas/{biblioteca}/planos/{plano}/codigosubicados','CodigoUbicadoController@getCodigosUbicadoDesdeBibliotecaYPlano');
Route::get('/bibliotecas/{biblioteca}/codigos/{serial}','CodigosController@getCodigoDesdeBibliotecaYSerial');
