<?php

namespace App\Http\Controllers;

use App\Models\Sanpham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class SanphamController extends Controller
{
    /**
     * 🛍️ Hiển thị danh sách tất cả sản phẩm
     */
    public function index()
    {
        // Always order by `id` desc to ensure newly created records (which may
        // not have `created_at` values) appear on the first page. This avoids
        // inconsistencies when the DB has a `created_at` column but the model
        // doesn't populate it.
        $sanphams = Sanpham::orderBy('id', 'desc')->paginate(12);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($sanphams);
        }

        // Render server-side Blade view instead of Inertia
        return view('admin.products.index', [
            'sanphams' => $sanphams,
        ]);
    }

    /**
     * Hiển thị form tạo sản phẩm (Blade)
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * ➕ Thêm sản phẩm mới
     */
    public function store(Request $request)
    {
        // Log incoming payload for debugging (temporary)
        Log::info('Sanpham::store incoming payload', $request->all());
        // Accept incoming form fields but map to the actual table columns.
        $data = $request->only(['tensanpham', 'masanpham', 'motangan', 'giagoc', 'giaban', 'kichthuoc', 'soluong', 'trangthai', 'danhmuc_id']);

        $request->validate([
            'tensanpham' => 'required|string|max:255',
            'masanpham' => 'required|string|max:50|unique:sanphams,masanpham',
            'giaban' => 'nullable|numeric|min:0',
            'giagoc' => 'nullable|numeric|min:0',
            'motangan' => 'nullable|string',
            'soluong' => 'nullable|integer|min:0',
        ]);

        // Build payload matching actual DB columns. Some databases here don't have
        // `danhmuc_id` (migrations changed), so include it only when present.
        $payload = [
            'tensanpham' => $data['tensanpham'],
            // map short description -> motangan/mota or motangan column
            'motangan' => $data['motangan'] ?? null,
            // masanpham must exist in DB schema (non-nullable). If absent,
            // generate a safe fallback to avoid SQL errors.
            'masanpham' => $data['masanpham'] ?? \Illuminate\Support\Str::slug(($data['tensanpham'] ?? 'sp')) . '-' . substr(uniqid(), -6),
            'giagoc' => isset($data['giagoc']) ? $data['giagoc'] : 0,
            'giaban' => isset($data['giaban']) ? $data['giaban'] : 0,
            'kichthuoc' => $data['kichthuoc'] ?? null,
            'soluong' => $data['soluong'] ?? 0,
            'trangthai' => $data['trangthai'] ?? 'danghoatdong',
        ];

        // If the sanphams table still has danhmuc_id, set it (create default if needed)
        if (Schema::hasColumn('sanphams', 'danhmuc_id')) {
            $danhmucId = $data['danhmuc_id'] ?? null;
            if (!$danhmucId) {
                $danhmucId = DB::table('danhmucs')->value('id');
                if (!$danhmucId) {
                    $danhmucId = DB::table('danhmucs')->insertGetId([
                        'tendanhmuc' => 'Chung',
                        'mota' => 'Danh mục mặc định',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            $payload['danhmuc_id'] = $danhmucId;
        }

        $sanpham = Sanpham::create($payload);

        // If request expects JSON keep JSON response (API clients), otherwise redirect back to index
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Thêm sản phẩm thành công!',
                'data' => $sanpham
            ], 201);
        }

    // Redirect explicitly to page 1 so the newly created product appears
    // on the first page of the listing (avoid staying on a different page).
    return Redirect::route('admin.products.index', ['page' => 1])->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Xem chi tiết 1 sản phẩm
     */
    public function show($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        return response()->json($sanpham);
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        $sanpham = Sanpham::findOrFail($id);

        $validated = $request->validate([
            'tensanpham' => 'required|string|max:255',
            'masanpham' => 'required|string|max:50|unique:sanphams,masanpham,' . $id,
            'motangan' => 'required|string',
            'giagoc' => 'required|numeric|min:0',
            'giaban' => 'required|numeric|min:0',
            'kichthuoc' => 'nullable|string|max:20',
            'soluong' => 'required|integer|min:0',
            'trangthai' => 'required|in:danghoatdong,ngungkinhdoanh',
        ]);

        $sanpham->update($validated);

        return response()->json([
            'message' => 'Cập nhật sản phẩm thành công!',
            'data' => $sanpham
        ]);
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        $sanpham->delete();

        return response()->json(['message' => 'Xóa sản phẩm thành công!']);
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search(Request $request)
    {
        $search = $request->get('search');

        $sanphams = Sanpham::where('tensanpham', 'like', "%{$search}%")
            ->orWhere('masanpham', 'like', "%{$search}%")
            ->orWhere('motangan', 'like', "%{$search}%")
            ->get();

        return response()->json($sanphams);
    }
}