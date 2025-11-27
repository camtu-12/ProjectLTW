<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        @include('admin.partials.sidebar')

        <!-- Main content -->
        <div class="flex-1 min-h-screen">
            @include('admin.partials.toolbar')

            <div class="max-w-7xl mx-auto px-6 py-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold">Cài đặt</h1>
                    <p class="text-sm text-gray-500">Quản lý thông tin tài khoản và đổi mật khẩu</p>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 text-green-700 rounded">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-lg p-6 shadow">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Họ và tên</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full border rounded px-3 py-2" />
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Số điện thoại</label>
                                    <input type="text" name="mobile" value="{{ old('mobile', $user->mobile ?? '') }}" class="w-full border rounded px-3 py-2" />
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-1">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border rounded px-3 py-2" />
                                </div>
                            </div>

                            <div>
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
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
