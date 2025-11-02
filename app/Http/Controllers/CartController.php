<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;   // ✅ هذا السطر مهم جدًا

class CartController extends Controller
{
    private function cart() { return session()->get('cart', []); }

    public function index()
    {
        $cart = $this->cart();
        $total = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
        return view('cart.index', compact('cart', 'total'));
    }

public function add(Product $product)
{
    // 🔒 إذا لم يكن المستخدم مسجّل دخول
    if (!auth()->check()) {
        // نحفظ المسار الحالي حتى نعيد المستخدم إليه بعد تسجيل الدخول
        session(['intended_url' => url()->previous()]);

        // نعيده لصفحة تسجيل الدخول برسالة تحفيزية
        return redirect()->route('login')->with('error', 'Please log in to add products to your cart.');
    }

    // ✅ في حال كان مسجّل دخول، نكمل عملية الإضافة
    $cart = session()->get('cart', []);

    if (isset($cart[$product->id])) {
        $cart[$product->id]['qty']++;
    } else {
        $cart[$product->id] = [
            'name'  => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'qty'   => 1,
        ];
    }

    session(['cart' => $cart]);

    return redirect()->back()->with('success', 'Added to cart.');
}


    public function update(Request $r, Product $product)
    {
        $r->validate(['qty' => 'required|integer|min:1|max:99']);
        $cart = $this->cart();
        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] = $r->qty;
        }
        session(['cart' => $cart]);
        return back();
    }

    public function remove(Product $product)
    {
        $cart = $this->cart();
        unset($cart[$product->id]);
        session(['cart' => $cart]);
        return back();
    }

    public function clear()
    {
        session()->forget('cart');
        return back();
    }

    public function dropdown()
{
    $cart = session('cart', []);
    $cartCount = count($cart);
    $cartTotal = collect($cart)->sum(fn($i) => $i['price'] * $i['qty']);
    return view('partials.cart-dropdown', compact('cart', 'cartCount', 'cartTotal'));
}

}
