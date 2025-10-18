<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // List all users
    public function users()
    {
        return response()->json(User::with('role')->paginate(12));
    }

    // Approve seller account
    public function approveSeller(User $user)
    {
        $user->update(['account_status' => 'approved']);
        return response()->json(['message' => 'Seller approved']);
    }

    // Manage categories
    public function categories()
    {
        return response()->json(Category::with('children')->get());
    }

    public function createCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = Category::create($request->all());
        return response()->json(['message' => 'Category created', 'category' => $category]);
    }

    // Moderate reviews
    public function reviews()
    {
        return response()->json(Review::with(['user','product'])->paginate(12));
    }

    public function approveReview(Review $review)
    {
        $review->update(['approved' => true]);
        return response()->json(['message' => 'Review approved']);
    }
}
