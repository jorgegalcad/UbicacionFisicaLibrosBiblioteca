<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estante extends Model
{
  protected $fillable = [
  'coorX',
  'coorY',
  'ancho',
  'alto',
  'largo',
  'codigo',
  'id_plano'
];
}
