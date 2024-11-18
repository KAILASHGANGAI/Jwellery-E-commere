<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Http\Requests\ShippingRequest;
use Modules\Admin\Models\Shipping;
use Modules\Admin\Services\AdminComonService;
use Modules\Blog\Services\CommonService;

class ShippingController extends Controller
{
    private CommonRepository $comReo;
    private AdminComonService $adminService;
    public function __construct(AdminComonService $adminService)
    {
        $this->adminService = $adminService;
        $this->comReo = new CommonRepository(Shipping::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::shipping.index');
    }

    public function indexAjax(Request $request)
    {
        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $filter = $request->get('filter', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');
        $select  = [
            'id', 'title', 'country', 'state', 'city', 'address', 'zipcode', 'amount', 'created_at', 'status'   
        ];
        $searchableFields = [
            'title', 'country', 'state', 'address', 'zipcode','created_at',
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
            null
        );

        return response()->json($data, 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingRequest $request)
    {

        try {
           $this->comReo->create($request->all());
            return back()->with('success', 'Shipping created successfully');
        } catch (Exception $e) {
            dd($e);
            return back()->with('error', $e->getMessage())->withInput($request->all());
        }
        
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::shipping.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->comReo->find($id);
        return view('admin::shipping.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingRequest $request, $id): RedirectResponse
    {
        
        
        try {
            $data = $this->comReo->update($id, $request->all());
            return back()->with('success', 'Shipping updated successfully');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->comReo->delete($id);
            return back()->with('success', 'Shipping deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $this->comReo->bulkDelete($request->ids);
        return response()->json(['success' => 'Deleted successfully.']);
    }
}
