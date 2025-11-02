@extends('layouts.app')

@section('content')
<div class="container py-4">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Shop</h2>

    {{-- Search form --}}
    <form action="{{ route('shop.index') }}" method="get" class="d-flex">
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="form-control me-2">
      <button class="btn btn-outline-primary">Search</button>
    </form>
  </div>

  {{-- Categories filter --}}
  @if($categories->count())
  <div class="mb-4">
    <a href="{{ route('shop.index') }}" 
       class="btn btn-sm {{ request('category') ? 'btn-outline-secondary' : 'btn-primary' }} me-2">
       All
    </a>
    @foreach($categories as $category)
      <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
         class="btn btn-sm {{ request('category') === $category->slug ? 'btn-primary' : 'btn-outline-secondary' }} me-2">
         {{ $category->name }}
      </a>
    @endforeach
  </div>
  @endif

  {{-- Product grid --}}
  @if($products->count())
  <div class="row g-4">
    @foreach($products as $product)
    <div class="col-md-3 col-sm-6">
      <div class="card h-100 shadow-sm border-0">
        {{-- Image --}}
        @if($product->image)
          <a href="{{ route('shop.show', $product->slug) }}">
            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height:200px; object-fit:cover;">
          </a>
        @else
          <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px;">
            <span class="text-muted">No Image</span>
          </div>
        @endif

        {{-- Info --}}
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">
            <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none text-dark">
              {{ $product->name }}
            </a>
          </h5>
          <p class="text-muted mb-2">${{ number_format($product->price, 2) }}</p>
          <p class="small text-secondary flex-grow-1">{{ Str::limit($product->description, 80) }}</p>

          {{-- Add to Cart --}}
          @auth
    @if(auth()->user()->hasVerifiedEmail())
        <form action="{{ route('cart.add', $product->id) }}" method="post" class="add-to-cart-form">
            @csrf
            <button type="submit" class="btn btn-primary w-100 mt-auto">
                <i class="bi bi-cart-plus"></i> Add to Cart
            </button>
        </form>
    @else
        <a href="{{ route('verification.notice') }}" class="btn btn-warning w-100 mt-auto">
            <i class="bi bi-envelope-exclamation"></i> Verify Email First
        </a>
    @endif
@else
    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mt-auto">
        <i class="bi bi-box-arrow-in-right"></i> Login to Add
    </a>

          @endauth

          {{-- Wishlist --}}
          <form action="{{ route('wishlist.add', $product->id) }}" method="post" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-100">
              <i class="bi bi-heart"></i> Add to Wishlist
            </button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  <div class="mt-4 d-flex justify-content-center">
    {{ $products->links() }}
  </div>
  @else
    <p class="text-center text-muted mt-5">No products found.</p>
  @endif

</div>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
  form.addEventListener('submit', async function(e) {
    e.preventDefault();

    const response = await fetch(this.action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': this.querySelector('input[name="_token"]').value
      }
    });

    if (response.ok) {
      // Update cart count
      let badge = document.querySelector('#cart-count');
      if (!badge) {
        const cartLink = document.querySelector('.bi-cart3').parentElement;
        badge = document.createElement('span');
        badge.id = 'cart-count';
        badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
        cartLink.appendChild(badge);
        badge.innerText = '1';
      } else {
        badge.innerText = parseInt(badge.innerText) + 1;
      }

      // Toast message
      const toast = document.createElement('div');
      toast.innerHTML = `
        <div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert">
          <div class="d-flex">
            <div class="toast-body">✅ Product added to cart!</div>
          </div>
        </div>`;
      document.body.appendChild(toast);
      const toastEl = new bootstrap.Toast(toast.querySelector('.toast'), { delay: 2000 });
      toastEl.show();
      setTimeout(()=>toast.remove(),2500);
    }
  });
});
</script>
@endsection
