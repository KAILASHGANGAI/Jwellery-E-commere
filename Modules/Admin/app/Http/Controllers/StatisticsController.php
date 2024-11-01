<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Models\Order;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentYear = Carbon::now()->year;

        // Fetch monthly data for orders and earnings
        $data = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as orders, SUM(total_amount) as earnings')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $orders = [];
        $earnings = [];

        // Populate data arrays
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $data->firstWhere('month', $i);

            $labels[] = Carbon::create()->month($i)->format('F'); // Get month name
            $orders[] = $monthData ? $monthData->orders : 0;
            $earnings[] = $monthData ? $monthData->earnings : 0;
        }

        return response()->json([
            'labels' => $labels,
            'orders' => $orders,
            'earnings' => $earnings,
        ]);
    }

    public function getWeeklyRevenue()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $data = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $revenues = [];

        // Fill the data for each day of the week
        for ($date = $startOfWeek; $date->lte($endOfWeek); $date->addDay()) {
            $dailyData = $data->firstWhere('date', $date->toDateString());

            $labels[] = $date->format('l'); // Day name (e.g., Monday)
            $revenues[] = $dailyData ? $dailyData->revenue : 0;
        }

        return response()->json([
            'labels' => $labels,
            'revenues' => $revenues,
        ]);
    }
}
