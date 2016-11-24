@extends('layouts.home')

@section('content')

  <div class="input-field col s-12">
    <div class="input-field div-centrado">
      <h5>Registro Biblioteca</h5>
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
      <br></br>
      {!! Form::open(array('route' => 'bibliotecas.store','method'=>'post')) !!}
      <div class="row input-field">
        <i class="material-icons prefix">library_books</i>
        {!! Form::label('nombre', 'Nombre Biblioteca', ['class' => 'validate']) !!}
        {!! Form::text('nombre', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row input-field">
        <i class="material-icons prefix">language</i>
        {!! Form::label('pais', 'País', ['class' => 'validate']) !!}
        {!! Form::text('pais', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row input-field">
        <i class="material-icons prefix">my_location</i>
        {!! Form::label('departamento', 'Departamento', ['class' => 'validate']) !!}
        {!! Form::text('departamento', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row input-field">
        <i class="material-icons prefix">room</i>
        {!! Form::label('municipio', 'Municipio', ['class' => 'validate']) !!}
        {!! Form::text('municipio', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row input-field">
        <i class="material-icons prefix">navigation</i>
        {!! Form::label('direccion', 'Dirección', ['class' => 'validate']) !!}
        {!! Form::text('direccion', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row">
        <button class="btn waves-effect waves-light right" type="submit" name="action">Registrar
          <i class="material-icons right">send</i>
        </button>
      </div>
  {!! Form::close() !!}
    </div>

  </div>
@stop
