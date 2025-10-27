<?php

namespace App\Http\Controllers;

use App\Models\Sanpham;
use Illuminate\Http\Request;

class SanphamController extends Controller
{
    /**
     * 🛍️ Hiển thị danh sách tất cả sản phẩm
     */
    public function index()
    {
        $sanphams = Sanpham::with('danhmuc')->get();
        return response()->json($sanphams);
    }

    /**
     * ➕ Thêm sản phẩm mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'danhmuc_id' => 'required|exists:danhmucs,id',
            'tensanpham' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'hinhanh' => 'nullable|string',
            'mota' => 'nullable|string',
            'soluong' => 'required|integer|min:0',
        ]);

        $sanpham = Sanpham::create($validated);

        return response()->json([
            'message' => 'Thêm sản phẩm thành công!',
            'data' => $sanpham
        ], 201);
    }

    /**
     * Xem chi tiết 1 sản phẩm
     */
    public function show($id)
    {
        $sanpham = Sanpham::with('danhmuc')->findOrFail($id);
        return response()->json($sanpham);
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, $id)
    {
        $sanpham = Sanpham::findOrFail($id);

        $validated = $request->validate([
            'danhmuc_id' => 'required|exists:danhmucs,id',
            'tensanpham' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'hinhanh' => 'nullable|string',
            'mota' => 'nullable|string',
            'soluong' => 'required|integer|min:0',
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
}
