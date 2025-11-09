<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductMedia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * عرض صفحة المنتجات
     */
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

    /**
     * إنشاء منتج جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required','string','max:150'],
            'price'       => ['required','numeric','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'media.*'     => ['nullable','file','max:10240'], // صور أو فيديوهات حتى 10MB
            'description' => ['nullable','string'],
        ]);

        // إنشاء المنتج
        $product = Product::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name).'-'.Str::random(5),
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        // تخزين الوسائط المتعددة
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('products', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
                $product->media()->create(['path' => $path, 'type' => $type]);
            }
        }

        return back()->with('success','✅ Product created successfully.');
    }

    /**
     * تعديل منتج
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('media');
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * تحديث بيانات المنتج
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => ['required','string','max:150'],
            'price'       => ['required','numeric','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'media.*'     => ['nullable','file','max:10240'],
            'description' => ['nullable','string'],
        ]);

        // تحديث البيانات الأساسية
        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        // إضافة ملفات جديدة
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('products', 'public');
                $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
                $product->media()->create(['path' => $path, 'type' => $type]);
            }
        }

        return redirect()->route('admin.products.edit', $product)
                         ->with('success','✅ Product updated successfully.');
    }

    /**
     * حذف منتج كامل مع وسائطه
     */
    public function destroy(Product $product)
    {
        foreach ($product->media as $media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }

        $product->delete();
        return back()->with('success','🗑️ Product deleted.');
    }

    /**
     * حذف صورة أو فيديو واحد من المنتج
     */
    public function deleteMedia(ProductMedia $media)
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();

        return back()->with('success', '🧹 Media removed successfully.');
    }
public function updateMedia(Request $request, ProductMedia $media)
{
    $request->validate([
        'file' => ['required','file','max:10240', 'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/webm,video/ogg'],
    ]);

    // احذف القديم
    \Storage::disk('public')->delete($media->path);

    // خزّن الجديد
    $path = $request->file('file')->store('products', 'public');
    $type = str_starts_with($request->file('file')->getMimeType(), 'video') ? 'video' : 'image';

    // حدّث السجل
    $media->update([
        'path' => $path,
        'type' => $type,
    ]);

    return back()->with('success', '✅ Media updated.');
}



}
