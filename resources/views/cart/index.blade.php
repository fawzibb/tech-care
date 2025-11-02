@extends('layouts.app')

@section('content')
<h1 class="mb-3">Your Cart</h1>

@if(empty($cart))
  <p>Your cart is empty.</p>
@else
  @php
    $deliveryFee = 3.00;
    $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
    $total = $subtotal + $deliveryFee;
  @endphp

  <table class="table align-middle">
    <thead>
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Subtotal</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($cart as $pid => $item)
        <tr>
          <td class="d-flex align-items-center">
            @if($item['image'])
              <img src="{{ asset('storage/'.$item['image']) }}" style="height:50px;width:50px;object-fit:cover" class="me-2 rounded">
            @endif
            {{ $item['name'] }}
          </td>
          <td>${{ number_format($item['price'], 2) }}</td>
          <td>
            <form action="{{ route('cart.update',$pid) }}" method="post" class="d-flex">
              @csrf
              @method('put')
              <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" max="99"
                     class="form-control form-control-sm" style="width:80px">
              <button class="btn btn-sm btn-outline-secondary ms-2">Update</button>
            </form>
          </td>
          <td>${{ number_format($item['price'] * $item['qty'], 2) }}</td>
          <td>
            <form action="{{ route('cart.remove',$pid) }}" method="post">
              @csrf @method('delete')
              <button class="btn btn-sm btn-outline-danger">Remove</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{-- Summary Section --}}
  <div class="card p-3 mb-4">
    <div class="d-flex justify-content-between">
      <span>Subtotal:</span>
      <strong>${{ number_format($subtotal, 2) }}</strong>
    </div>
    <div class="d-flex justify-content-between text-muted">
      <span>Delivery Fee:</span>
      <strong>${{ number_format($deliveryFee, 2) }}</strong>
    </div>
    <hr>
    <div class="d-flex justify-content-between fs-5">
      <span>Total:</span>
      <strong>${{ number_format($total, 2) }}</strong>
    </div>
  </div>

  {{-- Checkout --}}
  <form action="{{ route('order.whatsapp') }}" method="post" class="card p-3 shadow-sm">
    @csrf
    <h5 class="mb-3">Delivery Information</h5>
    <div class="row g-2">
      <div class="col-md-4">
        <label class="form-label">Full Name</label>
        <input name="name" class="form-control" value="{{ old('name', auth()->user()->name ?? '') }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Phone</label>
        <input name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Address</label>
        <input name="address" class="form-control" value="{{ old('address', auth()->user()->address ?? '') }}" required>
      </div>
    </div>
    <input type="hidden" name="delivery_fee" value="{{ $deliveryFee }}">
    <button class="btn btn-success btn-lg mt-3 w-100">
      <i class="bi bi-whatsapp"></i> Order Now via WhatsApp
    </button>
  </form>

  <div class="mt-3 text-end">
    <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">Continue Shopping</a>
  </div>
@endif
@endsection
