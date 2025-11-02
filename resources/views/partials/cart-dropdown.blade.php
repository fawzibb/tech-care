<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
  <i class="bi bi-cart3 fs-5"></i>
  @if($cartCount > 0)
    <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
      {{ $cartCount }}
    </span>
  @endif
</a>

<ul class="dropdown-menu dropdown-menu-end p-3 shadow-lg" style="min-width:300px;">
  <h6 class="dropdown-header">Your Cart</h6>
  <hr class="my-1">
  
  @if($cartCount === 0)
    <p class="text-center text-muted m-0">Your cart is empty.</p>
  @else
    @foreach($cart as $id => $item)
      <li class="d-flex align-items-center mb-2">
        @if($item['image'])
          <img src="{{ asset('storage/'.$item['image']) }}" class="rounded me-2" style="width:40px;height:40px;object-fit:cover;">
        @endif
        <div class="flex-grow-1">
          <div class="fw-semibold small">{{ $item['name'] }}</div>
          <div class="text-muted small">${{ number_format($item['price'],2) }} × {{ $item['qty'] }}</div>
        </div>
      </li>
    @endforeach
    <hr class="my-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <strong>Total:</strong>
      <span class="fw-semibold">${{ number_format($cartTotal,2) }}</span>
    </div>
    <a href="{{ route('cart.index') }}" class="btn btn-outline-primary w-100 mb-2">Go to Cart</a>
  @endif
</ul>
