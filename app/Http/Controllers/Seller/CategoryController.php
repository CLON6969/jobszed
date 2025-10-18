<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories (hierarchical).
     */
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('Seller.categories.index', compact('categories'));
    }

    /**
     * Show form to create a new category.
     */
    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('Seller.categories.create', compact('parents'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($request->name);

        $data = $request->only('name', 'description', 'parent_id');
        $data['slug'] = $slug;

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('category_icons', 'public');
        }

        Category::create($data);

        return redirect()->route('Seller.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display a single category.
     */
    public function show(Category $category)
    {
        $category->load('children', 'parent', 'products');
        return view('Seller.categories.show', compact('category'));
    }

    /**
     * Edit a category.
     */
    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('Seller.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update a category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'icon' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'description', 'parent_id');
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('category_icons', 'public');
        }

        $category->update($data);

        return redirect()->route('Seller.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Delete a category.
     */
    public function destroy(Category $category)
    {
        if ($category->children()->count()) {
            return back()->withErrors(['error' => 'Please delete subcategories first.']);
        }

        $category->delete();

        return redirect()->route('Seller.categories.index')->with('success', 'Category deleted successfully.');
    }
}
