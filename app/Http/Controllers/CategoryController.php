<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Sanpham;
use App\Models\danhmuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class CategoryController extends Controller
{
    /**
     * Display the category page (by slug).
     */
    public function show(string $slug)
    {
        // Try to resolve the category by slugifying the stored name.
        $danhmuc = danhmuc::all()->firstWhere(function ($d) use ($slug) {
            return Str::slug($d->tendanhmuc) === $slug;
        });

        if (! $danhmuc) {
            abort(404);
        }

        // Query products for the category and paginate them.
        // Some installations may have a different schema (missing danhmuc_id or hinhanh).
        // Detect columns and fall back to a keyword search so the category page still renders.
        if (Schema::hasColumn('sanphams', 'danhmuc_id')) {
            $products = Sanpham::where('danhmuc_id', $danhmuc->id)
                ->select('id', 'tensanpham', 'motangan', Schema::hasColumn('sanphams', 'giaban') ? 'giaban' : (Schema::hasColumn('sanphams', 'giagoc') ? 'giagoc' : 'giagoc') , Schema::hasColumn('sanphams', 'hinhanh') ? 'hinhanh' : null, 'soluong')
                ->orderByDesc('id')
                ->get();
        } else {
            // Fallback: search by keyword derived from the category slug/name (e.g. 'Thun' for 'ao-thun-nu')
            $keyword = 'Thun';
            if (Str::contains(strtolower($danhmuc->tendanhmuc), 'thun')) {
                $keyword = 'Thun';
            } elseif (Str::contains(strtolower($danhmuc->tendanhmuc), 'sơ mi') || Str::contains(strtolower($danhmuc->tendanhmuc), 'so mi')) {
                $keyword = 'Sơ Mi';
            } elseif (Str::contains(strtolower($danhmuc->tendanhmuc), 'vay')) {
                $keyword = 'Váy';
            }

            // select safe columns that exist
            $select = ['id', 'tensanpham'];
            if (Schema::hasColumn('sanphams', 'giagoc')) $select[] = 'giagoc';
            if (Schema::hasColumn('sanphams', 'giaban')) $select[] = 'giaban';

            $products = Sanpham::where('tensanpham', 'like', "%{$keyword}%")
                ->select($select)
                ->orderByDesc('id')
                ->get();
        }

        // Normalize image URL for each product (use storage link or fallback image).
        // If no products found for this category, fall back to showing ALL products from DB
        if ($products->isEmpty()) {
            $select = ['id', 'tensanpham'];
            if (Schema::hasColumn('sanphams', 'giagoc')) $select[] = 'giagoc';
            if (Schema::hasColumn('sanphams', 'giaban')) $select[] = 'giaban';
            if (Schema::hasColumn('sanphams', 'hinhanh')) $select[] = 'hinhanh';

            $products = Sanpham::select($select)->orderByDesc('id')->get();
        }

        $products = $products->map(function ($p) {
            // determine image URL safely (some products may not have hinhanh column)
            $img = asset('images/placeholder.svg');
            if (isset($p->hinhanh) && $p->hinhanh) {
                $imgPath = storage_path('app/public/' . ltrim($p->hinhanh, '/'));
                if ($imgPath && file_exists($imgPath)) {
                    $img = asset('storage/' . ltrim($p->hinhanh, '/'));
                }
            }

            // determine price field (giaban preferred)
            $price = $p->giaban ?? $p->giagoc ?? $p->gia ?? null;

            return [
                'id' => $p->id,
                'title' => $p->tensanpham ?? ($p->title ?? null),
                'description' => $p->motangan ?? null,
                'price' => $price,
                'quantity' => $p->soluong ?? null,
                'hinhanh' => $p->hinhanh ?? null,
                'img' => $img,
            ];
        });

        return Inertia::render('Khachhang/Category', [
            'slug' => $slug,
            'danhmuc' => [
                'id' => $danhmuc->id,
                'tendanhmuc' => $danhmuc->tendanhmuc,
                'slug' => $slug,
            ],
            'products' => $products,
        ]);
    }
}
