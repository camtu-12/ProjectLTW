<div class="w-64 bg-white border-r min-h-screen">
    <div class="p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-md flex items-center justify-center text-white font-bold" style="background: linear-gradient(135deg,#ff7a7a,#ffd47a);">SQ</div>
            <div>
                <div class="text-lg font-bold text-gray-800">Shop Quần Áo</div>
                <div class="text-sm text-gray-500">Admin</div>
            </div>
        </div>

        <nav class="mt-4">
            <ul class="space-y-3 text-gray-700">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-2 py-2 rounded hover:bg-gray-50">
                        <i class="fas fa-bars w-5 text-gray-500"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-2 py-2 rounded hover:bg-gray-50">
                        <i class="fas fa-box w-5 text-gray-500"></i>
                        <span>Sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-2 py-2 rounded hover:bg-gray-50">
                        <i class="fas fa-list w-5 text-gray-500"></i>
                        <span>Danh mục</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-2 py-2 rounded hover:bg-gray-50">
                        <i class="fas fa-shopping-cart w-5 text-gray-500"></i>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-2 py-2 rounded hover:bg-gray-50">
                        <i class="fas fa-cog w-5 text-gray-500"></i>
                        <span>Cài đặt</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="mt-8 text-sm text-gray-400">
            <p>© 2025 Shop Quần Áo</p>
        </div>
    </div>
</div>
