@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">Live TV</h2>

  <div class="row g-4">
    @foreach($channels as $channel)
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card border-0 shadow-sm text-center">
          @if($channel->logo)
            <img src="{{ asset('storage/'.$channel->logo) }}" class="card-img-top" style="height:140px;object-fit:cover;">
          @endif
          <div class="card-body">
            <h6 class="fw-semibold">{{ $channel->name }}</h6>
            <a href="{{ route('live.show', $channel->id) }}" class="btn btn-primary btn-sm mt-2">
  <i class="bi bi-play-circle"></i> Watch
</a>

          </div>
        </div>
      </div>

      <!-- Modal Player -->
      <div class="modal fade" id="player{{ $channel->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">{{ $channel->name }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
              <video controls autoplay style="width:100%;height:70vh;">
                <source src="{{ $channel->stream_url }}" type="application/x-mpegURL">
                Your browser does not support the video tag.
              </video>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
