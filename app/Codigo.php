<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
  protected $fillable = [
  'serial_identificador',
  'contenido',
  'id_usocodigo',
];
}
