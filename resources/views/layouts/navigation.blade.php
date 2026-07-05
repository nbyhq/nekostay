cat > resources/views/layouts/navigation.blade.php << 'EOF'
<aside class="w-64 shrink-0 bg-white border-r border-gray-200 flex flex-col">
    <!-- Logo -->
    <div class="px-6 py-6">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <div class="h-9 w-9 rounded-lg bg-emerald-600 flex items-center justify-center">
                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 14c-3.5 0-6 2.5-6 5v1h12v-1c0-2.5-2.5-5-6-5z M7 8a2 2 0 100-4 2 2 0 000 4z M17 8a2 2 0 100-4 2 2 0 000 4z M4 12a2 2 0 100-4 2 2 0 000 4z M20 12a2 2 0 100-4 2 2 0 000 4z"/>
                </svg>
            </div>
            <div>
                <div class="font-bold text-emerald-800 leading-tight">NekoStay</div>
                <div class="text-xs text-gray-500 leading-tight">Rescue Management</div>
            </div>
        </a>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 px-3 space-y-1">
        @php
            $navItems = [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'path' => 'dashboard'],
                ['label' => 'Cat Management', 'route' => 'cats.index', 'path' => 'cats*'],
                ['label' => 'Medical Records', 'route' => 'medical-records.index', 'path' => 'medical-records*'],
                ['label' => 'Adoption Requests', 'route' => 'adoptions.index', 'path' => 'adoptions*'],
                ['label' => 'Profile Settings', 'route' => 'profile.edit', 'path' => 'profile*'],
            ];
        @endphp

        @foreach ($navItems as $item)
            @php $active = request()->is($item['path']); @endphp
            <a href="{{ \Illuminate\Support\Facades\Route::has($item['route']) ? route($item['route']) : '#' }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
                      {{ $active ? 'bg-emerald-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>

    <!-- Add New Intake button -->
    <div class="p-3 border-t border-gray-100">
        <a href="{{ \Illuminate\Support\Facades\Route::has('cats.create') ? route('cats.create') : '#' }}"
           class="flex items-center justify-center gap-2 w-full bg-emerald-700 text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-emerald-800 transition">
            <span>+ Add New Intake</span>
        </a>
    </div>
</aside>
EOF