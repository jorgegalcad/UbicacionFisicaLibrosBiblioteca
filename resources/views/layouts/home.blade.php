<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link href="{!! asset('css/materialize.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="{!! asset('css/aplicacion.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script type="text/javascript" src="{!! asset('js/jquery-3.1.0.min.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
  <script type="text/javascript" src="{!! asset('js/home.js') !!}"></script>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteca Virtual</title>
</head>
<body>
  <nav class="indigo darken-2">
    <div class="nav-wrapper">
      <img src="{!! asset('images/Biblioteca.jpg') !!}" class="brand-logo logo"></img>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="{{route('home')}}" class="waves-effect waves-light  modal-trigger">Home</a></li>
        <li><a href="{{route('bibliotecas.index')}}" class="waves-effect waves-light">Bibliotecas</a></li>
        <li><a href="{{route('codigos.index')}}" class="waves-effect waves-light">Códigos QR</a></li>
        <li><a class="dropdown-button perfil" href="#!" data-activates="dropdown1">
          <img id="imgP"src="{!! asset('images/perfil.png') !!}" alt="" class="circle foto-perfil right"></a></li>
        </ul>
      </div>
    </nav>
    <!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content cerrar-sesion">
      <li><a href="{{route('logout')}}">Cerrar sesión</a></li>
    </ul>

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



  </body>

  </html>
