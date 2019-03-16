@section('styles')
<link rel="stylesheet" href="/css/category.css">
@endsection

@include('layouts.header')
<main role="main">
  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">{{ __('category.' . $category . '_name') }}</h1>
      <p class="lead text-muted">{{ __('category.' . $category . '_desc') }}</p>
      <p>
      <form action="./{{ $current_page }}" method="GET">
        <div class="btn-group" role="group" aria-label="Basic example">
          <button href="" class="btn btn{{ $gender != '' ? '-outline' : '' }}-primary my-2" name="gender">Todos</button>
          <button href="#" class="btn btn{{ $gender != 'woman' ? '-outline' : '' }}-primary my-2" name="gender" value="woman">Mujer</button>
          <button class="btn btn{{ $gender != 'man' ? '-outline' : '' }}-primary my-2" name="gender" value="man">Hombre</button>
        </div>
      </form>
      </p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row product-row">
        @each('category_product', $products, 'product')
      </div>
    </div>
    <div class="pagination">
        <ul class="uk-pagination uk-flex-center">
          @if($current_page > $min_page+1)
            <li class="page-item">
          @else
            <li class="uk-disabled">
          @endif
            <a class="page-link" href="/category/{{ $category }}/{{ $current_page-1 }}"><span uk-pagination-previous>Anterior<</a>
          </li>
          @if($current_page > $min_page+1)
            <li class="page-item"><a class="page-link" href="/category/{{ $category }}/{{ $current_page-1 }}">{{ ($current_page-1) }}</a></li>
          @endif
          <li class="page-item active">
            <a class="page-link" href="/category/{{ $category }}/{{ $current_page }}">{{ $current_page }}</a>
          </li>
          @if($current_page < $max_page)
            <li class="page-item"><a class="page-link" href="/category/{{ $category }}/{{ $current_page+1 }}">{{ ($current_page+1) }}</a></li>
          @endif
          @if($current_page < $max_page)
            <li class="page-item">
          @else
            <li class="uk-disabled">
          @endif
            <a class="page-link" href="/category/{{ $category }}/{{ $current_page+1 }}"><span uk-pagination-next>Siguiente</span></a>
          </li>
        </ul>
    </div>
  </div>
</main>
@include('layouts.footer')
