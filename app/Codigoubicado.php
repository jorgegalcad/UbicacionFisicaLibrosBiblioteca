<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigoubicado extends Model
{
  protected $fillable = [
  'coorX',
  'coorY',
  'id_codigo',
  'id_plano'
];
}
