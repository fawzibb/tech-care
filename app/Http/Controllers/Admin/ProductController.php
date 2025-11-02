<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $cat = $request->get('category');

        $products = Product::with('category')
            ->when($q, function($query) use ($q){
                $query->where(function($x) use ($q){
                    $x->where('name','like',"%$q%")
                      ->orWhere('description','like',"%$q%");
                });
            })
            ->when($cat, function($query) use ($cat){
                $query->whereHas('category', fn($c)=>$c->where('slug',$cat));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products','categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required','string','max:150'],
            'price'       => ['required','numeric','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'image'       => ['nullable','image','max:2048'],
            'description' => ['nullable','string'],
        ]);

        $path = $request->file('image')?->store('products','public');

        Product::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name).'-'.Str::random(5),
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'image'       => $path,
            'description' => $request->description,
        ]);

        return back()->with('success','Product created.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => ['required','string','max:150'],
            'price'       => ['required','numeric','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'image'       => ['nullable','image','max:2048'],
            'description' => ['nullable','string'],
        ]);

        $data = $request->only('name','price','category_id','description');

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products','public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success','Product updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();
        return back()->with('success','Product deleted.');
    }
}
