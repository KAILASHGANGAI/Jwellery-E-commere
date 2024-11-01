<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Concurrency;
use Modules\Admin\Models\Customer;
use Modules\Admin\Models\Order;
use Modules\Admin\Models\Product;
use Modules\AuthModule\Models\AdminUser;

class   AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'Total Selling (रु)' => Order::where('status', 'fulfilled')->sum('total_amount'),
            'Expenses (रु)'=> 0, 
            'Total Orders' => Order::count(),
            'Total Products' => Product::count(),
            'Total Customers' => Customer::count(),
            'Todal Users'=> AdminUser::count(),
        ];
        return view('admin::index', compact('data'));
    }

}
