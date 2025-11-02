@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="fw-bold mb-4">Manage Channels</h2>

  <a href="{{ route('admin.channels.create') }}" class="btn btn-primary mb-3">+ Add Channel</a>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>Logo</th>
        <th>Name</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($channels as $ch)
      <tr>
        <td>
          @if($ch->logo)
            <img src="{{ asset('storage/'.$ch->logo) }}" width="60">
          @endif
        </td>
        <td>{{ $ch->name }}</td>
        <td>{{ $ch->category }}</td>
        <td>
          <a href="{{ route('admin.channels.edit',$ch) }}" class="btn btn-sm btn-outline-warning">Edit</a>
          <form action="{{ route('admin.channels.destroy',$ch) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
