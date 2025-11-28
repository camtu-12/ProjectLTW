<?php

namespace App\Http\Controllers;

use App\Models\Sanpham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
    // Log incoming payload for debugging
    Log::info('Sanpham::store incoming payload', $request->all());
    
    // Validation rules với hình ảnh (ảnh không bắt buộc)
    $validated = $request->validate([
        'tensanpham' => 'required|string|max:255',
        'masanpham' => 'required|string|max:50|unique:sanphams,masanpham',
        'giaban' => 'nullable|numeric|min:0',
        'giagoc' => 'nullable|numeric|min:0',
        'motangan' => 'nullable|string',
        'soluong' => 'nullable|integer|min:0',
        'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Xử lý upload ảnh nếu có
    if ($request->hasFile('hinhanh')) {
        $image = $request->file('hinhanh');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('products', $imageName, 'public');
        $validated['hinhanh'] = $imagePath;
        Log::info('Image uploaded successfully:', ['path' => $imagePath]);
    }

    // Build payload
    $payload = [
        'tensanpham' => $validated['tensanpham'],
        'motangan' => $validated['motangan'] ?? null,
        'masanpham' => $validated['masanpham'],
        'giagoc' => $validated['giagoc'] ?? 0,
        'giaban' => $validated['giaban'] ?? 0,
        'kichthuoc' => $request->kichthuoc ?? null,
        'soluong' => $validated['soluong'] ?? 0,
        'trangthai' => $request->trangthai ?? 'danghoatdong',
    ];

    // Nếu có ảnh upload thì thêm vào payload
    if (isset($validated['hinhanh'])) {
        $payload['hinhanh'] = $validated['hinhanh'];
    }

    // If the sanphams table still has danhmuc_id, set it
    if (Schema::hasColumn('sanphams', 'danhmuc_id')) {
        $danhmucId = $request->danhmuc_id ?? null;
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

    try {
        $sanpham = Sanpham::create($payload);
        Log::info('Product created successfully:', $sanpham->toArray());

        return redirect()->route('admin.products.index', ['page' => 1])
            ->with('success', 'Thêm sản phẩm thành công!');

    } catch (\Exception $e) {
        Log::error('Error creating product:', ['error' => $e->getMessage()]);
        return redirect()->back()
            ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
            ->withInput();
    }
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
     * Hiển thị form chỉnh sửa sản phẩm (Blade)
     */
    public function edit($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        return view('admin.products.edit', compact('sanpham'));
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
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Thêm validation cho ảnh
        ]);

        // Xử lý upload ảnh mới nếu có
        if ($request->hasFile('hinhanh')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($sanpham->hinhanh && Storage::disk('public')->exists($sanpham->hinhanh)) {
                Storage::disk('public')->delete($sanpham->hinhanh);
            }

            $image = $request->file('hinhanh');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $hinhanhPath = $image->storeAs('products', $imageName, 'public');
            $validated['hinhanh'] = $hinhanhPath;
        }

        $sanpham->update($validated);

        // If AJAX/JSON requested, return JSON; otherwise redirect back to list
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'message' => 'Cập nhật sản phẩm thành công!',
                'data' => $sanpham
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy($id)
    {
        $sanpham = Sanpham::findOrFail($id);
        
        // Xóa ảnh đính kèm nếu có
        if ($sanpham->hinhanh && Storage::disk('public')->exists($sanpham->hinhanh)) {
            Storage::disk('public')->delete($sanpham->hinhanh);
        }
        
        $sanpham->delete();

        // Nếu yêu cầu AJAX/JSON thì trả JSON, ngược lại redirect về trang danh sách với flash message
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json(['message' => 'Xóa sản phẩm thành công!']);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
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