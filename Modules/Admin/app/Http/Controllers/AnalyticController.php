<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Models\Order;
use Modules\Admin\Models\OrderProduct;
use Modules\Admin\Models\Product;

class AnalyticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::analytics.index');
    }

    public function salesTrend()
    {
        $data = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as sales')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date')->map(fn($date) => Carbon::parse($date)->format('M d')),
            'sales' => $data->pluck('sales'),
        ]);
    }

    public function customerDemographics()
    {
        // Example of demographics by gender
        $data = Order::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get();

        return response()->json([
            'labels' => $data->pluck('gender'),
            'counts' => $data->pluck('count'),
        ]);
    }

    public function orderFunnel()
    {
        return response()->json([
            'labels' => ['Visits', 'Product Views', 'Add to Cart', 'Purchases'],
            'data' => [10000, 8000, 3000, 1000] // Replace with dynamic data if available
        ]);
    }

    public function productPerformance()
    {
        $data = OrderProduct::select('id', 'product_id', 'variation_id', 'sku')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'labels' => $data->pluck('id'),
            'sales' => $data->pluck('total_sold'),
            'profits' => $data->pluck('profit')
        ]);
    }
}
