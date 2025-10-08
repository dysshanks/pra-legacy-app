<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('brands')->orderBy('name')->get();
        return view('pages.categories_list', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::with('brands')->findOrFail($id);
        return view('pages.product_category_brands', compact('category'));
    }
}
