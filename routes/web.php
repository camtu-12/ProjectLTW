<?php

use App\Http\Controllers\KhachhangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SanphamController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard — tự động chuyển trang Vue theo vai trò (so sánh không phân biệt hoa/thường)
Route::get('/dashboard', function () {
    /** @var User|null $user */
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }
    switch ($user->role) {
        case 'Admin':
            return Inertia::render('Admin/Index', ['user' => $user]);
        case 'Khachhang':
            return Inertia::render('Khachhang/Index', ['user' => $user]);
        default:
            return Inertia::render('Khachhang/Index', ['user' => $user]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

//Logout route 
Route::post('/logout', function (Request $request) {
    Auth::logout(); // Đăng xuất user

    // Xóa session & regenerate token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Quay về trang login
    return redirect()->route('login');
})->name('logout');

Route::resource('khachhang', KhachhangController::class)->middleware(['auth', 'verified']);

// ==================== ROUTES CHO QUẢN LÝ SẢN PHẨM ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    
    // Routes cho sản phẩm
    Route::prefix('products')->name('products.')->group(function () {
        // Hiển thị danh sách sản phẩm
        Route::get('/', [SanphamController::class, 'index'])->name('index');
        
        // Form thêm sản phẩm
        Route::get('/create', [SanphamController::class, 'create'])->name('create');
        
        // Lưu sản phẩm mới
        Route::post('/', [SanphamController::class, 'store'])->name('store');
        
        // Hiển thị chi tiết sản phẩm
        Route::get('/{id}', [SanphamController::class, 'show'])->name('show');
        
        // Form chỉnh sửa sản phẩm
        Route::get('/{id}/edit', [SanphamController::class, 'edit'])->name('edit');
        
        // Cập nhật sản phẩm
        Route::put('/{id}', [SanphamController::class, 'update'])->name('update');
        Route::patch('/{id}', [SanphamController::class, 'update']); // Thêm patch method
        
        // Xóa sản phẩm
        Route::delete('/{id}', [SanphamController::class, 'destroy'])->name('destroy');
        
        // Tìm kiếm sản phẩm
        Route::get('/search', [SanphamController::class, 'search'])->name('search');
        
        // Sao chép sản phẩm
        Route::post('/{id}/copy', [SanphamController::class, 'copy'])->name('copy');
    });
});

Route::resource('admin', AdminController::class)->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';