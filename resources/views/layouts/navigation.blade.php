<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 w-64 shrink-0 bg-white border-r border-gray-200 flex flex-col overflow-y-auto
           transform transition-transform duration-200 ease-in-out
           lg:translate-x-0 lg:static lg:z-auto lg:h-screen lg:sticky lg:top-0">
    <!-- Logo -->
    <div class="px-6 py-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" class="h-9 w-9 rounded-lg object-cover shrink-0 block" alt="NekoStay logo">
            <div>
                <div class="font-bold text-emerald-800 leading-tight">NekoStay</div>
                <div class="text-xs text-gray-500 leading-tight">Rescue Management</div>
            </div>
        </a>
        <!-- Close button (mobile only) -->
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <!-- Nav Links -->
    <nav class="flex-1 px-3 space-y-1">
        @php
            $navItems = [
                ['label' => 'Dashboard', 'route' => 'dashboard', 'path' => 'dashboard'],
                ['label' => 'Cat Management', 'route' => 'cats.index', 'path' => 'cats*'],
                ['label' => 'Medical Records', 'route' => 'medical-records.index', 'path' => 'medical-records*'],
                ['label' => 'Adoption Requests', 'route' => 'adoptions.index', 'path' => 'adoptions*'],
            ];
            if (auth()->user()->hasRole('admin')) {
                $navItems[] = ['label' => 'Manage Staff', 'route' => 'staff.index', 'path' => 'staff*'];
            }
            $navItems[] = ['label' => 'Profile Settings', 'route' => 'profile.edit', 'path' => 'profile*'];
            $hideIntakeButton = request()->routeIs('profile.edit') || request()->routeIs('cats.create') || request()->routeIs('adoptions.*') || request()->routeIs('medical-records.*') || request()->routeIs('staff.*');
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
    @unless($hideIntakeButton)
        <div class="p-3 border-t border-gray-100">
            <a href="{{ \Illuminate\Support\Facades\Route::has('cats.create') ? route('cats.create') : '#' }}"
               class="flex items-center justify-center gap-2 w-full bg-emerald-700 text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-emerald-800 transition">
                <span>+ Add New Intake</span>
            </a>
        </div>
    @endunless
</aside>
