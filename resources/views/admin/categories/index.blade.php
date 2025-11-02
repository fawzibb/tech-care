@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold">Categories</h2>

    <form class="d-flex" method="get">
      <input type="text" name="q" value="{{ request('q') }}" class="form-control me-2" placeholder="Search categories...">
      <button class="btn btn-outline-primary">Search</button>
    </form>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  <div class="row g-4">
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h5 class="mb-3">Create New Category</h5>
          <form action="{{ route('admin.categories.store') }}" method="post">
            @csrf
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Create</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($categories as $cat)
                  <tr>
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->name }}</td>
                    <td class="text-muted">{{ $cat->slug }}</td>
                    <td class="d-flex gap-2">
                      <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.categories.edit',$cat) }}">Edit</a>
                      <form action="{{ route('admin.categories.destroy',$cat) }}" method="post" onsubmit="return confirm('Delete this category?')">
                        @csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr><td colspan="4" class="text-center text-muted">No categories found.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            {{ $categories->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
