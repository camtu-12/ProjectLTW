<template>
  <div class="min-h-screen bg-gray-50 flex text-gray-800">
    <!-- Sidebar -->
    <aside class="w-72 bg-white border-r shadow-sm">
      <div class="p-6 flex items-center gap-3 border-b">
        <div class="w-10 h-10 rounded bg-gradient-to-r from-pink-500 to-yellow-400 flex items-center justify-center text-white font-bold">SQ</div>
        <div>
          <div class="text-lg font-semibold">Shop Quần Áo</div>
          <div class="text-xs text-gray-500">Admin</div>
        </div>
      </div>

      <nav class="p-4 space-y-1 text-sm">
        <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-gray-100">
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
          Dashboard
        </a>
        <div class="relative">
          <button type="button" @click="showProducts = !showProducts" class="flex items-center gap-3 p-3 rounded hover:bg-gray-100 w-full text-left">
            <svg class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 3h18v4H3zM3 11h18v10H3z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Sản phẩm</span>
            <svg :class="{'transform rotate-90': showProducts}" class="w-4 h-4 ml-auto text-gray-500 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 6L14 10L6 14V6Z" clip-rule="evenodd"/></svg>
          </button>
          <div v-show="showProducts" class="mt-1 ml-2 bg-white rounded shadow-sm">
            <a href="/admin/products/create" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Thêm sản phẩm</a>
            <a href="/admin/products" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Tất cả sản phẩm</a>
          </div>
        </div>
        <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-gray-100">Danh mục</a>
        <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-gray-100">Đơn hàng</a>
        <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-gray-100">Tài khoản</a>
  <a href="/admin/settings" class="flex items-center gap-3 p-3 rounded hover:bg-gray-100">Cài đặt</a>
      </nav>

      <div class="mt-auto p-4 text-xs text-gray-500">
        © 2025 Shop Quần Áo
      </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 p-6">
      <!-- Top bar -->
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
          <input type="text" placeholder="Search here..." class="w-96 px-4 py-2 border rounded-lg focus:outline-none" />
        </div>
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-3">
            <div class="flex flex-col items-center">
              <button type="button" @click="logout" class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center hover:bg-red-100">
                
              </button>
              <div class="text-xs text-gray-700 mt-1">Admin</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Top grid: stats + chart -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Stats cards (left, spans 2 columns) -->
<div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
          <div v-for="(card, idx) in statCards" :key="idx" class="bg-white rounded-lg p-5 shadow-sm flex items-center justify-between">
            <div>
              <div class="text-sm text-gray-500">{{ card.title }}</div>
              <div class="text-2xl font-bold mt-1">{{ card.value }}</div>
            </div>
            <div class="text-3xl text-blue-500">{{ card.icon }}</div>
          </div>
        </div>

        <!-- Chart panel (right) -->
        <div class="bg-white rounded-lg p-5 shadow-sm">
          <div class="flex items-center justify-between mb-4">
            <div>
              <div class="text-sm text-gray-500">Doanh thu</div>
              <div class="text-xl font-bold">$37,802</div>
            </div>
            <div class="text-xs text-gray-500">Jun • Jul</div>
          </div>

          <!-- simple bar chart -->
          <div class="flex items-end gap-3 h-44">
            <div v-for="(col, i) in chartData" :key="i" class="flex-1 flex flex-col items-center">
              <div :style="{height: col + 'px'}" class="w-full bg-blue-400 rounded-t"></div>
              <div class="text-xs text-gray-500 mt-2">{{ chartLabels[i] }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent orders table -->
      <div class="bg-white rounded-lg p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold">Đơn hàng gần đây</h3>
          <a href="#" class="text-sm text-blue-600">Xem tất cả</a>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="text-xs text-gray-500 border-b">
                <th class="py-3">OrderNo</th>
                <th class="py-3">Tên khách hàng</th>
                <th class="py-3">SĐT</th>
                <th class="py-3">Đơn giá</th>
                <th class="py-3">Thuế</th>
                <th class="py-3">Tổng</th>
                <th class="py-3">Tình trạng</th>
                <th class="py-3">Ngày đặt hàng</th>
                <th class="py-3">Tổng số sản phẩm</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in recentOrders" :key="order.id" class="text-sm">
                <td class="py-3 border-b">{{ order.id }}</td>
                <td class="py-3 border-b">{{ order.name }}</td>
                <td class="py-3 border-b">{{ order.phone }}</td>
                <td class="py-3 border-b">${{ order.subtotal.toFixed(2) }}</td>
                <td class="py-3 border-b">${{ order.tax.toFixed(2) }}</td>
                <td class="py-3 border-b">${{ order.total.toFixed(2) }}</td>
                <td class="py-3 border-b"><span :class="statusClass(order.status)">{{ order.status }}</span></td>
                <td class="py-3 border-b">{{ order.date }}</td>
<td class="py-3 border-b">{{ order.items }}</td>
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
import axios from 'axios'

function logout() {
  axios.post('/logout')
    .then(() => window.location.href = '/login')
    .catch(err => {
      console.error('Logout failed', err)
      alert('Đăng xuất thất bại. Kiểm tra console.')
    })
}

const showProducts = ref(false)

const statCards = ref([
  { title: 'Tổng số đơn hàng', value: 3, icon: '📦' },
  { title: 'Đơn hàng đã giao', value: 0, icon: '✅' },
  { title: 'Tổng số tiền', value: '$481.34', icon: '$' },
  { title: 'Tổng tiền các đơn đã giao', value: '$0.00', icon: '$' }
])

// Simple chart data (pixel heights)
const chartData = ref([0, 0, 0, 0, 0, 180, 140, 0, 0, 0, 0, 0])
const chartLabels = ref(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'])

const recentOrders = ref([
  { id: 1, name: 'Divyansh Kumar', phone: '1234567891', subtotal: 172, tax: 36.12, total: 208.12, status: 'ordered', date: '2024-07-11 00:54:14', items: 2 }
])

function statusClass(s) {
  if (s === 'delivered') return 'bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs'
  if (s === 'ordered') return 'bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs'
  return 'bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs'
}
</script>

<style scoped>
/* Minor scrollbar styling for table */
::-webkit-scrollbar { height: 8px; }
::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.1); border-radius: 8px; }
</style>
