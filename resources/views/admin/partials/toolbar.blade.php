<div class="bg-gray-50 border-b">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">
        @php $user = Auth::user(); @endphp

        {{-- Search (left) --}}
        <div class="flex-1 mr-4">
            <form action="{{ url()->current() }}" method="GET" class="max-w-2xl">
                <div class="relative">
                    <input type="text" name="q" placeholder="Search here..." class="w-full pl-4 pr-10 py-2 rounded-full border focus:outline-none" value="{{ request('q') }}" />
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Actions (right): notifications + avatar --}}
        <div class="flex items-center gap-4">
            <button type="button" class="relative p-2 rounded-full hover:bg-gray-100">
                <i class="fas fa-bell text-gray-600"></i>
                <span class="absolute -top-1 -right-1 bg-blue-600 text-white rounded-full text-xs px-1">1</span>
            </button>

            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-sm text-right">
                    <div class="font-medium text-gray-700">{{ $user->name ?? 'Admin' }}</div>
                    <div class="text-xs text-gray-500">{{ $user->email ?? '' }}</div>
                </div>

                <div>
                    <button type="button" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 overflow-hidden">
                        @if($user && data_get($user, 'avatar'))
                            <img src="{{ Storage::url($user->avatar) }}" class="w-10 h-10 object-cover" alt="avatar" />
                        @else
                            <img src="https://i.pravatar.cc/40" class="w-10 h-10 object-cover" alt="avatar" />
                        @endif
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
