@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">Account Settings</h2>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
  @endif

  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <form action="{{ route('settings.update') }}" method="post">
        @csrf

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control">
          </div>

          <div class="col-md-6">
            <label class="form-label">Address</label>
            <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}" class="form-control">
          </div>

          <hr class="my-4">

          <div class="col-md-6">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
          </div>

          <div class="col-md-6">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Leave blank to keep current">
          </div>
        </div>

        <button class="btn btn-primary mt-4">Save Changes</button>
      </form>
    </div>
  </div>
</div>
@endsection
