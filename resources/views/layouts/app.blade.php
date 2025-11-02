<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Care Store</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ===== Custom Tech Care Theme ===== */
        :root {
            --brand-color: #007bff;
            --brand-dark: #0d6efd;
            --text-dark: #212529;
            --bg-light: #f8f9fa;
        }

        [data-bs-theme="dark"] {
            --bs-body-bg: #121212;
            --bs-body-color: #e5e5e5;
            --bs-card-bg: #1c1c1c;
            --bs-border-color: #2c2c2c;
            --brand-color: #0d6efd;
        }

        body {
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            transition: background-color 0.4s, color 0.4s;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        .navbar {
            background-color: var(--bs-body-bg) !important;
            border-bottom: 1px solid var(--bs-border-color);
            transition: background-color 0.4s;
        }

        .navbar-brand img {
            height: 32px;
            margin-right: 8px;
        }

        .nav-link {
            color: var(--bs-body-color) !important;
            opacity: 0.85;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--brand-color) !important;
            opacity: 1;
        }

        footer {
            border-top: 1px solid var(--bs-border-color);
            background-color: var(--bs-body-bg);
            transition: background-color 0.4s, color 0.4s;
        }

        /* Buttons */
        .btn-primary {
            background-color: var(--brand-color);
            border-color: var(--brand-color);
        }
        .btn-primary:hover {
            background-color: var(--brand-dark);
            border-color: var(--brand-dark);
        }

        /* Mini Cart dropdown style */
        .dropdown-menu {
            z-index: 2000;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold" href="/">
      <img src="/images/logo.png" alt="Tech Care Logo">
      TECH&nbsp;CARE
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      {{-- Left Side: Shop + Cart --}}
      <ul class="navbar-nav me-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ route('shop.index') }}">
            <i class="bi bi-shop"></i> shop

          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('wishlist') ? 'active' : '' }}" href="{{ route('wishlist.index') }}">
  <i class="bi bi-heart"></i> wishlist
</a>
        </li>

        {{-- 🛒 Cart Dropdown --}}
        @php
            $cart = session('cart', []);
            $cartCount = count($cart);
            $cartTotal = collect($cart)->sum(fn($i)=>$i['price']*$i['qty']);
            $deliveryFee = $cartTotal > 0 ? 3 : 0; // توصيل 3$ إذا في عناصر
            $grandTotal = $cartTotal + $deliveryFee;
        @endphp
        <li class="nav-item dropdown position-relative">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-cart3 fs-5"></i>
            @if($cartCount > 0)
              <span id="cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $cartCount }}
              </span>
            @endif
          </a>

          <ul class="dropdown-menu dropdown-menu-end p-3 shadow-lg" style="min-width:300px;">
            <h6 class="dropdown-header">Your Cart</h6>
            <hr class="my-1">
            
            @if($cartCount === 0)
              <p class="text-center text-muted m-0">Your cart is empty.</p>
            @else
              @foreach($cart as $id => $item)
                <li class="d-flex align-items-center mb-2">
                  @if($item['image'])
                    <img src="{{ asset('storage/'.$item['image']) }}" class="rounded me-2" style="width:40px;height:40px;object-fit:cover;">
                  @endif
                  <div class="flex-grow-1">
                    <div class="fw-semibold small">{{ $item['name'] }}</div>
                    <div class="text-muted small">${{ number_format($item['price'],2) }} × {{ $item['qty'] }}</div>
                  </div>
                </li>
              @endforeach
              <hr class="my-2">
              <div class="d-flex justify-content-between small mb-1">
  <span>Subtotal:</span>
  <span>${{ number_format($cartTotal, 2) }}</span>
</div>
<div class="d-flex justify-content-between small mb-1">
  <span>Delivery:</span>
  <span>${{ number_format($deliveryFee, 2) }}</span>
</div>
<hr class="my-2">
<div class="d-flex justify-content-between align-items-center mb-2">
  <strong>Total:</strong>
  <span class="fw-semibold">${{ number_format($grandTotal, 2) }}</span>
</div>
              <a href="{{ route('cart.index') }}" class="btn btn-outline-primary w-100 mb-2">Go to Cart</a>
              <form action="{{ route('order.whatsapp') }}" method="post">
                @csrf
                <input type="hidden" name="name" value="{{ auth()->user()->name ?? '' }}">
                <input type="hidden" name="phone" value="{{ auth()->user()->phone ?? '' }}">
                <input type="hidden" name="address" value="{{ auth()->user()->address ?? '' }}">
                <button class="btn btn-success w-100" {{ $cartCount==0?'disabled':'' }}>
                  <i class="bi bi-whatsapp"></i> Order Now
                </button>
              </form>
            @endif
          </ul>
        </li>
      
       <!--  <li>
            <a class="nav-link {{ request()->is('live-tv') ? 'active' : '' }}" href="{{ route('live.index') }}">
                <i class="bi bi-tv"></i> live-tv
            </a>
        </li>-->
      </ul>
      

      {{-- Right Side: Theme / Auth --}}
      <ul class="navbar-nav ms-auto align-items-center">
        {{-- Theme toggle --}}
        <li class="nav-item me-2">
          <button id="themeToggle" class="btn btn-outline-secondary btn-sm" title="Toggle theme">
            <i class="bi bi-moon"></i>
          </button>
        </li>

        @auth
          {{-- ✅ يظهر فقط إن كان المستخدم أدمن --}}
          @if(auth()->user()->is_admin)
            <li class="nav-item">
              <a class="nav-link {{ request()->is('admin*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-shield-lock"></i> Admin
              </a>
            </li>
          @endif

          <li class="nav-item">
            <a class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" href="{{ route('settings.edit') }}">
              <i class="bi bi-gear"></i> Settings
            </a>
          </li>

          <li class="nav-item">
            <form action="{{ route('signout') }}" method="post" class="ms-2">@csrf
              <button class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Sign out
              </button>
            </form>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Sign up</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

{{-- Main Content --}}
<main class="container pb-5">
  {{-- ✅ Flash messages --}}
  @if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-warning mt-3">{{ session('error') }}</div>
  @endif

  @yield('content')
</main>


{{-- Footer --}}
<footer class="text-center py-4 mt-5">
  <p class="m-0">&copy; {{ date('Y') }} <strong>Tech Care Store</strong> — All rights reserved.</p>
</footer>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Dark/Light Theme Toggle --}}
<script>
(function() {
  const storedTheme = localStorage.getItem('theme');
  const systemPref = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  const currentTheme = storedTheme || systemPref;

  document.documentElement.setAttribute('data-bs-theme', currentTheme);
  const icon = document.querySelector('#themeToggle i');
  icon.className = currentTheme === 'dark' ? 'bi bi-sun' : 'bi bi-moon';

  document.getElementById('themeToggle').addEventListener('click', () => {
    const newTheme = document.documentElement.getAttribute('data-bs-theme') === 'light' ? 'dark' : 'light';
    document.documentElement.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    icon.className = newTheme === 'dark' ? 'bi bi-sun' : 'bi bi-moon';
  });
})();
</script>

{{-- Mini Cart: فتح عند المرور --}}
<script>
document.querySelectorAll('.nav-item.dropdown').forEach(item=>{
  item.addEventListener('mouseenter',()=> {
    const toggle = item.querySelector('[data-bs-toggle="dropdown"]');
    const dd = bootstrap.Dropdown.getOrCreateInstance(toggle);
    dd.show();
  });
  item.addEventListener('mouseleave',()=> {
    const toggle = item.querySelector('[data-bs-toggle="dropdown"]');
    const dd = bootstrap.Dropdown.getOrCreateInstance(toggle);
    dd.hide();
  });
});
</script>
@yield('scripts')

</body>
{{-- Auto-refresh mini-cart after adding product --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartAddForms = document.querySelectorAll('form[action*="cart/add"]');
    cartAddForms.forEach(form => {
        form.addEventListener('submit', function() {
            setTimeout(() => window.location.reload(), 400); // refresh after adding to cart
        });
    });
});
</script>


</html>
