@extends('layouts.principal')

@section('content')

  <div class="input-field col s-12">
    <div class="input-field div-centrado">
      <h5>Registro</h5>
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
      <div class="row col s3">
        <p>Ya tienes cuenta? <a href="#modalIniciarSesion" class="waves-effect waves-light  modal-trigger">Inicia sesión aquí</a> </p>
      </div>
      {!! Form::open(array('route' => 'crearUsuario','method'=>'post')) !!}
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
      <div class="row input-field">
        <i class="material-icons prefix">email</i>
        {!! Form::label('email', 'Correo', ['class' => 'validate']) !!}
        {!! Form::email('email', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row input-field">
        <i class="material-icons prefix">vpn_key</i>
        {!! Form::label('password', 'Contraseña', ['class' => 'validate']) !!}
        {!! Form::password('password', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row input-field">
        <i class="material-icons prefix">vpn_key</i>
        {!! Form::label('confirm_passw', 'Confirmar Contraseña', ['class' => 'validate']) !!}
        {!! Form::password('confirm_passw', null, ['class' => 'validate','required'=>'required']) !!}
      </div>
      <div class="row">
        <button class="btn waves-effect waves-light right" type="submit" name="action">Registrarse
          <i class="material-icons right">send</i>
        </button>
      </div>
  {!! Form::close() !!}
    </div>

  </div>
@stop
