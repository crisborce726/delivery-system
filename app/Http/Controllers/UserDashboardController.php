<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // User statistics
        $totalDeliveries = Delivery::where('user_id', $user->id)->count();
        $pendingDeliveries = Delivery::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedDeliveries = Delivery::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Prepare chart data (example: deliveries per day for last 7 days)
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = Delivery::where('user_id', $user->id)
                ->whereDate('created_at', $date)
                ->count();
            $chartLabels[] = $date;
            $chartData[] = $count;
        }

        // Recent deliveries
        $recentDeliveries = Delivery::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', [
            'user' => $user,
            'totalDeliveries' => $totalDeliveries,
            'pendingDeliveries' => $pendingDeliveries,
            'completedDeliveries' => $completedDeliveries,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'recentDeliveries' => $recentDeliveries,
        ]);
    }
}
