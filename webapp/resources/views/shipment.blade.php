@section('styles')
<link rel="stylesheet" href="/css/shipment.css">
@endsection
@section('banner')
Estado del envío
@endsection
@include('layouts.header')

<div class="uk-container">
	<div class="uk-width-1-1 uk-width-expand@m uk-grid-margin uk-first-column">
		<form action="/api/shipment/find" method="GET">
			<br>
			@php
				$shouldDisable = $searchId != 0 && count($shipments) != 0;
			@endphp
			<div class="uk-margin uk-text-center">
		    	<input class="uk-input uk-width-1-2@m" type="text" name="shipmentId" placeholder="Código de envío" value="{{ $searchId != 0 ? $searchId : '' }}" {{ ($shouldDisable) ? 'disabled' : '' }}>
		    	<button class="uk-button uk-width-1-3@m uk-button-primary tm-shine" {{ ($shouldDisable) ? 'disabled' : '' }}>Buscar</button>
			</div>
		</form>
		<hr>
	    <div class="uk-card uk-card-default uk-card-small tm-ignore-container">
	    	@each('shipment_order', $shipments, 'shipment', 'shipment_empty')
	    </div>
	    <br>
	</div>
</div>
@section('scripts')
<script>
var state = '{{ $state }}';
var success_message = "<span uk-icon='icon: check'></span> El pedido fue creado con exíto.";
var failure_message = "<span uk-icon='icon: ban'></span> No hemos podido confirmar el pago. Si esto es un error contactate con soporte.";
if (state != null && state != '')
{
	UIkit.notification({
	    message: state == 'success' ? success_message : failure_message,
	    status: state == 'success' ? 'success' : 'danger',
	    pos: 'top-center',
	    timeout: 5000
	});
}
</script>
@endsection
@include('layouts.footer')