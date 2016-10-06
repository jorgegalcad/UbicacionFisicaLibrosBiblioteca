<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link href="{!! asset('css/materialize.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('css/aplicacion.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteca Virtual</title>
</head>
<body>
  <nav class="indigo darken-2">
    <div class="nav-wrapper">
      <img src="{!! asset('images/Biblioteca.jpg') !!}" class="brand-logo logo"></img>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#modalIniciarSesion" class="waves-effect waves-light  modal-trigger">Inicar Sesión</a></li>
        <li><a href="{{route('registro')}}"  class="waves-effect waves-light">Registrarse</a></li>
      </ul>
    </div>
  </nav>


  <section>
    <!-- Espacio para el contenido de la página -->

    <article >
      @yield('content')
    </article>
  </section>
  <footer class="page-footer indigo">
    <div class="container tamanio-subfooter ">

    </div>
    <div class="footer-copyright indigo darken-2">
      <div class="container alineacion-copyright indigo darken-2">
        © 2016 Copyright Text
      </div>
    </div>
  </footer>
  <!-- Modal Structure -->
  <div id="modalIniciarSesion" class="modal">
    <button class="modal-close btn-flat" style="position:absolute;top:0;right:0;">&times;</button>
        {!! Form::open(array('route' => 'home','method'=>'post','class'=>'col s12')) !!}
    <div class="modal-content">
      <div class=""><center><img class="circle" src="{!! asset('images/perfil.png') !!}" /></center></div>
      <div class="row">

          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">account_circle</i>
              {!! Form::label('email', 'Correo', ['class' => 'validate']) !!}
              {!! Form::email('email', null, ['class' => 'validate']) !!}
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">vpn_key</i>
              {!! Form::label('password_', 'Contraseña') !!}
              {!! Form::password('password_',null,['class' => 'validate'])!!}
            </div>
          </div>
      </div>

    </div>
    <div class="modal-footer">
      <button class="btn waves-effect waves-light  indigo darken-2" type="submit" name="actio">Iniciar Sesión
        <i class="material-icons right">input</i>
      </button>

    <!--  <button class="btn waves-effect waves-light modal-close indigo" type="submit" name="action">Cerrar
        <i class="material-icons right">not_interested</i>
      </button>-->
  {!! Form::close() !!}
    </div>
  </div>
  <script type="text/javascript" src="{!! asset('js/jquery-3.1.0.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/registro.js') !!}"></script>
</body>

</html>
