<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Models\Order;
use Modules\Admin\Services\AdminComonService;

class OrderController extends Controller
{
    private CommonRepository $comReo;
    private AdminComonService $adminService;
    public function __construct(AdminComonService $adminService)
    {
        $this->adminService = $adminService;
        $this->comReo = new CommonRepository(Order::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::orders.index');
    }
    public function indexAjax(Request $request)
    {
        $pagination = $request->get('limit', 2);
        $search = $request->get('search', null);
        $filter = $request->get('filter', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'DESC');
        $select  = [
            'id',        
            'customer_id',
            'status',
            'total_amount',
            'no_of_item',
            'subtotal',
            'payment_method',
            'nettotal',
            'taxAmount',
            'order_date',
            'delivary_date'
        ];
        $searchableFields = [
            'id',
            'status',
            'payment_method',
            'created_at',
        ];
        $data = $this->comReo->getData(
            $select,
            $search,
            $searchableFields,
            $filter,
            $sort_field,
            $sort_type,
            $limit ?? null,
            $pagination,
            ['customer:id,name']
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::order.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::order.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function bulkDelete(Request $request)
    {

        $ids = $request->ids;
        $this->comReo->bulkDelete($ids);
        return response()->json(['success' => 'Orders deleted successfully.'], 200);
    }
}
