<template>
  <div class="p-6">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-2xl font-semibold mb-6">All Products</h1>
      <div class="bg-white p-4 rounded shadow-sm">
        <div class="flex items-center mb-4">
          <input placeholder="Search here..." class="border rounded px-3 py-2 w-full" />
          <a href="/admin/products/create" class="ml-4 bg-blue-600 text-white px-4 py-2 rounded">+ Add new</a>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead>
              <tr class="text-sm text-gray-500 border-b">
                <th class="py-2">#</th>
                <th class="py-2">Tên sản phẩm</th>
                <th class="py-2">Giá gốc: </th>
                <th class="py-2">Giá sau khi giảm:</th>
                <th class="py-2">Loại</th>
                <th class="py-2">Stock</th>
                <th class="py-2">Số lượng</th>
                <!-- Thêm xóa sửa trong đây -->
                <th class="py-2">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="p in products" :key="p.id" class="text-sm">
                <td class="py-2 border-b">{{ p.id }}</td>
                <td class="py-2 border-b">{{ p.name }}</td>
                <td class="py-2 border-b">${{ p.price }}</td>
                <td class="py-2 border-b">${{ p.sale_price }}</td>
                <td class="py-2 border-b">{{ p.category }}</td>
                <td class="py-2 border-b">{{ p.stock }}</td>
                <td class="py-2 border-b">{{ p.quantity }}</td>
                <!-- Thêm xóa sửa trong đây -->
                <td class="py-2 border-b">-</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const products = ref([
  { id: 1, name: 'Product6', price: 128, sale_price: 110, sku: 'SKU7868', category: 'Category3', brand: 'Brand2', featured: true, stock: 'instock', quantity: 11 }
])
</script>
