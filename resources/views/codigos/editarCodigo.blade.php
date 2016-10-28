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
  <div class="col s6 div-opciones-codigos">
    <h5>Editar Código</h5>
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
    <br>
    {!! Form::model($codigo, [
    'method' => 'PUT',
    'route' => ['codigos.update', $codigo->id]
    ]) !!}
    <div class="row input-field">
      <i class="material-icons prefix">code_qr</i>
      {!! Form::label('serial_identificador', 'Serial', ['class' => 'validate']) !!}
      {!! Form::text('serial_identificador', null, ['class' => 'validate']) !!}
    </div>
    <div class="row input-field">
      <i class="material-icons prefix">chat_bubble_outline</i>
      {!! Form::label('contenido', 'Contenido', ['class' => 'validate']) !!}
      {!! Form::textarea('contenido',null,['class'=>'materialize-textarea validate']) !!}
    </div>
    <div class="row input-field">
      <i class="material-icons prefix">settings</i>
      <select name="id_usocodigo" id="id_usocodigo">
        @foreach($usocodigos as $uso)
        <option value="{!!$uso->id!!}">{!!$uso->nombre!!}</option>
        @endforeach
      </select>
             {!! Form::label('id_usocodigo', 'Uso del código', ['class' => 'validate']) !!}
    </div>
    <div class="row">
      <button class="btn waves-effect waves-light right" type="submit" name="action">Actualizar
        <i class="material-icons right">system_update_alt</i>
      </button>
    </div>
    {!! Form::close() !!}
  </div>
</div>


@stop
