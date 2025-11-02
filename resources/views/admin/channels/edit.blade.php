@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">Edit Channel</h2>

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

  <form method="POST" action="{{ route('admin.channels.update', $channel->id) }}" enctype="multipart/form-data" class="card p-4 shadow-sm">
    @csrf

    <div class="mb-3">
      <label class="form-label">Channel Name</label>
      <input type="text" name="name" value="{{ old('name', $channel->name) }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Stream URL (.m3u8)</label>
      <input type="text" name="stream_url" value="{{ old('stream_url', $channel->stream_url) }}" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Category (optional)</label>
      <input type="text" name="category" value="{{ old('category', $channel->category) }}" class="form-control">
    </div>

    <div class="mb-3">
      <label class="form-label">Logo Image (optional)</label>
      @if($channel->logo)
        <div class="mb-2">
          <img src="{{ asset('storage/'.$channel->logo) }}" width="100" class="rounded">
        </div>
      @endif
      <input type="file" name="logo" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Update Channel</button>
  </form>
</div>
@endsection
