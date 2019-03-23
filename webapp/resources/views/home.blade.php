@section('styles')
<link rel="stylesheet" href="/css/home.css"/>
@endsection
@section('banner')
Nuestra Selección
@endsection
@include('layouts.header')

<!-- CONTENT -->
<div class="uk-grid-margin uk-first-column">
	<div class="uk-container">
		<div class="uk-grid-collapse uk-child-width-1-4 tm-products-grid js-products-grid uk-grid uk-grid-stack" uk-grid="">
			@each('category_product', $top_products, 'product')
		</div>
	</div>
</div>
@include('layouts.footer')