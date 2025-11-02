@extends('layouts.app')

@section('content')
<div class="container py-4">
  <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mb-3">← Back</a>

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">Edit Category</h4>

      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif

      <form action="{{ route('admin.categories.update',$category) }}" method="post">
        @csrf @method('put')
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
        </div>
        <button class="btn btn-primary">Save</button>
      </form>
    </div>
  </div>
</div>
@endsection
