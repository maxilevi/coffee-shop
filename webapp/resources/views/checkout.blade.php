@section('styles')
<link rel="stylesheet" href="/css/checkout.css">
@endsection
@section('banner')
CHECKOUT
@endsection
@include('layouts.header')


<div class="uk-offcanvas-content">
    <main>
        <section class="uk-section uk-section-small">
            <div class="uk-container">
                <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                    <section>
                        <div class="uk-grid-medium" uk-grid>
                            <form class="uk-form-stacked uk-width-1-1 tm-checkout uk-width-expand@m" action="/api/process_payment" method="POST" id="payment_form">
                                <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                                    <section>
                                        <h2 class="tm-checkout-title uk-text-bold">INFORMACION DE CONTACTO</h2>
                                        <div class="uk-card uk-card-default uk-card-small uk-card-body tm-ignore-container">
                                            <div class="uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s" uk-grid>
                                                <div>
                                                    <label>
                                                        <div class="uk-form-label uk-form-label-required">Nombre</div>
                                                        <input name="name" class="uk-input" type="text" required>
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <div class="uk-form-label uk-form-label-required">Apellido</div>
                                                        <input name="surname" class="uk-input" type="text" required>
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <div class="uk-form-label uk-form-label-required">Telefono</div>
                                                        <input name="phone" class="uk-input" type="tel" required>
                                                    </label>
                                                </div>
                                                <div>
                                                    <label>
                                                        <div class="uk-form-label uk-form-label-required">Email</div>
                                                        <input name="email" class="uk-input" type="email" required>
                                                    </label>
                                                </div>
                                                <div class="uk-width-1-1 uk-text-meta">Esta informacíon solo es usada para efectuar la compra y no es almacenada. <a href="/privacidad">Más informacion</a></div>
                                            </div>
                                        </div>
                                    </section>
                                    <section>
                                        <h2 class="tm-checkout-title uk-text-bold">ENVIO</h2>
                                        <div class="uk-card uk-card-default uk-card-small uk-card-body tm-ignore-container">
                                            <div class="uk-grid-small uk-grid-match uk-child-width-1-1 uk-child-width-1-3@s uk-flex-center" uk-switcher="toggle: &gt; * &gt; .tm-choose" uk-grid>
                                                <div>
                                                </div>
                                            </div>
                                            <div class="uk-switcher uk-margin"> 
                                                <section>
                                                    <div class="uk-grid-small" uk-grid>
                                                        <div class="uk-width-1-1">
                                                            <label>
                                                                <div class="uk-form-label uk-form-label-required">Calle</div>
                                                                <input name="street" class="uk-input" type="text" placeholder="Av. Libertador" required>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="uk-grid-small" uk-grid>
                                                        <div class="uk-width-1-4 uk-width-1-6@s">
                                                            <label>
                                                                <div class="uk-form-label uk-form-label-required">Altura</div>
                                                                <input name="street_number" class="uk-input" type="number" placeholder="123" required>
                                                            </label>
                                                        </div>
                                                        <div class="uk-width-1-4 uk-width-1-6@s">
                                                            <label>
                                                                <div class="uk-form-label-required">Piso</div>
                                                                <input name="floor" class="uk-input" type="text" placeholder="2" required >
                                                            </label>
                                                        </div>
                                                        <div class="uk-width-1-4 uk-width-1-6@s">
                                                            <label>
                                                                <div class="uk-form-label-required">Departamento</div>
                                                                <input name="apartment" class="uk-input" type="text" placeholder="N/A" required>
                                                            </label>
                                                        </div>
                                                        <div class="uk-width-1-4 uk-width-1-6@s">
                                                            <label>
                                                                <div class="uk-form-label-required">Código postal</div>
                                                                <input name="zip_code" class="uk-input" type="number" placeholder="1425" required>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="uk-grid-small uk-child-width-1-3 uk-child-width-1-4@s" uk-grid>
                                                        <div>
                                                            <label>
                                                                <div class="uk-form-label-required">País</div>
                                                                <input name="country" class="uk-input" type="text" value="Argentina" disabled required>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div style="margin-top: 20px;">
                                                        <div class="uk-width-1-1 uk-text-meta">Esta informacíon solo es usada para efectuar el envío y no es almacenada. <a href="/privacidad">Más informacion</a></div>
                                                    </div>
                                                </section>
                                                <div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <section>
                                        <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
                                            <div class="uk-card-body">
                                                <div class="uk-flex-center">
                                                    <img src="https://imgmp.mlstatic.com/org-img/banners/ar/medios/785X40.jpg" title="MercadoPago - Medios de pago" alt="MercadoPago - Medios de pago" width="785" height="40"/>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <input id="hidden-submit-button" type="submit" style="display:none" />
                            </form>
                            <div class="uk-width-1-1 uk-width-1-4@m tm-aside-column">
                                <div class="uk-card uk-card-default uk-card-small tm-ignore-container" uk-sticky="offset: 30; bottom: true; media: @m;">
                                    <section class="uk-card-body">
                                        <h4>Productos</h4>
                                        @each('checkout_side_item', $products, 'product')
                                    </section>
                                    <section class="uk-card-body">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-expand">
                                                <div class="uk-text-muted">Subtotal</div>
                                            </div>
                                            <div class="uk-text-right">
                                                <div id="subtotal"></div>
                                            </div>
                                        </div>
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-expand">
                                                <div class="uk-text-muted">Descuento</div>
                                            </div>
                                            <div class="uk-text-right">
                                                <div class="uk-text-danger" id="discount"></div>
                                            </div>
                                        </div>
                                    </section>
                                    <section class="uk-card-body">
                                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                                            <div class="uk-width-expand">
                                                <div class="uk-text-muted">Total</div>
                                            </div>
                                            <div class="uk-text-right">
                                                <div class="uk-text-lead uk-text-bolder" id="total"></div>
                                            </div>
                                        </div>
                                        <button type="submit" form="payment_form" onclick="document.getElementById('hidden-submit-button')" class="uk-button uk-button-primary uk-margin-small uk-width-1-1">SIGUIENTE</button>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </main>
</div>
@section('scripts')
@include('cart_script', ['products' => $products])
@endsection
@include('layouts.footer')
