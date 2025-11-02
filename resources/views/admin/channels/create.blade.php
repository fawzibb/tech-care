@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">Add New Channel</h2>

  <a href="{{ route('admin.channels.index') }}" class="btn btn-secondary mb-3">← Back to Channels</a>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('admin.channels.store') }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
    @csrf

    <div class="mb-3">
      <label class="form-label">Channel Name</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Stream URL (.m3u8)</label>
      <input type="text" name="stream_url" value="{{ old('stream_url') }}" class="form-control" required>
      <div class="form-text">Example: https://example.com/live/stream.m3u8</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Category (optional)</label>
      <input type="text" name="category" value="{{ old('category') }}" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Logo Image</label>
      <input type="file" name="logo" class="form-control">
      <div class="form-text">Optional — upload a channel logo (JPG, PNG).</div>
    </div>

    <button type="submit" class="btn btn-success">Save Channel</button>
  </form>
</div>
@endsection
