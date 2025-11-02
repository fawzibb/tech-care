<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
public function show(Product $product)
{
    // حفظ المنتجات المشاهدة في السيشن
    $viewed = session()->get('recently_viewed', []);

    // إذا لم يكن المنتج موجود، أضفه في البداية
    $viewed = array_diff($viewed, [$product->id]);
    array_unshift($viewed, $product->id);

    // نحتفظ فقط بآخر 6 منتجات
    session(['recently_viewed' => array_slice($viewed, 0, 6)]);

    return view('shop.show', compact('product'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
