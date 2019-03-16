<!-- item -->
<div>
<a href="/product/{{ $product->id }}">
  <div class="uk-card uk-card-default uk-card-small uk-card-hover">
  <div class="uk-card-badge uk-label brand">{{ $product->brand }}</div>
  <div class="uk-card-header">
    <div class="uk-card-media-top">
      <div class="uk-inline-clip uk-transition-toggle uk-light">
        <img src="{{$product->thumbnail}}">
      </div>
    </div>
    </div>
    <div class="uk-card-body">
      <h4 class="uk-margin-remove-bottom uk-text-uppercase">{{ $product->name }}</h4>
    </div>
  </div>
  </a>
</div>
<!-- item -->