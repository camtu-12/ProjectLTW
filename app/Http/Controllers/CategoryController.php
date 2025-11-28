<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sanpham;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display the category page (by slug).
     */
    public function show(string $slug)
    {
        // For now, fetch a small sample of products to display. Later this
        // should be replaced by a proper query filtering by category slug.
        $products = Sanpham::select('id', 'tensanpham', 'motangan', 'giaban')
            ->take(12)
            ->get();

        return Inertia::render('Khachhang/Category', [
            'slug' => $slug,
            'products' => $products,
        ]);
    }
}
