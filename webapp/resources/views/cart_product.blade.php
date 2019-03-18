<div class="uk-card-body">
    <div class="uk-grid-small uk-child-width-1-1 uk-child-width-1-2@m uk-flex-middle" uk-grid>
        <!-- Product cell-->
        <div>
            <div class="uk-grid-small" uk-grid>
                <div class="uk-width-1-3">
                    <div class="tm-ratio tm-ratio-4-3">
                        <a class="tm-media-box" href="/product/{{ $product->id }}">
                            <figure class="tm-media-box-wrap">
                                <img src="{{ $product->thumbnail }}" alt="{{ $product->name }}">
                            </figure>
                        </a>
                    </div>
                </div>
                <div class="uk-width-expand">
                    <div class="uk-text-meta">{{ $product->brand }}</div>
                    <a class="uk-link-heading uk-text-bold uk-text-up" href="/product/{{ $product->id }}">{{ $product->name }}</a>
                </div>
            </div>
        </div>
        <!-- Other cells-->
        <div>
            <div class="uk-grid-small uk-child-width-1-1 uk-child-width-expand@s uk-text-center" uk-grid>
                <div>
                    <div class="uk-text-muted uk-hidden@m">Precio</div>
                    <div class="uk-text-emphasis">${{ $product->price }}</div>
                </div>
                <div class="tm-cart-quantity-column">
                    <!-- <a onclick="increment(-1, 'product-1')" uk-icon="icon: minus; ratio: .75"></a> -->
                    <input class="uk-input tm-quantity-input" id="product-1" type="text" maxlength="3" value="1" disabled />
                    <!-- <a onclick="increment(+1, 'product-1')" uk-icon="icon: plus; ratio: .75"></a> -->
                </div>
                <div>
                    <div class="uk-text-muted uk-hidden@m">Valor</div>
                    <div class="uk-text-emphasis">${{ $product->value }}</div>
                </div>
                <div class="uk-width-auto@s">
                <form action="">
                </form>
                <form action="/api/cart/edit/", method="POST">
                    <input type="hidden" name="product_id" value="{{ $product->id }}"/>
                    <input type="hidden" name="action" value="remove"/>
                    <button id="remove-{{ $product->id }}" type="submit" style="display: none;"></button>
                </form>
                    <a onclick="document.getElementById('remove-{{ $product->id }}').click()" class="uk-text-danger" uk-tooltip="Remover">
                        <span uk-icon="close"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>