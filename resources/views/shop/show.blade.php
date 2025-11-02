@extends('layouts.app')

@section('content')
<div class="container py-5">

  {{-- Back button --}}
  <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary mb-4">
    ← Back to Shop
  </a>

  <div class="row g-5">
    {{-- Product Image --}}
    <div class="col-md-6">
      <div class="card shadow-sm border-0">
        @if($product->image)
          <img src="{{ asset('storage/'.$product->image) }}" 
               class="card-img-top rounded" 
               alt="{{ $product->name }}" 
               style="max-height:450px; object-fit:cover;">
        @else
          <div class="d-flex align-items-center justify-content-center bg-light" style="height:450px;">
            <span class="text-muted">No Image Available</span>
          </div>
        @endif
      </div>
    </div>

    {{-- Product Info --}}
    <div class="col-md-6 d-flex flex-column">
      <h2 class="fw-bold">{{ $product->name }}</h2>
      <p class="text-muted mb-2">
        Category: 
        <span class="fw-semibold">{{ $product->category->name ?? 'Uncategorized' }}</span>
      </p>
      <h4 class="text-success mb-3">${{ number_format($product->price, 2) }}</h4>

      <p class="lead">{{ $product->description }}</p>

      <form action="{{ route('cart.add', $product->id) }}" method="post" class="mt-auto">
        @csrf
        <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
          Add to Cart
        </button>
      </form>
    </div>
  </div>

  {{-- Related products (optional section) --}}
  @if(isset($related) && $related->count())
  <hr class="my-5">
  <h4 class="fw-bold mb-4">You may also like</h4>
  <div class="row g-4">
    @foreach($related as $item)
    <div class="col-md-3 col-sm-6">
      <div class="card h-100 shadow-sm border-0">
        @if($item->image)
          <a href="{{ route('shop.show', $item->slug) }}">
            <img src="{{ asset('storage/'.$item->image) }}" 
                 class="card-img-top" 
                 alt="{{ $item->name }}" 
                 style="height:180px; object-fit:cover;">
          </a>
        @endif
        <div class="card-body">
          <h6 class="card-title mb-1">
            <a href="{{ route('shop.show', $item->slug) }}" class="text-decoration-none text-dark">
              {{ Str::limit($item->name, 25) }}
            </a>
          </h6>
          <p class="text-muted small mb-2">${{ number_format($item->price, 2) }}</p>
          <form action="{{ route('cart.add', $item->id) }}" method="post">
            @csrf
            <button class="btn btn-sm btn-outline-primary w-100">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif

  @php
  $recent = \App\Models\Product::whereIn('id', session('recently_viewed', []))
            ->where('id','!=',$product->id)
            ->get();
@endphp

@if($recent->count())
  <div class="mt-5">
    <h4 class="fw-bold mb-3">Recently Viewed</h4>
    <div class="row g-3">
      @foreach($recent as $p)
        <div class="col-6 col-md-4 col-lg-3">
          <a href="{{ route('shop.show',$p) }}" class="text-decoration-none text-center">
            <div class="card border-0 shadow-sm">
              @if($p->image)
                <img src="{{ asset('storage/'.$p->image) }}" class="card-img-top" style="height:160px;object-fit:cover;">
              @endif
              <div class="card-body p-2">
                <div class="fw-semibold text-truncate">{{ $p->name }}</div>
                <div class="text-muted small">${{ $p->price }}</div>
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>
@endif


</div>
@endsection
