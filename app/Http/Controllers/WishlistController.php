<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        $products = Product::whereIn('id', array_keys($wishlist))->get();
        return view('wishlist.index', compact('products'));
    }

    public function add(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error','Please login to use wishlist.');
        }

        $wishlist = session()->get('wishlist', []);
        $wishlist[$product->id] = true;
        session(['wishlist' => $wishlist]);

        return back()->with('success','Added to wishlist.');
    }

    public function remove(Product $product)
    {
        $wishlist = session()->get('wishlist', []);
        unset($wishlist[$product->id]);
        session(['wishlist' => $wishlist]);

        return back()->with('success','Removed from wishlist.');
    }
}
