@extends('layouts.principal')

@section('content')

<div class="div-principal">

<script type="text/javascript" src="{!! asset('js/ejemplo.js') !!}"></script>
<button class="btn waves-effect waves-light right"  id="boton">Obtener
  <i class="material-icons right">send</i>
</button>
</br>
{{ csrf_field() }}
<!--<button class="btn waves-effect waves-light right"  id="agregar2">Agregar
  <i class="material-icons right">send</i>
</button>-->
@if($errors->any())
    <div class="alert alert-danger">
      @foreach($errors->all() as $error)
      <p>{{ $error }}</p>
      @endforeach
    </div>
    @endif
{!!Form::open(['url'=>'estantes/agregar','method'=>'POST'])!!}
  <input type="numeric" name="coorX"/>
<button class="btn waves-effect waves-light right" type="submit" id="agregar22">Agregar
  <i class="material-icons right">send</i>

</button>
{!!Form::close()!!}
</div>
</div>
<!-- Modal Structure -->
<div id="modalError" class="modal">
  <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">&times;</button>
</br>

<div class="modal-content">
  <h4>Error</h4>
  <div class="card-panel red lighten-1" id="diverror">This is a card panel with a teal lighten-2 class</div>

</div>
<div class="modal-footer">
  <button class="modal-close btn waves-effect waves-light  indigo darken-2" type="submit" name="actio">Aceptar

  </button>

</div>
</div>
@stop
