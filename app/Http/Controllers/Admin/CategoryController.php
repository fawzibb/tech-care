<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $categories = Category::when($q, function($query) use ($q){
                $query->where('name','like',"%$q%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:100'],
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
        ]);

        return back()->with('success','Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required','string','max:100'],
        ]);

        $category->update([
            'name' => $request->name,
            // slug ثابت عادة؛ إن أردت تحديثه أزل هذا التعليق:
            // 'slug' => Str::slug($request->name) . '-' . Str::random(5),
        ]);

        return redirect()->route('admin.categories.index')->with('success','Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','Category deleted.');
    }
}
