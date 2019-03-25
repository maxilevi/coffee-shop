<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="google-site-verification" content="yXVNbGUeBCwZfdhNWkzWSwKEgGMepYgZxB6z8IgQ0ko" />
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-55659525-11"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-55659525-11');
  </script>
  <script>
    var state = false;
    function handleMenu() {
      if (state) closeMenu();
      else openMenu();
    }
    function openMenu() {
      var oldParent = document.getElementById('collapsed-menu'); 
      var newParent = document.getElementById('menu-placer');
      while (oldParent.childNodes.length > 0) {
          newParent.appendChild(oldParent.childNodes[0]);
      }
      state = true;
    }
    function closeMenu() {
      var oldParent = document.getElementById('menu-placer'); 
      var newParent = document.getElementById('collapsed-menu');
      while (oldParent.childNodes.length > 0) {
          newParent.appendChild(oldParent.childNodes[0]);
      }
      state = false;
    }
  </script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="description" content="Venta de cafe premium y en granos. Perfecto para los amantes del café. Envío a domicilio.">
  <meta name="tags" content="cafe premium, cafe en grano, cafeteria, envio a domicilio, ecommerce, bonafide, cafe martinez, juan valdez, havanna">
  <title>OUTLET DE CAFÉ</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
  @yield('styles')
  <link rel="stylesheet" href="/css/product.css" />
  <link rel="stylesheet" href="/css/header.css" />
  <link rel="icon" type="image/png" href="/img/coffee.png" />
</head>
<header>
  <div class="uk-container">
    <nav class="uk-navbar-container uk-navbar navbar" uk-navbar>
      <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo uk-text-lead logo" href="/">
        <img src="/img/coffee.png" width="40" height="auto"><span class="uk-text-bold uk-text-emphasis logo-text">OUTLET DE CAFÉ</span></img></a>
      </div>
      <button type="button" class="navbar-toggle uk-hidden@m" onclick="handleMenu();">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
      </button>
      <div class="uk-navbar-center toggle-target collapsed">
        <ul class="uk-navbar-nav nav-text" id="collapsed-menu">
          <li class="uk-active"><a href="/">Inicio</a></li>
          <li>
            <a href="#">Categorías <span data-uk-icon="icon: triangle-down"></span></a>
            <div class="uk-navbar-dropdown">
              <ul class="uk-nav uk-navbar-dropdown-nav">
                @php
                  use App\Product;
                  $brands = json_decode(Product::getBrands(), true);
                  foreach($brands as $brandArray) {
                    $brand = $brandArray['brand'];
                    $encodedBrand = urlencode($brand);
                    echo "<li><a href=\"/?brand={$encodedBrand}\">{$brand}</a></li>";
                  }
                @endphp
              </ul>
            </div>
          </li>
          <li><a href="/">Más Vendidos</a></li>
          <li><a href="/shipment">Estado del envío</a></li>
          <li><a href="/contact">Contacto</a></li>
        </ul>
      </div>
      <div class="uk-navbar-right toggle-target">
        <a href="/cart/" uk-icon="cart" class="uk-icon">
        @php
          use App\Http\Controllers\CartController;
          $itemCount = count(CartController::getItems());
          if ($itemCount > 0) echo "<span class=\"uk-badge cart-number\">{$itemCount}</span>";
        @endphp
        </a>
      </div>
    </nav>
  </div>
</header>
<body>
<div id="menu-placer" class="menu-placer uk-text-uppercase uk-text-meta">
</div>
<div class="uk-height-large uk-background-cover uk-light uk-flex cover-img" uk-parallax="bgy: -50">
    <h1 class="uk-width-1-2@b uk-text-center uk-margin-auto uk-margin-auto-vertical uk-text-uppercase banner-title uk-text-bold">@yield('banner')</h1>
</div>