<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Biblioteca extends Model
{
  protected $fillable = [
  'nombre',
  'pais',
  'departamento',
  'municipio',
  'direccion',
  'id_user'
];
}
