@extends('layouts.home')

@section('content')
<div class="row">
  <div class="col s3 div-opciones-biblioteca">
    <div class="row">

      <div class="chip titulo-opciones" >
         <span id="operacion" class="operacion">Sin operación</span>
        <i class="close material-icons prefix" id="icon">info_outline</i>
      </div>
    </div>
    <h5 class="titulo-opciones">Opciones</h5>
    <ul class="collapsible collapsible-accordion" >
      <li>
        <a  class="collapsible-header indigo-text waves-effect waves-teal" ><i class="material-icons right">add</i>Agregar</a>
        <div class="collapsible-body">
          <div class="collection">
            <a class=" collection-item indigo-text waves-effect waves-light" id="agregarEstante" >Agregar Estante<i class="material-icons right">add</i></a>
            <a class="collection-item indigo-text waves-effect waves-light" id="agregarCodigo" >Agregar código<i class="material-icons right">add</i></a>
          </div>
        </div>
      </li>
      <li>
        <a  class="collapsible-header indigo-text waves-effect waves-teal" id="mover"><i class="material-icons right">edit</i>Mover</a>
      </li>
      <li>
        <a  class="collapsible-header indigo-text waves-effect waves-teal" id="editar"><i class="material-icons right">edit</i>Editar</a>
      </li>
      <li>
        <a class="collapsible-header indigo-text waves-effect waves-teal" id="eliminar"><i class="material-icons right">delete</i>Eliminar</a>
      </li>
    </ul>
  </div>
  <div class="col s9 " >
    <svg class="cols s9 div-plano" id="divPlano">

    </svg>
  </div>
</div>
<div id="modalEstante" class="modal">
  <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">&times;</button>
  <div class="modal-content">
    <h5>Agregar Estante</h5>
    <div class="row">

      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">my_location</i>

          <input type="number" id="coorXEstante" name="coorXEstante" step=0.01 class="validate"/>
          <label for="coorXEstante">Coordenada en X</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">my_location</i>
          {!! Form::label('coorYEstante', 'Coordenada en Y') !!}
          <input type="number" id="coorYEstante" name="coorYEstante" step=0.01 class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">input</i>
          {!! Form::label('ancho', 'Ancho') !!}
          <input type="number" id="ancho" name="ancho" class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">launch</i>
          {!! Form::label('alto', 'Alto') !!}
          <input type="number" id="alto" name="ancho" class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">system_update_alt</i>
          {!! Form::label('largo', 'Largo') !!}
          <input type="number" id="largo" name="largo" class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">code</i>
          {!! Form::label('codigo', 'Código') !!}
          <input type="text" id="codigo" name="codigo" class="validate"/>
        </div>
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <button class="btn waves-effect waves-light  indigo darken-2" type="submit" name="agregarE" id="agregarE">Agregar
      <i class="material-icons right">add</i>
    </button>
  </div>
</div>
<div id="modalCodigo" class="modal">
  <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">&times;</button>
  <div class="modal-content">
    <h5>Agregar Código</h5>
    <div class="row">

      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">my_location</i>

          <input type="number" id="coorXCodigo" name="coorXCodigo" step=0.01 class="validate"/>
          <label for="coorXCodigo">Coordenada en X</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">my_location</i>
          {!! Form::label('coorYCodigo', 'Coordenada en Y') !!}
          <input type="number" id="coorYCodigo" name="coorYCodigo" step=0.01 class="validate"/>
        </div>
      </div>
      <div class="row input-field">
        <i class="material-icons prefix">settings</i>
        {!! Form::select('uso', array('1' => 'Código 1', '2' => 'Código 2'), '2') !!}
        {!! Form::label('uso', 'Uso del código', ['class' => 'validate']) !!}
      </div>
      <div class="row">
      </div>

    </div>
    <div class="modal-footer">
      <button class="btn waves-effect waves-light  indigo darken-2" type="submit" name="agregarC" id="agregarC">Agregar
        <i class="material-icons right">add</i>
      </button>
    </div>
  </div>
  <!-- <a class="btn dropdown-button" href="#!" data-activates="dropdown2">Menu Desplegable<i class="mdi-navigation-arrow-drop-down right"></i></a>-->
  <script type="text/javascript" src="{!! asset('js/bibliotecaVirtual.js') !!}"></script>
  @stop
