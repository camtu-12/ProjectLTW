<?php

namespace App\Http\Controllers;

use App\Models\Khachhang;
use Illuminate\Http\Request;

class KhachhangController extends Controller
{
    // Lấy danh sách khách hàng
    public function index()
    {
        return response()->json(Khachhang::all());
    }

    // Thêm khách hàng mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'ten' => 'required|string|max:255',
            'sdt' => 'nullable|string|max:20',
            'diachi' => 'nullable|string|max:255',
            'gioitinh' => 'nullable|string|max:10',
            'ngaysinh' => 'nullable|date',
        ]);

        $khachhang = Khachhang::create($validated);

        return response()->json([
            'message' => 'Thêm khách hàng thành công!',
            'data' => $khachhang
        ], 201);
    }

    // Hiển thị thông tin 1 khách hàng
    public function show($id)
    {
        $khachhang = Khachhang::findOrFail($id);
        return response()->json($khachhang);
    }

    // Cập nhật khách hàng
    public function update(Request $request, $id)
    {
        $khachhang = Khachhang::findOrFail($id);

        $validated = $request->validate([
            'ten' => 'sometimes|required|string|max:255',
            'sdt' => 'nullable|string|max:20',
            'diachi' => 'nullable|string|max:255',
            'gioitinh' => 'nullable|string|max:10',
            'ngaysinh' => 'nullable|date',
        ]);

        $khachhang->update($validated);

        return response()->json([
            'message' => 'Cập nhật thông tin khách hàng thành công!',
            'data' => $khachhang
        ]);
    }

    // Xóa khách hàng
    public function destroy($id)
    {
        $khachhang = Khachhang::findOrFail($id);
        $khachhang->delete();

        return response()->json(['message' => 'Đã xóa khách hàng!']);
    }
}
