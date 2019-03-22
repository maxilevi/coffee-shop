<section class="uk-card-header">
	<div style="margin: 6px;">
		<h1 class="uk-h2">Pedido<a class="uk-link-heading" href="/shipment/{{ $shipment->id }}">  #{{ $shipment->id }}</a></h1>
		<span class="uk-text-muted uk-text-small">{{ $shipment->date }}</span>
	</div>
</section>
<section class="uk-card-body">
    <table class="uk-table uk-table-small uk-table-justify uk-table-responsive uk-table-divider uk-margin-small-top uk-margin-remove-bottom">
        <tbody>
            <tr>
                <th class="uk-width-medium">Productos</th>
                <td>{{ count($shipment->products) }}</td>
            </tr>
            <tr>
                <th class="uk-width-medium">Envío</th>
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