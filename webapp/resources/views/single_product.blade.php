@section('styles')
<link rel="stylesheet" href="/css/single_product.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.27.5/css/components/slider.min.css"/>
@endsection
@include('layouts.header')
<section class="uk-section background">
	<div class="uk-container uk-box-shadow-small container">
			<div uk-grid class="uk-child-width-expand">
				<div class="slideshow">
				@php
					$firstImage = json_decode($product->images, true)[0];
					list($_, $height) = getimagesize($firstImage);
					echo "<div uk-slideshow=\"min-height: {$height}; max-height: {$height}\">";
				@endphp
					    <ul class="uk-slideshow-items">
					    	@php
					        	$images = json_decode($product->images, true);
					        	foreach($images as $image) {
					        		echo "<li><img src=\"{$image}\" alt=\"{$product->name}\" uk-cover></li>";
					        		echo "<li><img src=\"{$image}\" alt=\"{$product->name}\" uk-cover></li>";
					        	}
					        @endphp
					    </ul>
					</div>
				</div>
				<div class="uk-container form-container">
					<div class="uk-flex-inline uk-flex-middle">
					<h1 class="uk-text-emphasis uk-text-uppercase uk-text-bold">{{ $product->name }}</h1>
					<div class="uk-label slide-brand">{{ $product->brand }}</div>
					</div>
					<h1 class="uk-text-emphasis uk-text-uppercase" style="margin-top:0px;">${{ $product->price }}</h1>
					<p class="uk-text-meta">{{ $product->description }}</p>
					<hr>
					<form>
						<span class="label uk-text-uppercase uk-text-emphasis">CORTE</span>
						<br>
					    <select class="uk-select style-select input" id="cut-type">
					    @php
				        	$cuts = json_decode($product->cuts, true);
				        	foreach($cuts as $type) {
				        		echo "<option value=\"{$type}\">{$type}</option>";
				        	}
				        @endphp
					    </select>
					    <br>
					    <span class="label uk-text-uppercase uk-text-emphasis" >Peso</span>
					    <br>
					    <select class="uk-select style-select input" id="weight">
					    	<option>1/4 Kilo</option>
					    	<option>1/2 Kilo</option>
					    	<option>1 Kilo</option>
					    </select>
					    <br>
				    	<span class="label uk-text-uppercase uk-text-emphasis">Cantidad</span>
				    	<br>
				    	<input class="uk-input quantity input" type="number" id="amount" value="1"></input>
					    <br>
					    <button class="uk-button uk-button-primary buy-btn ">Comprar ahora</button>
					    <button class="uk-button uk-button-default buy-btn">Agregrar al carrito</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="uk-container similar-products">
		<h2 class="uk-text-emphasis uk-text-uppercase uk-text-bold">Productos Similares</h2>
		<div class="uk-grid uk-grid-small uk-child-width-1-2 uk-child-width-1-3@m uk-child-width-1-4@l uk-grid-match" data-uk-lightbox="toggle:a.uk-position-cover" data-uk-grid>
			@each('similar_product', $top_products, 'product')
		</div>
	</div>
</section>
@include('layouts.footer')