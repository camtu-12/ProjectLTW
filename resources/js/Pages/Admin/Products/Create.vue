<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-2xl font-semibold mb-6 text-gray-900">Thêm sản phẩm mới</h1>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left form -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg border border-gray-200">
          <div class="space-y-6">
            <!-- Tên sản phẩm -->
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-2">Tên sản phẩm *</label>
              <input 
                v-model="form.tensanpham" 
                type="text" 
                maxlength="100"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200" 
                placeholder="Nhập tên sản phẩm" 
              />
              <p class="text-xs text-gray-500 mt-2">{{ form.tensanpham.length }}/100 ký tự</p>
            </div>

            <!-- Mô tả ngắn -->
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-2">Mô tả ngắn *</label>
              <textarea 
                v-model="form.motangan" 
                rows="3" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200" 
                placeholder="Nhập mô tả ngắn về sản phẩm"
              ></textarea>
            </div>

            <!-- Giá gốc và Giá bán -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-800 mb-2">Giá gốc *</label>
                <input 
                  v-model.number="form.giagoc" 
                  type="number" 
                  min="0"
                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200" 
                  placeholder="0" 
                />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-800 mb-2">Giá bán *</label>
                <input 
                  v-model.number="form.giaban" 
                  type="number" 
                  min="0"
                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200" 
                  placeholder="0" 
                />
              </div>
            </div>

            <!-- Mã sản phẩm -->
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-2">Mã sản phẩm *</label>
              <input 
                v-model="form.masanpham" 
                type="text" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200" 
                placeholder="Nhập mã sản phẩm" 
              />
            </div>

            <!-- Size -->
            <div>
              <label class="block text-sm font-medium text-gray-800 mb-2">Size</label>
              <select 
                v-model="form.kichthuoc" 
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:border-transparent transition-all duration-200"
              >
                <option value="">Chọn size</option>
                <option v-for="s in sizes" :key="s" :value="s">{{ s }}</option>
              </select>
            </div>

            <!-- Nút lưu -->
            <div class="flex items-center justify-end pt-6 border-t border-gray-200">
              <button 
                @click.prevent="submit" 
                :disabled="!isFormValid"
                class="bg-gray-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed"
              >
                Lưu sản phẩm
              </button>
            </div>
          </div>
        </div>

        <!-- Right side: uploads -->
        <div class="bg-white p-6 rounded-lg border border-gray-200 space-y-6">
          <!-- Upload ảnh chính -->
          <div>
            <label class="block text-sm font-medium text-gray-800 mb-2">Ảnh chính</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg h-36 flex items-center justify-center text-gray-500 hover:border-gray-400 transition-all duration-200 cursor-pointer">
              <div class="text-center">
                <div class="text-2xl mb-2">📁</div>
                <div class="text-sm">Kéo thả ảnh vào đây hoặc <span class="text-gray-700 font-medium">chọn để duyệt</span></div>
              </div>
            </div>
          </div>

          <!-- Upload ảnh gallery -->
          <div>
            <label class="block text-sm font-medium text-gray-800 mb-2">Ảnh gallery</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg h-36 flex items-center justify-center text-gray-500 hover:border-gray-400 transition-all duration-200 cursor-pointer">
              <div class="text-center">
                <div class="text-2xl mb-2">🖼️</div>
                <div class="text-sm">Kéo thả ảnh vào đây hoặc <span class="text-gray-700 font-medium">chọn để duyệt</span></div>
              </div>
            </div>
          </div>

          <!-- Thông tin bổ sung -->
          <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h3 class="text-sm font-medium text-gray-800 mb-3">Thông tin bổ sung</h3>
            <div class="space-y-3">
              <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Trạng thái</label>
                <select v-model="form.trangthai" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                  <option value="danghoatdong">Đang hoạt động</option>
                  <option value="ngungkinhdoanh">Ngừng kinh doanh</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Số lượng</label>
                <input 
                  v-model.number="form.soluong" 
                  type="number" 
                  class="w-full border border-gray-300 rounded px-3 py-2 text-sm" 
                  placeholder="0" 
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const sizes = ref(['S', 'M', 'L', 'XL', 'XXL'])

const form = ref({
  tensanpham: '',
  masanpham: '',
  motangan: '',
  giagoc: 0,
  giaban: 0,
  kichthuoc: '',
  soluong: 0,
  trangthai: 'danghoatdong'
})

// Validate form
const isFormValid = computed(() => {
  return (
    form.value.tensanpham.trim() !== '' &&
    form.value.motangan.trim() !== '' &&
    form.value.giagoc >= 0 &&
    form.value.giaban >= 0 &&
    form.value.masanpham.trim() !== ''
  )
})

async function submit() {
  if (!isFormValid.value) {
    alert('Vui lòng điền đầy đủ các trường bắt buộc (*)')
    return
  }
  
  try {
    const response = await fetch('/api/sanphams', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        tensanpham: form.value.tensanpham,
        masanpham: form.value.masanpham,
        motangan: form.value.motangan,
        giagoc: parseFloat(form.value.giagoc),
        giaban: parseFloat(form.value.giaban),
        kichthuoc: form.value.kichthuoc,
        soluong: parseInt(form.value.soluong),
        trangthai: form.value.trangthai
      })
    })
    
    if (response.ok) {
      alert('Sản phẩm đã được lưu thành công!')
      // Reset form
      form.value = {
        tensanpham: '',
        masanpham: '',
        motangan: '',
        giagoc: 0,
        giaban: 0,
        kichthuoc: '',
        soluong: 0,
        trangthai: 'danghoatdong'
      }
    } else {
      alert('Lỗi khi lưu sản phẩm')
    }
  } catch (error) {
    console.error('Error:', error)
    alert('Có lỗi xảy ra khi lưu sản phẩm')
  }
}
</script>

<style scoped>
/* Custom scrollbar for select elements */
select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 0.5rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
}
</style>