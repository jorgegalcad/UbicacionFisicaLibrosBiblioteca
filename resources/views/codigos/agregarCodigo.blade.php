@extends('layouts.home')

@section('content')
<div class="row">
  <div class="col s3 div-opciones-codigos">
    <h5 class="titulo-opciones">Opciones</h5>
    <div class="collection ">

      <a href="{{route('agregarCodigo')}}" class="collection-item indigo-text waves-effect waves-light"><i class="material-icons right">add</i>Agregar Código</a>
      <a href="{{route('listarCodigos')}}" class="collection-item indigo-text waves-effect waves-light"><i class="material-icons right">view_list</i>Listar Códigos</a>
    </div>
  </div>
  <div class="col s6 div-opciones-codigos">
    <h5>Agregar Código</h5>
    <br>
    {!! Form::open(array('route' => 'agregarCodigo','method'=>'post')) !!}
    <div class="row input-field">
      <i class="material-icons prefix">code_qr</i>
      {!! Form::label('serial', 'Serial', ['class' => 'validate']) !!}
      {!! Form::text('serial', null, ['class' => 'validate']) !!}
    </div>
    <div class="row input-field">
      <i class="material-icons prefix">chat_bubble_outline</i>
      {!! Form::label('contenido', 'Contenido', ['class' => 'validate']) !!}
      {!! Form::textarea('contenido',null,['class'=>'materialize-textarea validate']) !!}
    </div>
    <div class="row input-field">
      <i class="material-icons prefix">settings</i>
      {!! Form::select('uso', array('1' => 'Identificación biblioteca', '2' => 'Ubicación usuario'), '2') !!}
      {!! Form::label('uso', 'Uso del código', ['class' => 'validate']) !!}
    </div>
    <div class="row">
      <button class="btn waves-effect waves-light right" type="submit" name="action">Agregar
        <i class="material-icons right">send</i>
      </button>
    </div>
    {!! Form::close() !!}
  </div>
</div>


@stop
