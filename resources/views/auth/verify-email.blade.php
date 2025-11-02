@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 600px;">
    <div class="card shadow-sm border-0">
        <div class="card-body text-center py-5">

            <img src="{{ asset('images/logo.png') }}" alt="Tech Care Logo" style="height:60px" class="mb-4">

            <h3 class="fw-bold mb-3 text-primary">Verify Your Email Address</h3>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <p class="text-muted">
                Thanks for signing up! Please verify your email by clicking the link we just sent you.
                <br>please check junk email folder as well.
                <br>If you didn’t receive it, you can request another one below.
            </p>

            <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-envelope"></i> Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </button>
            </form>

        </div>
    </div>
</div>
@endsection
