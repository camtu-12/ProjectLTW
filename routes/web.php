<?php

use App\Http\Controllers\KhachhangController;
use App\Http\Controllers\AdminController;
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

// Explicit product pages so `/admin/products` is not captured by the `admin` resource wildcard
use App\Http\Controllers\SanphamController;

Route::get('/admin/products', [SanphamController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.products.index');

Route::get('/admin/products/create', [SanphamController::class, 'create'])->middleware(['auth', 'verified'])->name('admin.products.create');

// Save product (used by Admin Create form)
Route::post('/admin/products', [SanphamController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.products.store');

Route::resource('admin', AdminController::class)->middleware(['auth', 'verified']);




require __DIR__.'/auth.php';

