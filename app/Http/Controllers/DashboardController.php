<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Cat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalCats = Cat::count();
        $readyForAdoption = Cat::where('status', 'ready_for_adoption')->count();
        $successfullyAdopted = Cat::where('status', 'adopted')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();
        $pendingApplications = Adoption::where('status', 'pending')->count();

        // Tren 6 bulan terakhir: rescue vs adopsi disetujui
        // Dioptimasi jadi hanya 2 query total (bukan 12), dengan groupBy bulan/tahun.
        $rangeStart = now()->subMonths(5)->startOfMonth();

        $rescuedByMonth = Cat::selectRaw('YEAR(created_at) as y, MONTH(created_at) as m, COUNT(*) as total')
            ->where('created_at', '>=', $rangeStart)
            ->groupBy('y', 'm')
            ->get()
            ->keyBy(fn ($row) => $row->y.'-'.$row->m);

        $adoptedByMonth = Adoption::selectRaw('YEAR(updated_at) as y, MONTH(updated_at) as m, COUNT(*) as total')
            ->where('status', 'approved')
            ->where('updated_at', '>=', $rangeStart)
            ->groupBy('y', 'm')
            ->get()
            ->keyBy(fn ($row) => $row->y.'-'.$row->m);

        $trend = collect(range(5, 0))->map(function ($i) use ($rescuedByMonth, $adoptedByMonth) {
            $month = now()->subMonths($i);
            $key = $month->year.'-'.$month->month;

            return [
                'label' => $month->format('M'),
                'rescued' => (int) ($rescuedByMonth[$key]->total ?? 0),
                'adopted' => (int) ($adoptedByMonth[$key]->total ?? 0),
            ];
        });

        $recentCats = Cat::latest()->take(4)->get();
        $recentAdoptions = Adoption::with('cat')->where('status', 'pending')->latest()->take(3)->get();

        return view('dashboard', compact(
            'totalCats',
            'readyForAdoption',
            'successfullyAdopted',
            'pendingApplications',
            'trend',
            'recentCats',
            'recentAdoptions',
        ));
    }
}
