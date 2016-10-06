<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link href="{!! asset('css/materialize.css') !!}" media="all" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{!! asset('js/materialize.js') !!}"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteca Virtual</title>
</head>
<body>

  <nav>
    <div class="nav-wrapper ">
      <a href="#!" class="brand-logo indigo">Logo</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Sass</a></li>
        <li><a href="#">Components</a></li>
        <li><a href="#">Javascript</a></li>
        <li><a href="#">Mobile</a></li>
      </ul>

    </div>
  </nav>

  <section>
    <!-- Espacio para el contenido de la página -->

    <article >
      @yield('content')
    </article>
  </section>
</body>
</html>
