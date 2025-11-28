<template>
  <div class="p-6">
    <div class="bg-white rounded-lg shadow p-6">
      <h1 class="text-2xl font-semibold mb-2">Cài đặt</h1>
      <p class="text-sm text-gray-500 mb-4">Quản lý thông tin tài khoản và đổi mật khẩu</p>

      <div v-if="$page.props.flash && $page.props.flash.success" class="mb-4 p-3 bg-green-50 text-green-700 rounded">
        {{ $page.props.flash.success }}
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <form :action="route('admin.settings.update')" method="post">
          <input type="hidden" name="_token" :value="csrf">
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Họ và tên</label>
            <input type="text" name="name" :value="user.name" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Số điện thoại</label>
            <input type="text" name="mobile" :value="user.mobile" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" :value="user.email" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Lưu thay đổi</button>
          </div>
        </form>

        <form :action="route('admin.settings.password')" method="post">
          <input type="hidden" name="_token" :value="csrf">
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Mật khẩu cũ</label>
            <input type="password" name="old_password" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Mật khẩu mới</label>
            <input type="password" name="new_password" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Xác nhận mật khẩu mới</label>
            <input type="password" name="new_password_confirmation" class="w-full border rounded px-3 py-2" />
          </div>
          <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Đổi mật khẩu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    user: Object
  },
  computed: {
    csrf() { return document.querySelector('meta[name="csrf-token"]').getAttribute('content'); }
  },
  methods: {
    route(name) { return route(name); }
  }
}
</script>

<style scoped>
</style>
