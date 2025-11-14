<template>
  <div class="p-6">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-2xl font-semibold mb-6">Add Product</h1>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left form -->
        <div class="lg:col-span-2 bg-white p-6 rounded shadow-sm">
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Tên sản phẩm *</label>
              <input v-model="form.name" type="text" class="mt-2 block w-full border rounded px-4 py-2" placeholder="Enter product name" />
              <p class="text-xs text-gray-400 mt-1">Do not exceed 100 characters when entering the product name.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Slug *</label>
                <input v-model="form.slug" type="text" class="mt-2 block w-full border rounded px-4 py-2" placeholder="Enter product slug" />
                <p class="text-xs text-gray-400 mt-1">Do not exceed 100 characters when entering the product slug.</p>
              </div>

              <div></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Loại *</label>
                <select v-model="form.category" class="mt-2 block w-full border rounded px-4 py-2">
                  <option value="">Chọn loại</option>
                  <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                </select>
              </div>
        
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700">Mô tả *</label>
              <textarea v-model="form.short_description" rows="4" class="mt-2 block w-full border rounded px-4 py-2" placeholder="Short Description"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Số lượng: </label>
                <input v-model.number="form.quantity" type="number" class="mt-2 block w-full border rounded px-4 py-2" placeholder="Quantity" />
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">Giá gốc:*</label>
                <input v-model.number="form.price" type="number" class="mt-2 block w-full border rounded px-4 py-2" placeholder="Regular price" />
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">Giá sale:</label>
                <input v-model.number="form.sale_price" type="number" class="mt-2 block w-full border rounded px-4 py-2" placeholder="Sale price" />
              </div>
            </div>

            <div class="flex items-center gap-4">

              <label class="block text-sm font-medium text-gray-700">Stock</label>
              <select v-model="form.stock" class="mt-1 block border rounded px-3 py-2">
                <option value="instock">In stock</option>
                <option value="outofstock">Out of stock</option>
              </select>
            </div>

            <div class="flex items-center justify-end">
              <button @click.prevent="submit" class="bg-blue-600 text-white px-5 py-2 rounded">Save product</button>
            </div>
          </div>
        </div>

        <!-- Right side: uploads and meta -->
        <div class="bg-white p-6 rounded shadow-sm space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Upload images *</label>
            <div class="mt-2 border-dashed border-2 border-blue-200 rounded h-36 flex items-center justify-center text-gray-400">
              <div class="text-center">
                <div class="text-3xl">☁️</div>
                <div class="mt-2 text-sm">Drop your images here or select <span class="text-blue-600 underline">click to browse</span></div>
              </div>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Upload Gallery Images</label>
            <div class="mt-2 border-dashed border-2 border-blue-200 rounded h-36 flex items-center justify-center text-gray-400">
              <div class="text-center">
                <div class="text-3xl">☁️</div>
                <div class="mt-2 text-sm">Drop your images here or select <span class="text-blue-600 underline">click to browse</span></div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Category (meta)</label>
              <input v-model="form.meta_category" type="text" class="mt-2 block w-full border rounded px-4 py-2" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Brand (meta)</label>
              <input v-model="form.meta_brand" type="text" class="mt-2 block w-full border rounded px-4 py-2" />
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const categories = ref([
  { id: 1, name: 'Category1' },
  { id: 2, name: 'Category2' },
  { id: 3, name: 'Category3' },
])
const brands = ref([
  { id: 1, name: 'Brand1' },
  { id: 2, name: 'Brand2' },
])

const form = ref({
  name: '',
  slug: '',
  category: '',
  brand: '',
  short_description: '',
  sku: '',
  quantity: 1,
  price: 0,
  sale_price: 0,
  featured: false,
  stock: 'instock',
  meta_category: '',
  meta_brand: '',
})

function submit() {
  // For now just log — you can wire to backend endpoint later
  console.log('Submitting product', form.value)
  alert('Product saved (mock). Check console for payload.')
}
</script>

<style scoped>
/* small niceties */
</style>
