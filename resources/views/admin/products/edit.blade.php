@extends('layouts.app')

@section('content')
<div class="container py-4">
  <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mb-3">← Back</a>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">Edit Product</h4>

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
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @if($product->image)
              <img src="{{ asset('storage/'.$product->image) }}" class="mt-2 rounded" style="height:100px;object-fit:cover">
            @endif
          </div>
        </div>

        <button class="btn btn-primary mt-3">Save</button>
      </form>
    </div>
  </div>
</div>
@endsection
