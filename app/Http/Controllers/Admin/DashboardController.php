<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // User Statistics
        $totalUsers = User::count();
        $verifiedUsers = User::where('is_verified', true)->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;
        
        // Delivery Statistics
        $totalDeliveries = Delivery::count();
        $pendingDeliveries = Delivery::where('status', 'pending')->count();
        $inTransitDeliveries = Delivery::where('status', 'in_transit')->count();
        $deliveredDeliveries = Delivery::where('status', 'delivered')->count();
        $cancelledDeliveries = Delivery::where('status', 'cancelled')->count();

        // User growth data for charts (last 6 months)
        $monthlyUsers = User::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        // Prepare user growth chart data
        $chartLabels = [];
        $chartData = [];

        foreach ($monthlyUsers as $user) {
            $chartLabels[] = date('M Y', mktime(0, 0, 0, $user->month, 1, $user->year));
            $chartData[] = $user->count;
        }

        // Delivery status data for pie chart
        $deliveryStatusData = [
            'pending' => $pendingDeliveries,
            'in_transit' => $inTransitDeliveries,
            'delivered' => $deliveredDeliveries,
            'cancelled' => $cancelledDeliveries
        ];

        // Monthly delivery growth (last 6 months)
        $monthlyDeliveries = Delivery::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        // Prepare delivery growth chart data
        $deliveryChartLabels = [];
        $deliveryChartData = [];

        foreach ($monthlyDeliveries as $delivery) {
            $deliveryChartLabels[] = date('M Y', mktime(0, 0, 0, $delivery->month, 1, $delivery->year));
            $deliveryChartData[] = $delivery->count;
        }

        // Recent user registrations (last 7 days)
        $userRegistrations = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->get();

        // Recent deliveries (last 5)
        $recentDeliveries = Delivery::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Top users with most deliveries
        $topUsers = User::withCount('deliveries')
            ->orderBy('deliveries_count', 'DESC')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'totalDeliveries',
            'pendingDeliveries',
            'inTransitDeliveries',
            'deliveredDeliveries',
            'cancelledDeliveries',
            'userRegistrations',
            'recentDeliveries',
            'topUsers',
            'chartLabels',
            'chartData',
            'deliveryChartLabels',
            'deliveryChartData',
            'deliveryStatusData'
        ));
    }


}