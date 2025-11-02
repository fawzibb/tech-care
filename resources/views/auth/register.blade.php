@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
  <div class="card shadow-sm border-0" style="max-width:450px;width:100%;">
    <div class="card-body">
      <h3 class="text-center mb-4 fw-bold text-primary">Create Account</h3>

      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
        </div>

       <div class="mb-3">
  <label class="form-label">Password</label>
  <div class="input-group password-toggle">
    <input type="password" name="password" class="form-control" required>
    <button class="btn btn-outline-secondary" type="button" tabindex="-1">
      <i class="bi bi-eye"></i>
    </button>
  </div>
</div>

<div class="mb-3">
  <label class="form-label">Confirm Password</label>
  <div class="input-group password-toggle">
    <input type="password" name="password_confirmation" class="form-control" required>
    <button class="btn btn-outline-secondary" type="button" tabindex="-1">
      <i class="bi bi-eye"></i>
    </button>
  </div>
</div>


        <button type="submit" class="btn btn-primary w-100">Sign up</button>
      </form>

      <p class="text-center mt-3 small">
        Already have an account?
        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Login</a>
      </p>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script>
  document.querySelectorAll('.password-toggle').forEach(container => {
    const input = container.querySelector('input');
    const btn = container.querySelector('button');

    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      btn.innerHTML = isHidden 
        ? '<i class="bi bi-eye-slash"></i>' 
        : '<i class="bi bi-eye"></i>';
    });
  });
</script>
@endsection

