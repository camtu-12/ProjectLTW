<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .drop-zone {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }
        .drop-zone.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        @include('admin.partials.sidebar')

        <div class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <h1 class="text-2xl font-semibold">Chỉnh sửa sản phẩm</h1>
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

                <form method="post" action="{{ route('admin.products.update', $sanpham->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Hình ảnh sản phẩm</label>

                                    <div class="flex items-start gap-6">
                                        <div>
                                            @if($sanpham->hinhanh)
                                                <img src="{{ Storage::url($sanpham->hinhanh) }}" alt="current" class="product-image" />
                                            @else
                                                <div class="product-image bg-gray-100 flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-image text-3xl"></i>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex-1">
                                            <p class="text-sm text-gray-500 mb-2">Bạn có thể thay đổi ảnh sản phẩm tại đây. Nếu không upload ảnh mới, ảnh hiện tại sẽ giữ nguyên.</p>

                                            <div class="drop-zone rounded-lg p-4" id="dropZoneEdit" onclick="fileInputEdit.click()">
                                                <input type="file" name="hinhanh" id="hinhanhEdit" accept="image/*" class="hidden" />
                                                <div id="dropZoneContentEdit" class="text-center text-gray-500">
                                                    <i class="fas fa-cloud-upload-alt text-2xl mb-2"></i>
                                                    <div>Kéo thả hoặc bấm để chọn ảnh</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Tên sản phẩm *</label>
                                    <input type="text" name="tensanpham" value="{{ old('tensanpham', $sanpham->tensanpham) }}" class="w-full border rounded px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Mã sản phẩm *</label>
                                    <input type="text" name="masanpham" value="{{ old('masanpham', $sanpham->masanpham) }}" class="w-full border rounded px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Mô tả ngắn</label>
                                    <textarea name="motangan" class="w-full border rounded px-3 py-2" rows="3">{{ old('motangan', $sanpham->motangan) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Giá gốc</label>
                                    <input type="number" name="giagoc" value="{{ old('giagoc', $sanpham->giagoc) }}" class="w-full border rounded px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Giá bán</label>
                                    <input type="number" name="giaban" value="{{ old('giaban', $sanpham->giaban) }}" class="w-full border rounded px-3 py-2" />
                                </div>

                                <div class="flex justify-end">
                                    <a href="{{ route('admin.products.index') }}" class="mr-2 inline-block px-4 py-2 border rounded">Hủy</a>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Lưu thay đổi</button>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Kích thước</label>
                                    <input type="text" name="kichthuoc" value="{{ old('kichthuoc', $sanpham->kichthuoc) }}" class="w-full border rounded px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Số lượng</label>
                                    <input type="number" name="soluong" value="{{ old('soluong', $sanpham->soluong) }}" class="w-full border rounded px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Trạng thái</label>
                                    <select name="trangthai" class="w-full border rounded px-3 py-2">
                                        <option value="danghoatdong" {{ (old('trangthai', $sanpham->trangthai) == 'danghoatdong') ? 'selected' : '' }}>Đang hoạt động</option>
                                        <option value="ngungkinhdoanh" {{ (old('trangthai', $sanpham->trangthai) == 'ngungkinhdoanh') ? 'selected' : '' }}>Ngừng kinh doanh</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Danh mục</label>
                                    <input type="text" name="danhmuc" value="{{ old('danhmuc', $sanpham->danhmuc_id ?? '') }}" class="w-full border rounded px-3 py-2" />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Ghi chú nội bộ</label>
                                    <textarea name="note" class="w-full border rounded px-3 py-2" rows="4">{{ old('note', $sanpham->note ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const fileInputEdit = document.getElementById('hinhanhEdit');
        const dropZoneEdit = document.getElementById('dropZoneEdit');
        const dropZoneContentEdit = document.getElementById('dropZoneContentEdit');

        dropZoneEdit.addEventListener('click', () => fileInputEdit.click());

        fileInputEdit.addEventListener('change', (e) => {
            if (fileInputEdit.files && fileInputEdit.files.length > 0) {
                dropZoneContentEdit.innerHTML = `<div class="text-sm text-green-600">Đã chọn: ${fileInputEdit.files[0].name}</div>`;
            }
        });

        dropZoneEdit.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZoneEdit.classList.add('dragover');
        });
        dropZoneEdit.addEventListener('dragleave', () => dropZoneEdit.classList.remove('dragover'));
        dropZoneEdit.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZoneEdit.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInputEdit.files = files;
                dropZoneContentEdit.innerHTML = `<div class="text-sm text-green-600">Đã chọn: ${files[0].name}</div>`;
            }
        });
    </script>
</body>
</html>
