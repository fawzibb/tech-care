<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Product;;
use App\Models\Category;
class ShopController extends Controller {
  public function index(Request $req){
    $categories = Category::orderBy('name')->get();
    $query = Product::with('category')->latest();
    if($req->filled('category')) {
      $query->whereHas('category', fn($q)=>$q->where('slug',$req->category));
    }
    if($req->filled('q')){
      $q = $req->q;
      $query->where(fn($x)=>$x->where('name','like',"%$q%")->orWhere('description','like',"%$q%"));
    }
    $products = $query->paginate(12)->withQueryString();
    return view('shop.index', compact('products','categories'));
  }
  public function show(Product $product){
    return view('shop.show', compact('product'));
  }
}
