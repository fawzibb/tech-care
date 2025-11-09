@extends('layouts.app')

@section('content')
<div class="container py-5">

  {{-- Back button --}}
  <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary mb-4">
    ← Back to Shop
  </a>

  <div class="row g-5">
    {{-- Product Media --}}
    <div class="col-md-6">
      <div class="card shadow-sm border-0 p-3">
        @if($product->media->count())
          {{-- Carousel --}}
          <div id="productGallery" class="carousel slide mb-3" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
              @foreach($product->media as $key => $media)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                  @if($media->type === 'image')
                    <img src="{{ asset('storage/'.$media->path) }}" 
                         class="d-block w-100 rounded" 
                         alt="Image {{ $key+1 }}" 
                         style="max-height:450px; object-fit:cover;">
                  @elseif($media->type === 'video')
                    <video controls class="d-block w-100 rounded" style="max-height:450px; object-fit:cover;">
                      <source src="{{ asset('storage/'.$media->path) }}" type="video/mp4">
                    </video>
                  @endif
                </div>
              @endforeach
            </div>

            {{-- Navigation arrows --}}
            @if($product->media->count() > 1)
              <button class="carousel-control-prev" type="button" data-bs-target="#productGallery" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#productGallery" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            @endif
          </div>

          {{-- Thumbnails --}}
          @if($product->media->count() > 1)
          <div class="d-flex justify-content-center flex-wrap gap-2">
            @foreach($product->media as $key => $media)
              <div class="thumb border rounded p-1" 
                   style="width:70px; height:70px; cursor:pointer; overflow:hidden;"
                   data-bs-target="#productGallery" 
                   data-bs-slide-to="{{ $key }}">
                @if($media->type === 'image')
                  <img src="{{ asset('storage/'.$media->path) }}" 
                       class="img-fluid rounded" 
                       style="width:100%; height:100%; object-fit:cover;">
                @elseif($media->type === 'video')
                  <div class="position-relative w-100 h-100 bg-dark d-flex align-items-center justify-content-center text-white">
                    <i class="bi bi-play-circle fs-3"></i>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
          @endif
        @else
          <div class="d-flex align-items-center justify-content-center bg-light" style="height:450px;">
            <span class="text-muted">No Media Available</span>
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

  {{-- Related products --}}
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

  {{-- Recently viewed --}}
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

@section('scripts')
<script>
  const thumbs = document.querySelectorAll('.thumb');
  const carousel = document.querySelector('#productGallery');

  // تمييز الصورة النشطة في المصغرات
  carousel.addEventListener('slide.bs.carousel', function (e) {
    thumbs.forEach(t => t.classList.remove('active'));
    thumbs[e.to].classList.add('active');
  });
</script>
@endsection

<style>
.thumb.active {
  border: 2px solid #0d6efd !important;
  transform: scale(1.05);
  transition: all 0.2s ease-in-out;
}
</style>
