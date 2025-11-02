@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card shadow-lg p-4" style="max-width: 450px; width: 100%;">
    <h3 class="text-center mb-4 fw-bold text-primary">Reset Password</h3>

    @if (session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      {{-- Email --}}
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}" required autofocus>
      </div>

      {{-- Password --}}
      <div class="mb-3 position-relative">
        <label for="password" class="form-label">New Password</label>
        <div class="input-group">
          <input id="password" type="password" class="form-control" name="password" required>
          <span class="input-group-text" onclick="togglePassword('password', this)" style="cursor:pointer;">
            <i class="bi bi-eye"></i>
          </span>
        </div>
      </div>

      {{-- Confirm Password --}}
      <div class="mb-4 position-relative">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <div class="input-group">
          <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
          <span class="input-group-text" onclick="togglePassword('password_confirmation', this)" style="cursor:pointer;">
            <i class="bi bi-eye"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-key"></i> Reset Password
      </button>
    </form>
  </div>
</div>

{{-- Eye Toggle Script --}}
<script>
function togglePassword(fieldId, el) {
  const input = document.getElementById(fieldId);
  const icon = el.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('bi-eye', 'bi-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.replace('bi-eye-slash', 'bi-eye');
  }
}
</script>
@endsection
