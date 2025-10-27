<?php

namespace App\Http\Controllers;

use App\Models\Chitietdonhang;
use Illuminate\Http\Request;

class ChitietdonhangController extends Controller
{
    /**
     * 🧾 Hiển thị danh sách toàn bộ chi tiết đơn hàng
     */
    public function index()
    {
        $chitiets = Chitietdonhang::with(['donhang', 'sanpham'])->get();
        return response()->json($chitiets);
    }

    /**
     * ➕ Thêm mới chi tiết đơn hàng
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donhang_id' => 'required|exists:donhangs,id',
            'sanpham_id' => 'required|exists:sanphams,id',
            'soluong'    => 'required|integer|min:1',
            'gia'        => 'required|numeric|min:0',
        ]);

        $chitiet = Chitietdonhang::create($validated);

        return response()->json([
            'message' => 'Thêm chi tiết đơn hàng thành công!',
            'data' => $chitiet
        ], 201);
    }

    /**
     * 🔍 Xem chi tiết 1 bản ghi cụ thể
     */
    public function show($id)
    {
        $chitiet = Chitietdonhang::with(['donhang', 'sanpham'])->findOrFail($id);
        return response()->json($chitiet);
    }

    /**
     * ✏️ Cập nhật chi tiết đơn hàng
     */
    public function update(Request $request, $id)
    {
        $chitiet = Chitietdonhang::findOrFail($id);

        $validated = $request->validate([
            'soluong' => 'required|integer|min:1',
            'gia'     => 'required|numeric|min:0',
        ]);

        $chitiet->update($validated);

        return response()->json([
            'message' => 'Cập nhật chi tiết đơn hàng thành công!',
            'data' => $chitiet
        ]);
    }

    /**
     * 🗑️ Xóa chi tiết đơn hàng
     */
    public function destroy($id)
    {
        $chitiet = Chitietdonhang::findOrFail($id);
        $chitiet->delete();

        return response()->json(['message' => 'Xóa chi tiết đơn hàng thành công!']);
    }
}
