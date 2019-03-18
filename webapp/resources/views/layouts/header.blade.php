<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="description" content="Venta de cafe premium y en granos. Envío a domicilio.">
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
        <a class="uk-navbar-item uk-logo uk-text-lead" href="/">
        <img src="/img/coffee.png" width="40" height="auto"><span class="uk-text-bold uk-text-emphasis" style="font-size:20px;">OUTLET DE CAFÉ</span></img></a>
      </div>
      <div class="uk-navbar-center uk-visible@m">
        <ul class="uk-navbar-nav">
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
        </ul>
      </div>
      <div class="uk-navbar-right">
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
<div class="uk-height-large uk-background-cover uk-light uk-flex cover-img" uk-parallax="bgy: -50">
    <h1 class="uk-width-1-2@b uk-text-center uk-margin-auto uk-margin-auto-vertical uk-text-uppercase banner-title">@yield('banner')</h1>
</div>