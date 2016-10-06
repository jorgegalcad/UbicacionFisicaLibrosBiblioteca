@extends('layouts.home')

@section('content')
<div class="row">
  <div class="col s3 div-opciones-codigos">
    <h5 class="titulo-opciones">Opciones</h5>
    <div class="collection ">

      <a href="{{route('agregarCodigo')}}" class="collection-item indigo-text waves-effect waves-light"><i class="material-icons right">add</i>Agregar Código</a>
      <a href="#!" class="collection-item indigo-text waves-effect waves-light"><i class="material-icons right">view_list</i>Listar Códigos</a>
    </div>
  </div>
  <div class="col s9 div-opciones-codigos">
    <table class="striped">
      <thead>
        <tr>
          <th data-field="serial">Serial</th>
          <th data-field="contenido">Contenido</th>
          <th data-field="asignado">Asignado</th>
          <th data-field="fecha_regsitro">Fecha registro</th>
          <th data-field="Opciones">Opciones</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td>203125</td>
          <td>Entrada de la biblioteca</td>
          <td>Si</td>
          <td>21/09/2016</td>
          <td><div class="row"><a href="{{route('editarCodigo')}}" class="btn-floating btn-large waves-effect
            waves-light indigo lighten-1"><i class="material-icons">edit</i>
          </a> <a class="btn-floating btn-large waves-effect
            waves-light red lighten-1"><i class="material-icons">delete</i>
          </a></div></td>
        </tr>
        <tr>
          <td>203125</td>
          <td>Al lado de recepcion</td>
          <td>No</td>
          <td>21/09/2016</td>
          <td><div class="row"><a href="{{route('editarCodigo')}}" class="btn-floating btn-large waves-effect
            waves-light indigo lighten-1"><i class="material-icons">edit</i>
          </a> <a class="btn-floating btn-large waves-effect
            waves-light red lighten-1"><i class="material-icons">delete</i>
          </a></div></td>
        </tr>
        <tr>
          <td>203125</td>
          <td>Al lado de recepcion</td>
          <td>No</td>
          <td>21/09/2016</td>
          <td><div class="row"><a href="{{route('editarCodigo')}}" class="btn-floating btn-large waves-effect
            waves-light indigo lighten-1"><i class="material-icons">edit</i>
          </a> <a class="btn-floating btn-large waves-effect
            waves-light red lighten-1"><i class="material-icons">delete</i>
          </a></div></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@stop
