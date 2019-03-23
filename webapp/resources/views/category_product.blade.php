<article class="tm-product-card uk-first-column">
    <div class="tm-product-card-media">
        <div class="tm-ratio tm-ratio-4-3">
            <a class="tm-media-box" href="/product/{{ $product->id }}">
                <figure class="tm-media-box-wrap"><img src="{{$product->thumbnail}}" alt="{{ $product->name }}"></figure>
            </a>
        </div>
    </div>
    <div class="tm-product-card-body">
        <div class="tm-product-card-info">
            <div class="uk-text-meta uk-margin-xsmall-bottom uk-text-uppercase">{{ $product->brand }}</div>
            <h3 class="tm-product-card-title"><a class="uk-link-heading uk-text-uppercase uk-text-emphasis" href="/product/{{ $product->id }}">{{ $product->name }}</a></h3>
            <ul class="uk-list uk-text-small tm-product-card-properties">
                {{ $product->short_description }}
            </ul>
        </div>
        <div class="tm-product-card-shop">
            <div class="tm-product-card-prices">
                <div class="tm-product-card-price" style="color:green;">${{ $product->price }} ARS</div>
            </div>
            <div class="tm-product-card-add">
                <div class="uk-text-meta tm-product-card-actions">
                <form action="/api/cart/edit/", method="POST">
                    <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                    <input type="hidden" name="action" value="add"/>
                    <button class="uk-button uk-button-primary tm-product-card-add-button tm-shine js-add-to-cart">
                      <span class="tm-product-card-add-button-icon uk-icon" uk-icon="cart" />
                      <span class="tm-product-card-add-button-text">Añadir al carro</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</article>