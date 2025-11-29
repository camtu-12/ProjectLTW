<?php

namespace App\Http\Controllers;

use App\Models\Giohang;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiohangController extends Controller
{
    /**
     * 🛒 Lấy danh sách giỏ hàng (theo người dùng)
     */
    public function index(Request $request)
    {
        $userId = $request->input('user_id') ?? Auth::id();
        if (! $userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

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
        $data = $request->validate([
            'sanpham_id' => 'required|integer|exists:sanphams,id',
            'soluong' => 'sometimes|integer|min:1',
            'user_id' => 'sometimes|integer'
        ]);

        $userId = $request->input('user_id') ?? Auth::id();
        if (! $userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $soluong = $data['soluong'] ?? 1;

        // Lấy giá sản phẩm để tính tổng tiền (hỗ trợ giaban hoặc giagoc)
        $sanpham = Sanpham::findOrFail($data['sanpham_id']);
        $price = $sanpham->giaban ?? $sanpham->giagoc ?? $sanpham->gia ?? 0;
        $tongtien = $price * $soluong;

        // Nếu sản phẩm đã có trong giỏ -> cộng dồn
        $giohang = Giohang::where('user_id', $userId)
            ->where('sanpham_id', $data['sanpham_id'])
            ->first();

        if ($giohang) {
            $giohang->soluong += $soluong;
            $giohang->tongtien = $giohang->soluong * $price;
            $giohang->save();
        } else {
            $giohang = Giohang::create([
                'user_id' => $userId,
                'sanpham_id' => $data['sanpham_id'],
                'soluong' => $soluong,
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
