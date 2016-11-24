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
        <h5>Detalles Biblioteca</h5>
        <br></br>
    </div>
     <div class="col s6">
       <ul class="collapsible" data-collapsible="accordion">
         <li>
           <div class="collapsible-header"><i class="material-icons">library_books</i>Nombre</div>
           <div class="collapsible-body"><p>{!!$biblioteca->nombre!!}</p></div>
         </li>
         <li>
           <div class="collapsible-header"><span class="badge">1</span><i class="material-icons">language</i>País</div>
           <div class="collapsible-body"><p>{!!$biblioteca->pais!!}</p></div>
         </li>
         <li>
           <div class="collapsible-header"><span class="badge">1</span><i class="material-icons">my_location</i>Departamento</div>
           <div class="collapsible-body"><p>{!!$biblioteca->departamento!!}</p></div>
         </li>
         <li>
           <div class="collapsible-header"><span class="badge">1</span><i class="material-icons">room</i>Municipio</div>
           <div class="collapsible-body"><p>{!!$biblioteca->municipio!!}</p></div>
         </li>
         <li>
           <div class="collapsible-header"><span class="badge">1</span><i class="material-icons">navigation</i>Dirección</div>
           <div class="collapsible-body"><p>{!!$biblioteca->direccion!!}</p></div>
         </li>
       </ul>
     </div>
  </div>

</div>
@stop
