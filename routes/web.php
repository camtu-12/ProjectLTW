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

    $role = strtolower((string) $user->role);
    if ($role === 'admin' || $role === 'administrator') {
        return Inertia::render('Admin/Index', ['user' => $user]);
    }

    // default: khách hàng
    return Inertia::render('Khachhang/Index', ['user' => $user]);

})->middleware(['auth', 'verified'])->name('dashboard');

// Route trực tiếp tới trang admin (dùng để test và truy cập nhanh)
Route::get('/admin', function () {
    return Inertia::render('Admin/Index');
})->middleware(['auth', 'verified'])->name('admin.home');

// Admin products pages (frontend-only scaffolding)
Route::get('/admin/products', function () {
    return Inertia::render('Admin/Products/Index');
})->middleware(['auth', 'verified'])->name('admin.products.index');

Route::get('/admin/products/create', function () {
    return Inertia::render('Admin/Products/Create');
})->middleware(['auth', 'verified'])->name('admin.products.create');

//Logout route 
Route::post('/logout', function (Request $request) {
    Auth::logout(); // Đăng xuất user

    // Xóa session & regenerate token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Quay về trang login
    return redirect()->route('login');
})->name('logout');

Route::resource('sinhviens', KhachhangController::class)->middleware(['auth', 'verified']);
Route::resource('admin', AdminController::class)->middleware(['auth', 'verified']);
require __DIR__.'/auth.php';

