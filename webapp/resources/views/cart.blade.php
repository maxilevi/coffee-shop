@section('styles')
<link rel="stylesheet" href="/css/cart.css">
@endsection
@section('banner')
Carro de compras
@endsection
@include('layouts.header')

<div class="uk-offcanvas-content">
<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                <div>
                    <div class="uk-grid-medium" uk-grid>
                        <div class="uk-width-1-1 uk-width-expand@m">
                            <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                <header class="uk-card-header uk-text-uppercase uk-text-muted uk-text-center uk-text-small uk-visible@m">
                                    <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                                        <div>producto</div>
                                        <div>
                                            <div class="uk-grid-small uk-child-width-expand" uk-grid>
                                                <div>precio</div>
                                                <div class="tm-quantity-column">cantidad</div>
                                                <div>valor</div>
                                                <div class="uk-width-auto">
                                                    <div style="width: 20px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </header>
                                @each('cart_product', $products, 'product')
                                <div class="uk-card-footer">
                                    <label>
                                        <span class="uk-form-label uk-margin-small-right">Código de descuento:</span>
                                        <div class="uk-inline">
                                            <a class="uk-form-icon uk-form-icon-flip" href="#" uk-icon="arrow-right"></a>
                                            <input class="uk-input uk-form-width-small" type="text">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1 tm-aside-column uk-width-1-4@m">
                            <div class="uk-card uk-card-default uk-card-small tm-ignore-container" uk-sticky="offset: 30; bottom: true; media: @m;">
                                <div class="uk-card-body">
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand uk-text-muted">Subtotal</div>
                                        <div id="subtotal"></div>
                                    </div>
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-expand uk-text-muted">Descuento</div>
                                        <div id="discount" class="uk-text-danger"></div>
                                    </div>
                                </div>
                                <div class="uk-card-body">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-expand uk-text-muted">Total</div>
                                        <div id="total" class="uk-text-lead uk-text-bolder"></div>
                                    </div>
                                    <a class="uk-button uk-button-primary uk-margin-small uk-width-1-1" href="/checkout/">Pagar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
</div>
@section('scripts')
<script type="text/javascript">
@php
    echo 'var products = '. json_encode(array_values($products)) . ';';
@endphp

function refresh() {
    var subtotal = 0.0;
    var discount = 0.0;
    for(var i = 0; i < products.length; ++i) {
        subtotal += products[i].value;
    }
    document.getElementById('subtotal').innerText = '$' + subtotal;
    document.getElementById('discount').innerText = '-$' + discount;
    document.getElementById('total').innerText = '$' + (subtotal - discount);
}
refresh();
</script>
@endsection
@include('layouts.footer')