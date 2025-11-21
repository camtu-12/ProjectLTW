<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả sản phẩm</title>
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
        .status-active {
            color: #10b981;
            background-color: #d1fae5;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-inactive {
            color: #ef4444;
            background-color: #fee2e2;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .action-btn {
            transition: all 0.2s ease;
        }
        .action-btn:hover {
            transform: scale(1.1);
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
                    <input type="text" placeholder="Search here..." class="w-full bg-gray-700 text-white rounded px-3 py-2 pl-8 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-search absolute left-2 top-3 text-gray-400"></i>
                </div>
            </div>
            
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded bg-gray-700 border-l-4 border-blue-500">
                            <i class="fas fa-box mr-2"></i> Sản phẩm
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-list mr-2"></i> Danh mục
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-shopping-cart mr-2"></i> Đơn hàng
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block p-2 rounded hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-cog mr-2"></i> Cài đặt
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="mt-8 text-xs text-gray-400">
                <p>© 2025 Shop Quân Áo</p>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow-lg">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Tất cả sản phẩm</h1>
                        <p class="text-gray-600 mt-1">Quản lý danh sách sản phẩm của bạn</p>
                    </div>
                    <a href="{{ route('admin.products.create') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-3 rounded-lg flex items-center transition-colors duration-200 shadow-md">
                        <i class="fas fa-plus mr-2"></i> Thêm sản phẩm mới
                    </a>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="mx-6 mt-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-500"></i>
                    {{ session('success') }}
                </div>
                @endif

                <!-- Error Message -->
                @if(session('error'))
                <div class="mx-6 mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-2 text-red-500"></i>
                    {{ session('error') }}
                </div>
                @endif

                <!-- Products Table -->
                <div class="p-6">
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50">
                                <tr class="text-sm font-semibold text-gray-700">
                                    <th class="py-4 px-6 border-b">
                                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </th>
                                    <th class="py-4 px-6 border-b">Tên sản phẩm</th>
                                    <th class="py-4 px-6 border-b">Mã sản phẩm</th>
                                    <th class="py-4 px-6 border-b">Giá gốc</th>
                                    <th class="py-4 px-6 border-b">Giá bán</th>
                                    <th class="py-4 px-6 border-b">Kích thước</th>
                                    <th class="py-4 px-6 border-b">Số lượng</th>
                                    <th class="py-4 px-6 border-b">Trạng thái</th>
                                    <th class="py-4 px-6 border-b text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($sanphams as $product)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-900">{{ $product->tensanpham }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $product->masanpham }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-gray-600">{{ number_format($product->giagoc, 0, ',', '.') }}₫</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-semibold text-green-600">{{ number_format($product->giaban, 0, ',', '.') }}₫</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($product->kichthuoc)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $product->kichthuoc }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-medium {{ $product->soluong > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                            {{ $product->soluong }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($product->trangthai == 'danghoatdong')
                                            <span class="status-active">
                                                <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                                Đang hoạt động
                                            </span>
                                        @else
                                            <span class="status-inactive">
                                                <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                                Ngừng kinh doanh
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex justify-center space-x-3">
                                            <button class="action-btn text-blue-600 hover:text-blue-800" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn text-gray-600 hover:text-gray-800" title="Sao chép">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button class="action-btn text-red-600 hover:text-red-800" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-500">
                                            <i class="fas fa-box-open text-4xl mb-4 text-gray-300"></i>
                                            <p class="text-lg font-medium mb-2">Chưa có sản phẩm nào</p>
                                            <p class="text-sm mb-4">Hãy thêm sản phẩm đầu tiên của bạn</p>
                                            <a href="{{ route('admin.products.create') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-lg flex items-center transition-colors duration-200">
                                                <i class="fas fa-plus mr-2"></i> Thêm sản phẩm mới
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Bulk Actions & Pagination -->
                    @if($sanphams->count() > 0)
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                        <!-- Bulk Actions -->
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="select-all" class="ml-2 text-sm text-gray-700">Chọn tất cả</label>
                            </div>
                            <select class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option>Thao tác hàng loạt</option>
                                <option>Sửa</option>
                                <option>Sao chép</option>
                                <option>Xóa</option>
                                <option>Xuất file</option>
                            </select>
                            <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition-colors duration-200">
                                Áp dụng
                            </button>
                        </div>

                        <!-- Pagination -->
                        <div class="flex items-center space-x-2">
                            <div class="text-sm text-gray-700">
                                Hiển thị {{ $sanphams->firstItem() ?? 0 }} - {{ $sanphams->lastItem() ?? 0 }} của {{ $sanphams->total() }} sản phẩm
                            </div>
                            <div class="flex space-x-1">
                                @if($sanphams->onFirstPage())
                                    <span class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $sanphams->previousPageUrl() }}" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                @endif

                                @foreach($sanphams->getUrlRange(1, $sanphams->lastPage()) as $page => $url)
                                    @if($page == $sanphams->currentPage())
                                        <span class="px-3 py-2 border border-blue-500 bg-blue-500 text-white rounded-lg">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors duration-200">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if($sanphams->hasMorePages())
                                    <a href="{{ $sanphams->nextPageUrl() }}" class="px-3 py-2 border border-gray-300 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="px-3 py-2 border border-gray-300 rounded-lg text-gray-400 cursor-not-allowed">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                            <i class="fas fa-box text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Tổng sản phẩm</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $sanphams->total() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Đang hoạt động</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $sanphams->where('trangthai', 'danghoatdong')->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                            <i class="fas fa-pause-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Ngừng kinh doanh</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $sanphams->where('trangthai', '!=', 'danghoatdong')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Individual checkbox functionality
        document.querySelectorAll('tbody input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                const selectAll = document.getElementById('select-all');
                const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
            });
        });
    </script>
</body>
</html>