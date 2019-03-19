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