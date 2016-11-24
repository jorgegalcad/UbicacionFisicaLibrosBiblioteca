@extends('layouts.home')

@section('content')
<div class="input-field col s6">
  <div class="input-field">

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
    <div>
        <h5>Detalles Codigo</h5>
        <br></br>
    </div>
     <div class="col s6">
       <ul class="collapsible" data-collapsible="accordion">
         <li>
           <div class="collapsible-header"><i class="material-icons">code</i>Serial</div>
           <div class="collapsible-body"><p>{!!$codigo->id!!}</p></div>
         </li>
         <li>
           <div class="collapsible-header"><span class="badge"></span><i class="material-icons">chat_bubble_outline</i>Contenido</div>
           <div class="collapsible-body"><p>{!!$codigo->contenido!!}</p></div>
         </li>
         <li>
           <div class="collapsible-header"><span class="badge"></span><i class="material-icons">description</i>Codigo QR</div>
           <div class="collapsible-body"><a href="{!!route('descargarCodigo',$codigo->id)!!}"><img src="{!!asset($codigo->imagen)!!}"/></a></div>
         </li>
         <li>
           <div class="collapsible-header"><span class="badge"></span><i class="material-icons">schedule</i>Fecha creación</div>
           <div class="collapsible-body"><p>{!!$codigo->created_at!!}</p></div>
         </li>
       </ul>
     </div>
  </div>

</div>
@stop
