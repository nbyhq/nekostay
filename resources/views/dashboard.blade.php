<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border-l-4 border-emerald-600 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Rescued Cats</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $totalCats }}</div>
                <div class="text-xs text-gray-400 mt-1">Current occupancy</div>
            </div>

            <div class="bg-white rounded-xl border-l-4 border-emerald-600 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Ready for Adoption</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $readyForAdoption }}</div>
                <div class="text-xs text-gray-400 mt-1">Cleared by medical</div>
            </div>

            <div class="bg-white rounded-xl border-l-4 border-emerald-800 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Successfully Adopted</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $successfullyAdopted }}</div>
                <div class="text-xs text-gray-400 mt-1">This month</div>
            </div>

            <div class="bg-white rounded-xl border-l-4 border-amber-500 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Pending Applications</div>
                <div class="text-3xl font-bold text-gray-800 mt-2">{{ $pendingApplications }}</div>
                <div class="text-xs text-gray-400 mt-1">Action required</div>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-gray-800">Monthly Rescue vs. Adoption Trends</h3>
                    <p class="text-xs text-gray-500">Visualisasi arus kucing masuk dan diadopsi tiap bulan.</p>
                </div>
            </div>
            <canvas id="trendChart" height="90"></canvas>
        </div>

        <!-- Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800">Recent Rescue Logs</h3>
                    @if (\Illuminate\Support\Facades\Route::has('cats.index'))
                        <a href="{{ route('cats.index') }}" class="text-sm text-emerald-700 font-medium hover:underline">View All</a>
                    @endif
                </div>

                <div class="overflow-x-auto -mx-2 px-2">
                <table class="w-full text-sm min-w-[480px]">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 uppercase border-b border-gray-100">
                            <th class="pb-2">Cat</th>
                            <th class="pb-2">Breed</th>
                            <th class="pb-2">Status</th>
                            <th class="pb-2">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentCats as $cat)
                            <tr class="border-b border-gray-50">
                                <td class="py-3 font-medium text-gray-800">{{ $cat->name }}</td>
                                <td class="py-3 text-gray-500">{{ $cat->breed ?? '-' }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ match($cat->status) {
                                            'ready_for_adoption' => 'bg-emerald-100 text-emerald-700',
                                            'in_treatment' => 'bg-red-100 text-red-700',
                                            'adopted' => 'bg-blue-100 text-blue-700',
                                            default => 'bg-gray-100 text-gray-600',
                                        } }}">
                                        {{ str_replace('_', ' ', strtoupper($cat->status)) }}
                                    </span>
                                </td>
                                <td class="py-3 text-gray-500">{{ $cat->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-gray-400">Belum ada data kucing.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-1">Recent Adoption Requests</h3>
                <p class="text-xs text-gray-500 mb-4">Action items for this week</p>

                <div class="space-y-3">
                    @forelse ($recentAdoptions as $adoption)
                        <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                            <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-semibold">
                                {{ strtoupper(substr($adoption->adopter_name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-800 truncate">{{ $adoption->adopter_name }}</div>
                                <div class="text-xs text-gray-500">Request for: {{ $adoption->cat->name ?? '-' }}</div>
                            </div>
                            <span class="text-xs font-semibold text-amber-600">PENDING</span>
                        </div>
                    @empty
                        <div class="text-sm text-gray-400 text-center py-6">Belum ada pengajuan adopsi.</div>
                    @endforelse
                </div>

                @if (\Illuminate\Support\Facades\Route::has('adoptions.index'))
                    <a href="{{ route('adoptions.index') }}" class="block text-center mt-4 text-sm border border-dashed border-gray-300 rounded-lg py-2 text-gray-500 hover:bg-gray-50">
                        View All Requests
                    </a>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        const trendData = @json($trend);
        const ctx = document.getElementById('trendChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: trendData.map(d => d.label),
                datasets: [
                    {
                        label: 'Rescued',
                        data: trendData.map(d => d.rescued),
                        backgroundColor: '#a7f3d0',
                        borderRadius: 4,
                    },
                    {
                        label: 'Adopted',
                        data: trendData.map(d => d.adopted),
                        backgroundColor: '#047857',
                        borderRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            },
        });
    </script>
    @endpush
</x-app-layout>
