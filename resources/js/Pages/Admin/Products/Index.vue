<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-2xl font-semibold mb-6 text-gray-900">Tất cả sản phẩm</h1>
      <div class="bg-white p-6 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between mb-6">
          <input 
            placeholder="Tìm kiếm sản phẩm..." 
            class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent" 
          />
          <a 
            href="/admin/products/create" 
            class="bg-gray-900 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-800 transition-all duration-200"
          >
            + Thêm sản phẩm mới
          </a>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="text-sm text-gray-600 border-b border-gray-200">
                <th class="py-3 font-medium">#</th>
                <th class="py-3 font-medium">Tên sản phẩm</th>
                <th class="py-3 font-medium">Mã sản phẩm</th>
                <th class="py-3 font-medium">Giá gốc</th>
                <th class="py-3 font-medium">Giá bán</th>
                <th class="py-3 font-medium">Size</th>
                <th class="py-3 font-medium">Số lượng</th>
                <th class="py-3 font-medium">Trạng thái</th>
                <th class="py-3 font-medium">Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="p in products" :key="p.id" class="text-sm hover:bg-gray-50">
                <td class="py-3 border-b border-gray-100">{{ p.id }}</td>
                <td class="py-3 border-b border-gray-100 font-medium">{{ p.tensanpham }}</td>
                <td class="py-3 border-b border-gray-100 text-gray-500">{{ p.masanpham }}</td>
                <td class="py-3 border-b border-gray-100">{{ formatCurrency(p.giagoc) }}</td>
                <td class="py-3 border-b border-gray-100 font-medium text-green-600">{{ formatCurrency(p.giaban) }}</td>
                <td class="py-3 border-b border-gray-100">{{ p.kichthuoc || '-' }}</td>
                <td class="py-3 border-b border-gray-100">
                  <span :class="{'text-red-600': p.soluong === 0, 'text-green-600': p.soluong > 0}">
                    {{ p.soluong }}
                  </span>
                </td>
                <td class="py-3 border-b border-gray-100">
                  <span 
                    :class="{
                      'bg-green-100 text-green-800': p.trangthai === 'danghoatdong',
                      'bg-red-100 text-red-800': p.trangthai === 'ngungkinhdoanh'
                    }" 
                    class="px-2 py-1 rounded-full text-xs font-medium"
                  >
                    {{ getStatusText(p.trangthai) }}
                  </span>
                </td>
                <td class="py-3 border-b border-gray-100">
                  <div class="flex space-x-2">
                    <button 
                      @click="editProduct(p.id)"
                      class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                    >
                      Sửa
                    </button>
                    <button 
                      @click="deleteProduct(p.id)"
                      class="text-red-600 hover:text-red-800 text-sm font-medium"
                    >
                      Xóa
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!-- Empty state -->
        <div v-if="products.length === 0" class="text-center py-8">
          <div class="text-gray-400 text-4xl mb-4">📦</div>
          <p class="text-gray-500">Chưa có sản phẩm nào</p>
          <a 
            href="/admin/products/create" 
            class="inline-block mt-2 bg-gray-900 text-white px-4 py-2 rounded-lg font-medium hover:bg-gray-800 transition-all duration-200"
          >
            Thêm sản phẩm đầu tiên
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const products = ref([
  { 
    id: 1, 
    tensanpham: 'Áo thun nam basic', 
    masanpham: 'ATN-BASIC-001', 
    giagoc: 150000, 
    giaban: 120000, 
    kichthuoc: 'M', 
    soluong: 50, 
    trangthai: 'danghoatdong',
    motangan: 'Áo thun cotton co giãn thoáng mát'
  },
  { 
    id: 2, 
    tensanpham: 'Quần jeans nữ', 
    masanpham: 'QJ-NU-001', 
    giagoc: 350000, 
    giaban: 299000, 
    kichthuoc: 'L', 
    soluong: 0, 
    trangthai: 'ngungkinhdoanh',
    motangan: 'Quần jeans slim fit chất liệu denim'
  }
])

// Format tiền tệ
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND'
  }).format(amount)
}

// Lấy text trạng thái
const getStatusText = (status) => {
  const statusMap = {
    'danghoatdong': 'Đang hoạt động',
    'ngungkinhdoanh': 'Ngừng kinh doanh'
  }
  return statusMap[status] || status
}

// Hàm sửa sản phẩm
const editProduct = (id) => {
  console.log('Edit product:', id)
  // Điều hướng đến trang sửa
  window.location.href = `/admin/products/edit/${id}`
}

// Hàm xóa sản phẩm
const deleteProduct = (id) => {
  if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
    console.log('Delete product:', id)
    // Gọi API xóa sản phẩm
    products.value = products.value.filter(p => p.id !== id)
  }
}
</script>

<style scoped>
/* Thêm hiệu ứng hover cho table row */
tr:hover {
  transition: background-color 0.2s ease;
}
</style>