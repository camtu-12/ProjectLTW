<?php

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;    
//Đây là của P thêm   
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
// Dashboard — tự động chuyển trang Vue theo vai trò
Route::get('/dashboard', function () {
    /** @var User|null $user */
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'Admin':
            return Inertia::render('Admin/Index', ['user' => $user]);
        case 'KhachHang':
            return Inertia::render('Khachhang/Index', ['user' => $user]);
        default:
            return Inertia::render('Khachhang/Index', ['user' => $user]);
    }
})->middleware(['auth', 'verified'])->name('dashboard');

//Logout route (P)
Route::post('/logout', function (Request $request) {
    Auth::logout(); // Đăng xuất user

    // Xóa session & regenerate token
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Quay về trang login
    return redirect()->route('login');
})->name('logout');

require __DIR__.'/auth.php';
