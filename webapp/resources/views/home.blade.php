@section('styles')
<link rel="stylesheet" href="/css/home.css"/>
@endsection
@section('banner')
Nuestra Selección
@endsection
@include('layouts.header')

<!-- CONTENT -->
<section class="uk-section uk-section-muted background">
	<div class="uk-container">
		<div class="uk-grid uk-grid-small uk-child-width-1-2 uk-child-width-1-3@m uk-child-width-1-4@l uk-grid-match" data-uk-lightbox="toggle:a.uk-position-cover" data-uk-grid>
			@each('category_product', $top_products, 'product')
		</div>
	</div>
</section>
@include('layouts.footer')