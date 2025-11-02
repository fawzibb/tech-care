@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">My Wishlist</h2>

  @if($products->count())
    <div class="row g-3">
      @foreach($products as $p)
        <div class="col-6 col-md-3">
          <div class="card border-0 shadow-sm text-center">
            @if($p->image)
              <img src="{{ asset('storage/'.$p->image) }}" class="card-img-top" style="height:180px;object-fit:cover;">
            @endif
            <div class="card-body">
              <h6 class="fw-semibold">{{ $p->name }}</h6>
              <p class="text-muted small">${{ $p->price }}</p>
              <form method="POST" action="{{ route('wishlist.remove',$p) }}">
                @csrf
                <button class="btn btn-outline-danger btn-sm">Remove</button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-muted">Your wishlist is empty.</p>
  @endif
</div>
@endsection
