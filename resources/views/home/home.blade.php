@extends('layouts.home')

@section('content')
<div class="div-principal">
  @if($errors->any())
  <div class="card-panel red lighten-1">
    @foreach($errors->all() as $error)
    <p class="white-text">{{ $error }}</p>
    @endforeach
  </div>
  @endif
</div>
@stop
