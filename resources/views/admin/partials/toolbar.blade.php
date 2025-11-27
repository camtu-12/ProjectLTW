<div class="bg-gray-50 border-b">
    <div class="relative w-full">
        @php $user = Auth::user(); @endphp

        {{-- Centered search --}}
        <div class="px-6 py-4">
            <div class="mx-auto max-w-2xl">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Search here..." class="w-full pl-4 pr-10 py-2 rounded-full border focus:outline-none" value="{{ request('q') }}" />
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Actions pinned to the right edge; logout is placed last so it's flush to the edge --}}
        <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center gap-3">
            <button type="button" class="relative p-2 rounded-full hover:bg-gray-100" title="Thông báo">
                <i class="fas fa-bell text-gray-600"></i>
                <span class="absolute -top-1 -right-1 bg-blue-600 text-white rounded-full text-xs px-1">1</span>
            </button>

            <div class="hidden sm:block text-sm text-right">
                <div class="font-medium text-gray-700">{{ $user->name ?? 'Admin' }}</div>
                <div class="text-xs text-gray-500">{{ $user->email ?? '' }}</div>
            </div>

            

            {{-- Logout form (POST) placed last to be closest to the right edge --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-800 px-2 py-1 rounded-md" title="Đăng xuất">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</div>
