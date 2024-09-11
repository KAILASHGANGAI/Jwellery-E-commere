<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Http\Requests\CustomerRequest;
use Modules\Admin\Models\Customer;

class CustomerController extends Controller
{
    protected CommonRepository $comRepo;

    public function __construct()
    {
        $this->comRepo = new CommonRepository(Customer::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::customers.index');
    }
    public function indexAjax(Request $request) 
    {
        
        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $filter = $request->get('filter', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');
        $select  = [
            'id',
            'name',
            'email',
            'phone',
            'address',
            'status',
            'created_at',
        ];
        $data = $this->comRepo->getData(
            $select,
            $search,
            $filter,
            $sort_field,
            $sort_type,
            $limit ?? null,
            $pagination ?? null

        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request): RedirectResponse
    {
        try {
            $data = $request->all();
            $this->comRepo->create($data);
            return back()->with('success', 'Customer created successfully');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = $this->comRepo->find($id);
        return view('admin::customers.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->comRepo->find($id);
        return view('admin::customers.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, $id): RedirectResponse
    {
        try {
            $data = $request->all();
            $this->comRepo->update($id, $data);
            return back()->with('success', 'Customer updated successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->comRepo->delete($id);
        return back()->with('success', 'Customer deleted successfully');
    }
}
