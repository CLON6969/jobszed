<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->get();
        return view('customer.categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()->with('media','reviews')->paginate(20);
        return view('customer.categories.show', compact('category','products'));
    }
}
