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
        $months = collect(range(5, 0))->map(function ($i) {
            return now()->subMonths($i);
        });

        $trend = $months->map(function ($month) {
            return [
                'label' => $month->format('M'),
                'rescued' => Cat::whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
                'adopted' => Adoption::where('status', 'approved')
                    ->whereMonth('updated_at', $month->month)
                    ->whereYear('updated_at', $month->year)
                    ->count(),
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
