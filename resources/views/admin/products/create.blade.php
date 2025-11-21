<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background-color: #1f2937;
            color: white;
            min-height: 100vh;
        }
        .sidebar a:hover {
            background-color: #374151;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar w-64 p-4">
            <div class="mb-8">
                <h1 class="text-xl font-bold">Shop Quân Áo</h1>
                <p class="text-sm text-gray-300">Admin</p>
            </div>
            
            <div class="mb-6">
                <div class="relative">
                    <input type="text" placeholder="Search here..." class="w-full bg-gray-700 text-white rounded px-3 py-2 pl-8">
                    <i class="fas fa-search absolute left-2 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded bg-gray-700">
                            <i class="fas fa-box mr-2"></i> Sản phẩm
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-list mr-2"></i> Danh mục
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-shopping-cart mr-2"></i> Đơn hàng
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700">
                            <i class="fas fa-cog mr-2"></i> Cài đặt
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="mt-8 text-xs text-gray-400">
                <p>© 2025 Shop Quần Áo</p>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <h1 class="text-2xl font-semibold">Thêm sản phẩm</h1>
                </div>

                @if($errors->any())
                <div class="mb-4 mx-4 text-red-700 bg-red-100 p-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="post" action="{{ route('admin.products.store') }}">
                    @csrf
                    <div class="p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Tên sản phẩm *</label>
                                    <input name="tensanpham" value="{{ old('tensanpham') }}" class="w-full border rounded px-3 py-2" placeholder="Nhập tên sản phẩm" />
                                    <p class="text-xs text-gray-500 mt-1">Tối đa 100 ký tự</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Mã sản phẩm *</label>
                                    <input name="masanpham" value="{{ old('masanpham') }}" class="w-full border rounded px-3 py-2" placeholder="Nhập mã sản phẩm" />
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Mô tả ngắn</label>
                                    <textarea name="motangan" class="w-full border rounded px-3 py-2" rows="3" placeholder="Nhập mô tả ngắn">{{ old('motangan') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Tối đa 100 ký tự</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Mô tả chi tiết</label>
                                    <textarea name="mota" class="w-full border rounded px-3 py-2" rows="5" placeholder="Nhập mô tả chi tiết">{{ old('mota') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Tối đa 1000 ký tự</p>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Giá gốc</label>
                                        <input name="giagoc" value="{{ old('giagoc') }}" class="w-full border rounded px-3 py-2" placeholder="0.00" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Giá bán *</label>
                                        <input name="giaban" value="{{ old('giaban') }}" class="w-full border rounded px-3 py-2" placeholder="0.00" />
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Kích thước</label>
                                    <select name="kichthuoc" class="w-full border rounded px-3 py-2">
                                        <option value="">Chọn kích thước</option>
                                        <option value="S" {{ old('kichthuoc')==='S' ? 'selected' : '' }}>S</option>
                                        <option value="M" {{ old('kichthuoc')==='M' ? 'selected' : '' }}>M</option>
                                        <option value="L" {{ old('kichthuoc')==='L' ? 'selected' : '' }}>L</option>
                                        <option value="XL" {{ old('kichthuoc')==='XL' ? 'selected' : '' }}>XL</option>
                                        <option value="XXL" {{ old('kichthuoc')==='XXL' ? 'selected' : '' }}>XXL</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Số lượng *</label>
                                    <input type="number" name="soluong" value="{{ old('soluong', 0) }}" class="w-full border rounded px-3 py-2" placeholder="0" />
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Trạng thái</label>
                                    <select name="trangthai" class="w-full border rounded px-3 py-2">
                                        <option value="danghoatdong" {{ old('trangthai')==='danghoatdong' ? 'selected' : '' }}>Đang hoạt động</option>
                                        <option value="ngunghoatdong" {{ old('trangthai')==='ngunghoatdong' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                    </select>
                                </div>
                                
                                
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded flex items-center">
                                <i class="fas fa-save mr-2"></i> Lưu sản phẩm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>