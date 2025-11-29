<?php

use App\Http\Controllers\KhachhangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SanphamController;
use App\Models\User;
use App\Models\Sanpham;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Http\Request;

// Trang chủ
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Dashboard — tự động chuyển trang theo role
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
            // Lấy sản phẩm bán chạy (lấy 4 sản phẩm cuối từ DB)
            $best = Sanpham::orderByDesc('id')->take(4)->get()->map(function($p){
                $imgPath = $p->hinhanh ? storage_path('app/public/' . ltrim($p->hinhanh, '/')) : null;
                $imgUrl = ($imgPath && file_exists($imgPath))
                    ? asset('storage/' . ltrim($p->hinhanh, '/'))
                    : asset('images/placeholder.svg');

                return [
                    'id' => $p->id,
                    'title' => $p->tensanpham,
                    'price' => $p->giaban ?? $p->giagoc ?? null,
                    'img' => $imgUrl,
                ];
            });

            return Inertia::render('Khachhang/Index', ['user' => $user, 'bestSeller' => $best]);
        default:
            $best = Sanpham::orderByDesc('id')->take(4)->get()->map(function($p){
                $imgPath = $p->hinhanh ? storage_path('app/public/' . ltrim($p->hinhanh, '/')) : null;
                $imgUrl = ($imgPath && file_exists($imgPath))
                    ? asset('storage/' . ltrim($p->hinhanh, '/'))
                    : asset('images/placeholder.svg');

                return [
                    'id' => $p->id,
                    'title' => $p->tensanpham,
                    'price' => $p->giaban ?? $p->giagoc ?? null,
                    'img' => $imgUrl,
                ];
            });
            return Inertia::render('Khachhang/Index', ['user' => $user, 'bestSeller' => $best]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::resource('khachhang', KhachhangController::class)->middleware(['auth', 'verified']);

// ==================== ROUTES CHO ADMIN QUẢN LÝ SẢN PHẨM ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    
    // Routes cho sản phẩm
    Route::prefix('products')->name('products.')->group(function () {
        
        Route::get('/', [SanphamController::class, 'index'])->name('index');
        Route::get('/create', [SanphamController::class, 'create'])->name('create');
        Route::post('/', [SanphamController::class, 'store'])->name('store');
        Route::get('/{id}', [SanphamController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SanphamController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SanphamController::class, 'update'])->name('update');
        Route::patch('/{id}', [SanphamController::class, 'update']); 
        Route::delete('/{id}', [SanphamController::class, 'destroy'])->name('destroy');

        // Tìm kiếm sản phẩm
        Route::get('/search', [SanphamController::class, 'search'])->name('search');

        // Sao chép sản phẩm
        Route::post('/{id}/copy', [SanphamController::class, 'copy'])->name('copy');
    });

    // Admin settings
    Route::get('/settings', [\App\Http\Controllers\AdminSettingsController::class, 'edit'])->name('settings');
    Route::post('/settings', [\App\Http\Controllers\AdminSettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/password', [\App\Http\Controllers\AdminSettingsController::class, 'updatePassword'])->name('settings.password');
});

Route::resource('admin', AdminController::class)->middleware(['auth', 'verified']);

// ==================== ROUTE CHO DANH MỤC SẢN PHẨM ====================
use App\Http\Controllers\CategoryController;
Route::get('/danh-muc/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Routes for shopping cart (giohang)
use App\Http\Controllers\GiohangController;
Route::middleware(['auth'])->group(function () {
    Route::get('/giohang', [GiohangController::class, 'index'])->name('giohang.index');
    Route::post('/giohang', [GiohangController::class, 'store'])->name('giohang.store');
    Route::patch('/giohang/{id}', [GiohangController::class, 'update'])->name('giohang.update');
    Route::delete('/giohang/{id}', [GiohangController::class, 'destroy'])->name('giohang.destroy');
    Route::get('/giohang/clear/{user_id}', [GiohangController::class, 'clear'])->name('giohang.clear');
});

// Auth
require __DIR__.'/auth.php';
