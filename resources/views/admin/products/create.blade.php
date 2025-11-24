<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            object-fit: cover;
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
        
        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <h1 class="text-2xl font-semibold">Thêm sản phẩm</h1>
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

                <!-- QUAN TRỌNG: Thêm enctype="multipart/form-data" -->
                <form method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- TRƯỜNG CHỌN HÌNH ẢNH -->
                                <div>
                                    <label class="block text-sm font-medium mb-2">Hình ảnh sản phẩm</label>
                                    
                                    <!-- Drop Zone -->
                                    <div class="drop-zone rounded-lg p-6 text-center cursor-pointer" 
                                         id="dropZone"
                                         onclick="fileInput.click()">
                                        <!-- keep the file input in the DOM at all times so its File is submitted -->
                                        <input type="file" name="hinhanh" id="hinhanh" 
                                               accept="image/*" class="hidden" />

                                        <!-- message area we will update programmatically without removing the input -->
                                        <div class="drop-zone-content flex flex-col items-center justify-center">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                            <p class="text-sm text-gray-600 mb-1">Kéo thả ảnh vào đây hoặc click để chọn</p>
                                            <p class="text-xs text-gray-500">Hỗ trợ: JPG, PNG, GIF, WEBP (Tối đa 2MB)</p>
                                        </div>
                                    </div>

                                    <!-- Preview ảnh -->
                                    <div class="mt-4 text-center">
                                        <img id="image-preview" class="image-preview mx-auto hidden" />
                                        <div id="remove-image" class="hidden mt-2">
                                            <button type="button" onclick="removeImage()" 
                                                    class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash mr-1"></i> Xóa ảnh
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Hiển thị lỗi validation -->
                                    @error('hinhanh')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium mb-2">Tên sản phẩm *</label>
                                    <input name="tensanpham" value="{{ old('tensanpham') }}" 
                                           class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                           placeholder="Nhập tên sản phẩm" />
                                    @error('tensanpham')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">Tối đa 100 ký tự</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Mã sản phẩm *</label>
                                    <input name="masanpham" value="{{ old('masanpham') }}" 
                                           class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                           placeholder="Nhập mã sản phẩm" />
                                    @error('masanpham')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Mô tả ngắn</label>
                                    <textarea name="motangan" class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                              rows="3" placeholder="Nhập mô tả ngắn">{{ old('motangan') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Tối đa 100 ký tự</p>
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Giá gốc</label>
                                        <input name="giagoc" value="{{ old('giagoc') }}" 
                                               class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                               placeholder="0.00" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Giá bán *</label>
                                        <input name="giaban" value="{{ old('giaban') }}" 
                                               class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                               placeholder="0.00" />
                                        @error('giaban')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Kích thước</label>
                                    <select name="kichthuoc" class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="">Chọn kích thước</option>
                                        <option value="S" {{ old('kichthuoc')=='S' ? 'selected' : '' }}>S</option>
                                        <option value="M" {{ old('kichthuoc')=='M' ? 'selected' : '' }}>M</option>
                                        <option value="L" {{ old('kichthuoc')=='L' ? 'selected' : '' }}>L</option>
                                        <option value="XL" {{ old('kichthuoc')=='XL' ? 'selected' : '' }}>XL</option>
                                        <option value="XXL" {{ old('kichthuoc')=='XXL' ? 'selected' : '' }}>XXL</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Số lượng *</label>
                                    <input type="number" name="soluong" value="{{ old('soluong', 0) }}" 
                                           class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                           placeholder="0" min="0" />
                                    @error('soluong')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Trạng thái</label>
                                    <select name="trangthai" class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                        <option value="danghoatdong" {{ old('trangthai')=='danghoatdong' ? 'selected' : '' }}>Đang hoạt động</option>
                                        <option value="ngunghoatdong" {{ old('trangthai')=='ngunghoatdong' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Mô tả chi tiết</label>
                                    <textarea name="mota" class="w-full border rounded px-3 py-2 focus:border-blue-500 focus:ring-1 focus:ring-blue-500" 
                                              rows="5" placeholder="Nhập mô tả chi tiết">{{ old('mota') }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Tối đa 1000 ký tự</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.products.index') }}" 
                               class="bg-gray-300 text-gray-700 px-6 py-2 rounded flex items-center hover:bg-gray-400 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Quay lại
                            </a>
                            <button type="submit" 
                                    class="bg-gray-900 text-white px-6 py-2 rounded flex items-center hover:bg-gray-800 transition-colors">
                                <i class="fas fa-save mr-2"></i> Lưu sản phẩm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Elements
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('hinhanh');
        const imagePreview = document.getElementById('image-preview');
        const removeBtn = document.getElementById('remove-image');

        // Xử lý khi chọn file từ input
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            handleFileSelection(file);
        });

        // Xử lý kéo thả
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
        });

        dropZone.addEventListener('drop', function(e) {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileSelection(files[0]);
            }
        });

        // Xử lý file được chọn
        function handleFileSelection(file) {
            if (file) {
                // Kiểm tra loại file
                if (!file.type.match('image.*')) {
                    alert('Vui lòng chọn file hình ảnh!');
                    return;
                }

                // Kiểm tra kích thước file (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File quá lớn! Vui lòng chọn file nhỏ hơn 2MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    removeBtn.classList.remove('hidden');

                    // Update only the message area so the file input element stays in the DOM
                    const content = dropZone.querySelector('.drop-zone-content');
                    if (content) {
                        content.innerHTML = `
                            <div class="text-green-600">
                                <i class="fas fa-check-circle text-2xl mb-2"></i>
                                <p class="text-sm">Ảnh đã được chọn</p>
                                <p class="text-xs text-gray-500">Click để chọn ảnh khác</p>
                            </div>
                        `;
                    }
                }
                reader.readAsDataURL(file);
            }
        }

        // Xóa ảnh đã chọn
        function removeImage() {
            // Clear the input and hide preview, restore original message content
            fileInput.value = '';
            imagePreview.classList.add('hidden');
            removeBtn.classList.add('hidden');

            const content = dropZone.querySelector('.drop-zone-content');
            if (content) {
                content.innerHTML = `
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-600 mb-1">Kéo thả ảnh vào đây hoặc click để chọn</p>
                    <p class="text-xs text-gray-500">Hỗ trợ: JPG, PNG, GIF, WEBP (Tối đa 2MB)</p>
                `;
            }
        }
    </script>
</body>
</html>