<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <title>OUTLET DE CAFÉ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
  <link rel="stylesheet" href="/css/product.css" />
  @yield('styles')
</head>
<header>
  <div class="uk-container">
    <nav class="uk-navbar-container uk-navbar-transparent" uk-navbar>
      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo uk-text-lead" href="/">OUTLET DE CAFÉ</a>
      </div>
      <div class="uk-navbar-center uk-visible@m">
        <ul class="uk-navbar-nav">
          <li class="uk-active"><a href="/">Inicio</a></li>
          <li>
            <a href="#">Categorías <span data-uk-icon="icon: triangle-down"></span></a>
            <div class="uk-navbar-dropdown">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                <li><a href="/?brand=bonafide">Bonafide</a></li>
              </ul>
            </div>
          </li>
          <li><a href="/">Más Vendidos</a></li>
        </ul>
      </div>
    </nav>
  </div>
</header>
<body>