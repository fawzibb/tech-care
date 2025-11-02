@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
  <div class="card shadow-sm border-0" style="max-width:400px;width:100%;">
    <div class="card-body">
      <h3 class="text-center mb-4 fw-bold text-primary">Welcome Back 👋</h3>

      {{-- ✅ Flash message --}}
      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-warning">{{ session('error') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
  <label class="form-label d-flex justify-content-between">
    <span>Password</span>
    <a href="{{ route('password.request') }}" class="small text-decoration-none">Forgot?</a>
  </label>
  <div class="input-group password-toggle">
    <input type="password" name="password" class="form-control" required>
    <button class="btn btn-outline-secondary" type="button" tabindex="-1">
      <i class="bi bi-eye"></i>
    </button>
  </div>
</div>


        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="remember" id="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>

      <p class="text-center mt-3 small">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Sign up</a>
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

