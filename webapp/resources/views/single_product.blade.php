@section('styles')
<link rel="stylesheet" href="/css/single_product.css"/>
@endsection
@include('layouts.header')

@php
$images = json_decode($product->images, true);
@endphp
<div class="background">
    <main>
        <section class="uk-section uk-section-small">
            <div class="uk-container">
                <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                    <div class="uk-text-center">
                        
                    </div>
                    <div>
                        <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                            <div>
                                <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                    <div class="uk-grid-small uk-grid-collapse uk-grid-match" uk-grid>
                                        <div class="uk-width-1-1 uk-width-expand@m">
                                            <div class="uk-grid-collapse uk-child-width-1-1" uk-slideshow="finite: true; ratio: 4:3;" uk-grid>
                                                <div>
                                                    <ul class="uk-slideshow-items" uk-lightbox>
                                                    @php
                                                        foreach($images as $image) {
                                                            echo View::make('single_product_slide_image', ['image' => $image, 'product' => $product]);
                                                        }
                                                     @endphp
                                                    </ul>
                                                </div>
                                                <div>
                                                    <div class="uk-card-body uk-flex uk-flex-center">
                                                        <div class="uk-width-1-2 uk-visible@s">
                                                            <div uk-slider="finite: true">
                                                                <div class="uk-position-relative">
                                                                    <div class="uk-slider-container">
                                                                        <ul class="tm-slider-items uk-slider-items uk-child-width-1-4 uk-grid uk-grid-small">
                                                                        @php
                                                                            foreach($images as $image) {
                                                                                echo View::make('single_product_small_slide_image', ['image' => $image, 'product' => $product]);
                                                                            }
                                                                        @endphp
                                                                        </ul>
                                                                        <div>
                                                                            <a class="uk-position-center-left-out uk-position-small" href="#" uk-slider-item="previous" uk-slidenav-previous></a>
                                                                            <a class="uk-position-center-right-out uk-position-small" href="#" uk-slider-item="next" uk-slidenav-next></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="uk-slideshow-nav uk-dotnav uk-hidden@s"></ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 uk-width-1-3@m tm-product-info">
                                            <div class="uk-card-body">
                                                <h1 class="uk-margin-small-top uk-margin-remove-bottom uk-text-uppercase uk-text-emphasis uk-text-bold">{{ $product->name }}</h1>
                                                <p>{{ $product->short_description }}</p>
                                                <span class=" uk-text-emphasis uk-text uk-text-bold" style="margin-right:20px;">Cantidad:</span>
                                                <br>
                                                <select class="uk-select style-select input" disabled>
                                                    <option value="0">1/4 Kilo</option>
                                                    <option value="1">1/2 Kilo</option>
                                                    <option value="2">1 Kilo</option>
                                                </select>
                                                <br>
                                                <div class="uk-margin">
                                                    <div class="uk-padding-small uk-background-primary-lighten uk-border-rounded">
                                                        <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                                                            <div>
                                                                <div class="uk-text-meta">Precio</div>
                                                                <div class="tm-product-price">${{ $product->price }}</div>
                                                            </div>
                                                            <div>
                                                                <div class="uk-grid-small" uk-grid>
                                                                    <div>
                                                                        <a disabled onclick="increment(-1, 'product-1')" uk-icon="icon: minus; ratio: .75"></a>
                                                                        <input disabled class="uk-input tm-quantity-input" id="product-1" type="text" maxlength="3" value="1"/>
                                                                        <a disabled onclick="increment(+1, 'product-1')" uk-icon="icon: plus; ratio: .75"></a>
                                                                    </div>
                                                                    <div>
                                                                        <form action="/api/cart/edit/", method="POST">
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                                                                            <input type="hidden" name="action" value="add"/>
                                                                            <button type="submit" class="uk-button uk-button-primary tm-product-add-button tm-shine">Añadir al carro</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-margin">
                                                    <div class="uk-padding-small uk-background-muted uk-border-rounded">
                                                        <div class="uk-grid-small uk-child-width-1-1 uk-text-small" uk-grid>
                                                            <div>
                                                                <div class="uk-grid-collapse" uk-grid>
                                                                    <span class="uk-margin-xsmall-right" uk-icon="credit-card"></span>
                                                                    <div>
                                                                        <div class="uk-text-bolder">Pagá a traves de MercadoPago</div>
                                                                        <div class="uk-text-xsmall uk-text-muted">Aceptamos VISA, MasterCard y tarjetas locales</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="uk-grid-collapse" uk-grid>
                                                                    <span class="uk-margin-xsmall-right" uk-icon="cart"></span>
                                                                    <div>
                                                                        <div class="uk-text-bolder">Envío a domicilio</div>
                                                                        <div class="uk-text-xsmall uk-text-muted">A tráves de MercadoEnvíos</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1 tm-product-description" id="description">
                                            <div class="uk-card-body">
                                                <section style="padding:10px;">
                                                    <h3 class="uk-text-lead uk-text-uppercase" style="margin-bottom:20px;">Carácteristicas</h3>
                                                    <article class="uk-article">
                                                        <div class="text-muted" style="font-size:16px;">
                                                        @php
                                                         echo implode("<br>", explode("\n", trim($product->long_description)));
                                                        @endphp
                                                        </div>
                                                    </article>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </section>
    </main>
    <div class="uk-container background">
        <hr>
        <h2 class="uk-text-emphasis uk-text-bold uk-text-uppercase">Productos Similares</h2>
        <div class="uk-grid uk-grid-small uk-child-width-1-2 uk-child-width-1-3@m uk-child-width-1-4@l uk-grid-match" data-uk-lightbox="toggle:a.uk-position-cover" data-uk-grid>
            @each('similar_product', $top_products, 'product')
        </div>
    </div>
    <hr>
</div>
@include('layouts.footer')