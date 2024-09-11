<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Admin\Models\Discount;

class DiscountController extends Controller
{
    protected CommonRepository $comRepo;

    public function __construct()
    {
        $this->comRepo = new CommonRepository(Discount::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::discounts.index');
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
            'code',
            'type',
            'value',
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
        return view('admin::discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $data = $request->all();
            $this->comRepo->create($data);
            return back()->with('success', 'Discount created successfully');
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
        return view('admin::discounts.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->comRepo->find($id);
        return view('admin::discounts.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $data = $request->all();
            $this->comRepo->update($data, $id);
            return back()->with('success', 'Discount updated successfully');
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
        return back()->with('success', 'Discount deleted successfully');
    }
}
