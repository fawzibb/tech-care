@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Admin Dashboard</h1>
    <p class="lead">Welcome, {{ auth()->user()->name }} 👋</p>

    <div class="row g-4 mt-4">
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <h5 class="fw-bold">Categories</h5>
                <p class="fs-3 text-primary">{{ \App\Models\Category::count() }}</p>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary btn-sm">Manage</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <h5 class="fw-bold">Products</h5>
                <p class="fs-3 text-primary">{{ \App\Models\Product::count() }}</p>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm">Manage</a>
            </div>
        </div>
                <div class="col-md-6 col-lg-3">
            <div class="card shadow-sm border-0 text-center p-3">
                <h5 class="fw-bold">channels</h5>
                <p class="fs-3 text-primary">{{ \App\Models\Channel::count() }}</p>
                <a href="{{ route('admin.channels.index') }}" class="btn btn-outline-primary btn-sm">Manage</a>
            </div>
        </div>
    </div>
</div>
@endsection
