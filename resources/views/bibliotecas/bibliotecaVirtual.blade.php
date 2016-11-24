@extends('layouts.home')

@section('content')
<div class="row" id="row">
  <link href="{!!asset('/css/loading.css')!!}" rel="stylesheet">
  <meta name="base_url" content="{{ URL::to('/') }}">
  <div class="col s3 div-opciones-biblioteca" id="opciones">
    <input type="hidden" value="{!!$biblioteca->id!!}" name="id_biblioteca" id="id_biblioteca">
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
      <li>
        <a class="collapsible-header indigo-text waves-effect waves-teal" id="habilitar" ><i class="material-icons right" id="icon-hab">visibility_off</i><span id="valorH">Deshabilitar zoom</span></a>
      </li>
    </ul>
    {{ csrf_field() }}
  </div>
  <div class="col s9" id="div-plano">
    <!--  <svg class="cols s9 div-plano" id="divPlano">

  </svg>-->
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
          <input type="number" id="alto" name="alto" class="validate"/>
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
        <select name="usoS" id="usoS">
        <option>Holaaa</option></select>
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
</div>
<div id="modalEstanteAct" class="modal">
  <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">&times;</button>
  <div class="modal-content">
    <h5>Actualizar Estante</h5>
    <div class="row">

      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">my_location</i>

          <input type="number" id="coorXEstanteAct" name="coorXEstanteAct" step=0.01 class="validate"/>
          <label for="coorXEstanteAct">Coordenada en X</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">my_location</i>
          {!! Form::label('coorYEstanteAct', 'Coordenada en Y') !!}
          <input type="number" id="coorYEstanteAct" name="coorYEstanteAct" step=0.01 class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">input</i>
          {!! Form::label('anchoAct', 'Ancho') !!}
          <input type="number" id="anchoAct" name="anchoAct" class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">launch</i>
          {!! Form::label('altoAct', 'Alto') !!}
          <input type="number" id="altoAct" name="altoAct" class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">system_update_alt</i>
          {!! Form::label('largoAct', 'Largo') !!}
          <input type="number" id="largoAct" name="largoAct" class="validate"/>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">code</i>
          {!! Form::label('codigoAct', 'Código') !!}
          <input type="text" id="codigoAct" name="codigoAct" class="validate"/>
        </div>
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <button class="btn waves-effect waves-light  indigo darken-2" type="submit" name="actualizarE" id="actualizarE">Actualizar
      <i class="material-icons right">system_update_alt</i>
    </button>
  </div>

</div>
<div id="modalError" class="modal">
  <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">&times;</button>
</br>

<div class="modal-content">
  <h4>Error</h4>
  <div class="card-panel red lighten-1" id="diverror"></div>

</div>
<div class="modal-footer">
  <button class="modal-close btn waves-effect waves-light  indigo darken-2" type="submit" name="actio">Aceptar

  </button>

</div>
</div>
  <!--  <script type="text/javascript" src="{!! asset('js/bibliotecaVirtual.js') !!}"></script>-->
  <script src="{!!asset('js/three/build/three.min.js')!!}"></script>
  <script src="{!!asset('js/three/js/renderers/Projector.js')!!}"></script>
  <script src="{!!asset('js/three/js/renderers/CanvasRenderer.js')!!}"></script>
  <script src="{!!asset('js/three/js/controls/OrbitControls.js')!!}"></script>
  <script src="{!!asset('js/three/js/controls/TrackballControls.js')!!}"></script>
  <script src="{!!asset('js/three/js/libs/dat.gui.min.js')!!}"></script>
  <script src="{!!asset('js/three/js/libs/stats.min.js')!!}"></script>
  <script src="{!!asset('js/three/js/threex.dynamictexture.js')!!}"></script>
  <script src="{!!asset('js/loading.js')!!}"></script>
  <script src="{!!asset('js/notify.min.js')!!}"></script>
  <script src="{!!asset('js/bibliotecaVirtual2.js')!!}"></script>
  @stop
