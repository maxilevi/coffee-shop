<div id="carouselExampleIndicators" class="carousel slide product-show box-shadow" data-ride="carousel">
  <ol class="carousel-indicators">
  	@for ($i = 0; $i < 3; $i++)
    	<li data-target="#carouselExampleIndicators" data-slide-to="{{ $i }}" {{ ($i == 0) ? 'class="active"' : '' }}></li>
    @endfor
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ $product->thumbnail }}" class="d-block w-100" alt="{{ $product->name }}">
    </div>
    <div class="carousel-item">
      <img src="{{ $product->thumbnail }}" class="d-block w-100" alt="{{ $product->name }}">
    </div>
    <div class="carousel-item">
      <img src="{{ $product->thumbnail }}" class="d-block w-100" alt="{{ $product->name }}">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>