<?php

namespace App\Http\Controllers;

use App\Models\Giohang;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        // Normalize image paths to full URLs so frontend can use them directly.
        $giohang = $giohang->map(function ($ci) {
            // Normalize sanpham->hinhanh to a full storage URL when present
            if ($ci->sanpham && isset($ci->sanpham->hinhanh) && $ci->sanpham->hinhanh) {
                $ci->sanpham->hinhanh = asset('storage/' . ltrim($ci->sanpham->hinhanh, '\/'));
            }

            // If the giohang row has its own hinhanh, prefer that; otherwise fall back to sanpham->hinhanh
            if (isset($ci->hinhanh) && $ci->hinhanh) {
                $ci->hinhanh = asset('storage/' . ltrim($ci->hinhanh, '\/'));
            } else {
                $ci->hinhanh = ($ci->sanpham && isset($ci->sanpham->hinhanh)) ? $ci->sanpham->hinhanh : null;
            }

            return $ci;
        });

        return response()->json($giohang);
    }

    /**
     * ➕ Thêm sản phẩm vào giỏ hàng
     */
    public function store(Request $request)
    {
        // Debug log: record incoming add-to-cart requests
        try {
            Log::info('Giohang::store incoming', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
                'payload' => $request->all(),
            ]);
        } catch (\Exception $e) {
            // ignore logging failure
        }
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
        // We persist unit price and product image into the giohang row (schema uses `giaban` and `hinhanh`)
        $hinhanh = $sanpham->hinhanh ?? null;

        // Nếu sản phẩm đã có trong giỏ -> cộng dồn
        $giohang = Giohang::where('user_id', $userId)
            ->where('sanpham_id', $data['sanpham_id'])
            ->first();

        if ($giohang) {
            // Increment quantity and ensure the stored unit price / image are present
            $giohang->soluong += $soluong;
            $giohang->giaban = $giohang->giaban ?? $price;
            $giohang->hinhanh = $giohang->hinhanh ?? $hinhanh;
            $giohang->save();
        } else {
            // Create a new giohang row using the DB schema fields (giaban, hinhanh)
            $giohang = Giohang::create([
                'user_id' => $userId,
                'sanpham_id' => $data['sanpham_id'],
                'soluong' => $soluong,
                'giaban' => $price,
                'hinhanh' => $hinhanh,
            ]);
        }

        try {
            Log::info('Giohang::store result', ['giohang_id' => $giohang->id, 'user_id' => $giohang->user_id, 'sanpham_id' => $giohang->sanpham_id, 'soluong' => $giohang->soluong]);
        } catch (\Exception $e) {}

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
        try {
            Log::info('Giohang::update incoming', [
                'user_id' => Auth::id(),
                'ip' => $request->ip(),
                'id' => $id,
                'payload' => $request->all(),
            ]);
        } catch (\Exception $e) {}

        $validated = $request->validate([
            'soluong' => 'required|integer|min:1',
        ]);

        $giohang = Giohang::findOrFail($id);
        $sanpham = $giohang->sanpham;

        $giohang->soluong = $validated['soluong'];
        // Ensure unit price is set on row (prefer existing stored price, fallback to product price)
        $giohang->giaban = $giohang->giaban ?? ($sanpham->giaban ?? $sanpham->giagoc ?? $sanpham->gia ?? null);
        $giohang->save();

        try {
            Log::info('Giohang::update result', ['giohang_id' => $giohang->id, 'soluong' => $giohang->soluong]);
        } catch (\Exception $e) {}

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
