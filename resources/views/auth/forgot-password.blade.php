@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
  <div class="card shadow-sm border-0" style="max-width:400px;width:100%;">
    <div class="card-body">
      <h3 class="text-center mb-4 fw-bold text-primary">Reset Password</h3>

      @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Enter your email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
      </form>

      <p class="text-center mt-3 small">
        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">← Back to Login</a>
      </p>
    </div>
  </div>
</div>
@endsection
