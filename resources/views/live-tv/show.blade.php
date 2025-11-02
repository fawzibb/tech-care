@extends('layouts.app')

@section('content')
<style>
  body {
    background-color: #000; /* خلفية داكنة */
  }

  .video-container {
    max-width: 1000px;
    margin: auto;
  }

  .channel-info {
    color: #fff;
    text-align: center;
    margin-top: 20px;
  }

  .channel-info h2 {
    font-weight: 700;
    font-size: 1.8rem;
  }

  .channel-info p {
    color: #bbb;
  }
</style>

<div class="container-fluid py-4">
  <div class="video-container">
    <a href="{{ route('live.index') }}" class="btn btn-outline-light mb-3">
      ← Back to Channels
    </a>

    {{-- شعار القناة --}}
    @if($channel->logo)
      <div class="text-center mb-3">
        <img src="{{ asset('storage/'.$channel->logo) }}" height="80" class="rounded">
      </div>
    @endif

    {{-- مشغل الفيديو --}}
    <video
      id="my-video"
      class="video-js vjs-big-play-centered vjs-theme-city"
      controls
      preload="auto"
      width="100%"
      height="480"
      data-setup='{}'>
      <source src="{{ $channel->stream_url }}" type="application/x-mpegURL">
      Your browser does not support the video tag.
    </video>

    <div class="channel-info">
      <h2>{{ $channel->name }}</h2>
      @if($channel->category)
        <p class="small">Category: {{ $channel->category }}</p>
      @endif
    </div>
  </div>
</div>
@endsection

@section('scripts')
{{-- Video.js CDN --}}
<link href="https://vjs.zencdn.net/8.10.0/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/8.10.0/video.min.js"></script>

{{-- Theme (City) --}}
<link href="https://cdn.jsdelivr.net/npm/@videojs/themes@1.0.1/dist/city/index.css" rel="stylesheet" />

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const player = videojs('my-video', {
      autoplay: true,
      controls: true,
      preload: 'auto',
      fluid: true,
      liveui: true,
      controlBar: {
        volumePanel: {inline: true},
        pictureInPictureToggle: true,
        fullscreenToggle: true,
      }
    });

    // عند الخطأ في البث
    player.on('error', function() {
      const error = player.error();
      alert('⚠️ Cannot load this stream.\n\nError: ' + (error ? error.message : 'Unknown'));
    });
  });
</script>
@endsection
