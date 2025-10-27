<?php

namespace App\Http\Controllers;

use App\Models\Giohang;
use App\Models\Sanpham;
use Illuminate\Http\Request;

class GiohangController extends Controller
{
    /**
     * 🛒 Lấy danh sách giỏ hàng (theo người dùng)
     */
    public function index(Request $request)
    {
        $userId = $request->user_id; // hoặc Auth::id() nếu đã đăng nhập
        $giohang = Giohang::with('sanpham')
            ->where('user_id', $userId)
            ->get();

        return response()->json($giohang);
    }

    /**
     * ➕ Thêm sản phẩm vào giỏ hàng
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'sanpham_id' => 'required|integer|exists:sanphams,id',
            'soluong' => 'required|integer|min:1',
        ]);

        // Lấy giá sản phẩm để tính tổng tiền
        $sanpham = Sanpham::findOrFail($validated['sanpham_id']);
        $tongtien = $sanpham->gia * $validated['soluong'];

        // Nếu sản phẩm đã có trong giỏ -> cộng dồn
        $giohang = Giohang::where('user_id', $validated['user_id'])
            ->where('sanpham_id', $validated['sanpham_id'])
            ->first();

        if ($giohang) {
            $giohang->soluong += $validated['soluong'];
            $giohang->tongtien = $giohang->soluong * $sanpham->gia;
            $giohang->save();
        } else {
            $giohang = Giohang::create([
                'user_id' => $validated['user_id'],
                'sanpham_id' => $validated['sanpham_id'],
                'soluong' => $validated['soluong'],
                'tongtien' => $tongtien,
            ]);
        }

        return response()->json([
            'message' => 'Đã thêm sản phẩm vào giỏ hàng thành công!',
            'data' => $giohang
        ], 201);
    }

    /**
     * 📦 Xem chi tiết 1 sản phẩm trong giỏ hàng
     */
    public function show($id)
    {
        $giohang = Giohang::with('sanpham')->findOrFail($id);
        return response()->json($giohang);
    }

    /**
     * ✏️ Cập nhật số lượng sản phẩm trong giỏ
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'soluong' => 'required|integer|min:1',
        ]);

        $giohang = Giohang::findOrFail($id);
        $sanpham = $giohang->sanpham;

        $giohang->soluong = $validated['soluong'];
        $giohang->tongtien = $giohang->soluong * $sanpham->gia;
        $giohang->save();

        return response()->json([
            'message' => 'Cập nhật giỏ hàng thành công!',
            'data' => $giohang
        ]);
    }

    /**
     * 🗑️ Xóa sản phẩm khỏi giỏ hàng
     */
    public function destroy($id)
    {
        $giohang = Giohang::findOrFail($id);
        $giohang->delete();

        return response()->json(['message' => 'Đã xóa sản phẩm khỏi giỏ hàng!']);
    }

    /**
     * 🧹 Xóa toàn bộ giỏ hàng (nếu cần)
     */
    public function clear($user_id)
    {
        Giohang::where('user_id', $user_id)->delete();
        return response()->json(['message' => 'Đã xóa toàn bộ giỏ hàng!']);
    }
}
