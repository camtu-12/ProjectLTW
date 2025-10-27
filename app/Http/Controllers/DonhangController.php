<?php

namespace App\Http\Controllers;

use App\Models\donhang;
use Illuminate\Http\Request;

class DonhangController extends Controller
{
    /**
     * Hiển thị danh sách tất cả đơn hàng.
     */
    public function index()
    {
        $donhangs = donhang::with('chitietdonhangs')->get();
        return response()->json($donhangs);
    }

    /**
     * Lưu đơn hàng mới (người dùng đặt hàng).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'tongtien' => 'required|numeric|min:0',
            'trangthai' => 'nullable|string|max:100',
        ]);

        $donhang = donhang::create([
            'user_id' => $validated['user_id'],
            'tongtien' => $validated['tongtien'],
            'trangthai' => $validated['trangthai'] ?? 'Chờ xử lý',
        ]);

        return response()->json([
            'message' => 'Tạo đơn hàng thành công!',
            'data' => $donhang
        ], 201);
    }

    /**
     * Hiển thị chi tiết 1 đơn hàng.
     */
    public function show($id)
    {
        $donhang = donhang::with('chitietdonhangs')->findOrFail($id);
        return response()->json($donhang);
    }

    /**
     * Cập nhật thông tin đơn hàng (ví dụ đổi trạng thái).
     */
    public function update(Request $request, $id)
    {
        $donhang = donhang::findOrFail($id);

        $validated = $request->validate([
            'trangthai' => 'required|string|max:100',
        ]);

        $donhang->update($validated);

        return response()->json([
            'message' => 'Cập nhật đơn hàng thành công!',
            'data' => $donhang
        ]);
    }

    /**
     * Xóa đơn hàng.
     */
    public function destroy($id)
    {
        $donhang = donhang::findOrFail($id);
        $donhang->delete();

        return response()->json([
            'message' => 'Đơn hàng đã được xóa thành công!'
        ]);
    }
}
