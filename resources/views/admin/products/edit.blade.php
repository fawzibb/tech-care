@extends('layouts.app')

@section('content')
<div class="container py-4">
  <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mb-3">← Back</a>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">Edit Product</h4>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif

      <form action="{{ route('admin.products.update',$product) }}" method="post" enctype="multipart/form-data">
        @csrf @method('put')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name',$product->name) }}" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Price (USD)</label>
            <input type="number" name="price" step="0.01" min="0" value="{{ old('price',$product->price) }}" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ $product->category_id==$c->id?'selected':'' }}>{{ $c->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description',$product->description) }}</textarea>
          </div>

          <div class="col-md-6">
  <label class="form-label">Add Media (Images/Videos)</label>

  <div id="mediaInputsEdit">
    <input type="file" name="media[]" class="form-control mb-2" accept="image/*,video/*">
  </div>

  <button type="button" id="addMediaBtnEdit" class="btn btn-sm btn-outline-secondary">
    + Add another file
  </button>
  <small class="text-muted d-block mt-1">Uploads will be added without removing existing media.</small>
</div>


        {{-- Existing Media --}}
        @if($product->media->count())
  <hr class="mt-4 mb-3">
  <label class="form-label fw-semibold">Existing Media</label>

  <div class="row g-3">
    @foreach($product->media as $m)
      <div class="col-6 col-sm-4 col-md-3">
        <div class="border rounded p-2 h-100 d-flex flex-column">
          <div class="mb-2" style="height:110px; overflow:hidden; border-radius:6px;">
            @if($m->type === 'image')
              <img src="{{ asset('storage/'.$m->path) }}" class="w-100" style="height:110px;object-fit:cover">
            @else
              <video src="{{ asset('storage/'.$m->path) }}" class="w-100" style="height:110px;object-fit:cover" controls></video>
            @endif
          </div>

          <div class="d-flex gap-2 mt-auto">
            {{-- Edit (replace file) --}}
            <form action="{{ route('admin.media.update', $m) }}" method="post" enctype="multipart/form-data" class="d-flex flex-grow-1 gap-2">
              @csrf
              <input type="file" name="file" class="form-control form-control-sm" accept="image/*,video/*" required>
              <button class="btn btn-sm btn-outline-primary">Edit</button>
            </form>

            {{-- Delete --}}
            <form action="{{ route('admin.media.delete', $m) }}" method="post" onsubmit="return confirm('Delete this file?')">
              @csrf @method('delete')
              <button class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif


        <button class="btn btn-primary mt-4">Save</button>
      </form>
    </div>
  </div>
</div>
@endsection
