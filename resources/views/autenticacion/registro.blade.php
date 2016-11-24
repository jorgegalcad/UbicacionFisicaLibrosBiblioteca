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
      <i class="material-icons prefix">perm_identity</i>
      {!! Form::label('nombres', 'Nombres', ['class' => 'validate']) !!}
      {!! Form::text('nombres', null, ['class' => 'validate','required'=>'required']) !!}
    </div>
    <div class="row input-field">
      <i class="material-icons prefix">perm_identity</i>
      {!! Form::label('apellidos', 'Apellidos', ['class' => 'validate']) !!}
      {!! Form::text('apellidos', null, ['class' => 'validate','required'=>'required']) !!}
    </div>
    <div class="row input-field">
      <i class="material-icons prefix">contact_phone</i>
      {!! Form::label('telefono', 'Telefono', ['class' => 'validate']) !!}
      {!! Form::text('telefono', null, ['class' => 'validate','required'=>'required']) !!}
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
