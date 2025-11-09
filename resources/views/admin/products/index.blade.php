@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">Products</h2>

    <form class="d-flex" method="get">
      <input type="text" name="q" value="{{ request('q') }}" class="form-control me-2" placeholder="Search products...">
      <select name="category" class="form-select me-2" style="max-width:220px">
        <option value="">All categories</option>
        @foreach($categories as $c)
          <option value="{{ $c->slug }}" {{ request('category')===$c->slug?'selected':'' }}>{{ $c->name }}</option>
        @endforeach
      </select>
      <button class="btn btn-outline-primary">Filter</button>
    </form>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  <div class="row g-4">
    {{-- Create new product --}}
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h5 class="mb-3 fw-bold">Create New Product</h5>
          <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Category</label>
              <select name="category_id" class="form-select" required>
                <option value="" disabled selected>Choose...</option>
                @foreach($categories as $c)
                  <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Price (USD)</label>
              <input type="number" name="price" step="0.01" min="0" class="form-control" required>
            </div>

            <div class="mb-3">
  <label class="form-label">Media (Images or Videos)</label>

  <div id="mediaInputs">
    <input type="file" name="media[]" class="form-control mb-2" accept="image/*,video/*">
  </div>

  <button type="button" id="addMediaBtn" class="btn btn-sm btn-outline-secondary">
    + Add another file
  </button>
  <small class="text-muted d-block mt-1">You can upload multiple images or videos</small>
</div>

@push('scripts')
<script>
  document.getElementById('addMediaBtn').addEventListener('click', function () {
    const wrap = document.getElementById('mediaInputs');
    const input = document.createElement('input');
    input.type = 'file';
    input.name = 'media[]';
    input.className = 'form-control mb-2';
    input.accept = 'image/*,video/*';
    wrap.appendChild(input);
  });
</script>
@endpush


            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" rows="4" class="form-control" placeholder="Optional"></textarea>
            </div>

            <button class="btn btn-primary w-100">Create</button>
          </form>
        </div>
      </div>
    </div>

    {{-- Product list --}}
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($products as $p)
                  <tr>
                    <td>{{ $p->id }}</td>
                    <td class="d-flex align-items-center">
                      @php
                        $firstMedia = $p->media->first();
                      @endphp
                      @if($firstMedia && $firstMedia->type === 'image')
                        <img src="{{ asset('storage/'.$firstMedia->path) }}" style="height:40px;width:40px;object-fit:cover" class="rounded me-2">
                      @elseif($firstMedia && $firstMedia->type === 'video')
                        <video src="{{ asset('storage/'.$firstMedia->path) }}" style="height:40px;width:40px;object-fit:cover" muted></video>
                      @endif
                      <div>
                        <div class="fw-semibold">{{ $p->name }}</div>
                        <div class="text-muted small">{{ $p->slug }}</div>
                      </div>
                    </td>
                    <td>{{ $p->category->name ?? '—' }}</td>
                    <td>${{ number_format($p->price,2) }}</td>
                    <td class="d-flex gap-2">
                      <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.products.edit',$p) }}">Edit</a>
                      <form action="{{ route('admin.products.destroy',$p) }}" method="post" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="5" class="text-center text-muted">No products found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            {{ $products->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
