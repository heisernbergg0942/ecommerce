<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('featured', true)->with('category')->take(8)->get();
        $categories = Category::withCount('products')->get();
        return view('home', compact('featuredProducts', 'categories'));
    }
}
