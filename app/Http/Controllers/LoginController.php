<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
class LoginController extends Controller
{
  public function login(Request $request)
  {

    if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
      return response(['mensaje'=>'Autenticado'],200);
    }
    else {
      return response([['Datos incorrectos']],403);
    }
  }
  public function logout()
  {
    Auth::logout();
    return redirect()->route('principal');
  }
}
