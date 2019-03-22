<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css" />
	</head>
	<body>
		<h3>Hola,</h3>
		<span>¡Gracias por tu compra en OUTLET DE CAFÉ!</span>
		<br>
		<p>
		El pagó fue confirmado y el pedido esta en camino.
		Podes consultar el estado de tu pedido <a href="{{ $shippingUrl }}">acá</a>
		</p>

		<span>¡Muchas Gracias!</span>
		<hr>
		<span>Links:</span><br>
		<ul>
			<li>{{ $shippingUrl }}</li>
		</ul>
	</body>
</html>