<section class="uk-card-body">
    <h3><a class="uk-link-heading" href="/shipment/{{$id}}">#{{ $shipment->id }}<span class="uk-text-muted uk-text-small">{{ $shipment->date }}</span></a></h3>
    <table class="uk-table uk-table-small uk-table-justify uk-table-responsive uk-table-divider uk-margin-small-top uk-margin-remove-bottom">
        <tbody>
            <tr>
                <th class="uk-width-medium">Products</th>
                <td>{{ count($shipment->products) }}</td>
            </tr>
            <tr>
                <th class="uk-width-medium">Shipping</th>
                <td>Envío a domicilio</td>
            </tr>
            <tr>
                <th class="uk-width-medium">Forma de pago</th>
                <td>MercadoPago</td>
            </tr>
            <tr>
                <th class="uk-width-medium">Total</th>
                <td>${{ $shipment->price }}</td>
            </tr>
            <tr>
                <th class="uk-width-medium">Estado</th>
                <td><span class="uk-label {{ (($shipment->status == 'cancel') ? 'uk-label-danger' : ( ($shipment->status == 'success') ? 'uk-label-success' : '')) }}">{{ $shipment->statusMessage }}</span></td>
            </tr>
        </tbody>
    </table>
</section>