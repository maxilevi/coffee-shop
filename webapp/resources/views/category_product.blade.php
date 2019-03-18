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
      <h4 class="uk-margin-remove-bottom">{{ $product->name }}</h4>
      <p class="desc">{{ $product->short_description }}</p>
    </div>
    <div class="uk-card-footer">
      <span class="uk-align-left price subtext">${{ $product->price }}</span>
      <span class="uk-align-right subtext">250gr</span>
    </div>
  </div>
  </a>
</div>
<!-- item -->