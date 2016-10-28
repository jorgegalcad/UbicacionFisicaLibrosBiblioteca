@extends('layouts.home')

@section('content')
<div class="row">
  <div class="col s3 div-opciones-codigos">
    <h5 class="titulo-opciones">Opciones</h5>
    <div class="collection ">

      <a href="{{route('codigos.create')}}" class="collection-item indigo-text waves-effect waves-light"><i class="material-icons right">add</i>Agregar Código</a>
      <a href="{{route('codigos.index')}}" class="collection-item indigo-text waves-effect waves-light"><i class="material-icons right">view_list</i>Listar Códigos</a>
    </div>
  </div>
  <div class="col s9 div-opciones-codigos">
    @if($errors->any())
    <div class="card-panel red lighten-1">
      @foreach($errors->all() as $error)
      <p class="white-text">{{ $error }}</p>
      @endforeach
    </div>
    @endif
    @if(Session::has('flash_message'))
    <div class="card-panel teal lighten-2">
      <p class="white-text">  {{ Session::get('flash_message') }}</p>
    </div>
    @endif
  </br>
    <table class="striped responsive-table"  >
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
        @foreach($codigos as $codigo)
        <tr>
          <td>{!!$codigo->serial_identificador!!}</td>
          <td>{!!$codigo->contenido!!}</td>
          <td>Si</td>
          <td>{!!$codigo->created_at!!}</td>
          <td>
            <div class="row">
          {!! Form::open([
                'method' => 'DELETE',
                'route' => ['codigos.destroy', $codigo->id],'class'=>'form-delete'
                ]) !!}
                <a href="{{route('codigos.edit',$codigo->id)}}" class="btn-floating btn-large waves-effect
                waves-light indigo lighten-1"><i class="material-icons">edit</i>
              </a>
                <button class="btn-floating btn-large waves-effect
                 waves-light red lighten-1" type="submit"><i class="material-icons">delete</i>
               </button>
               {!! Form::close() !!}
        </div></td>
      </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop
