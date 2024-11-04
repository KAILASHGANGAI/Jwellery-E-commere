<?php

namespace Modules\AuthModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\AuthModule\Models\AdminPermission;
use Modules\AuthModule\Services\AuthComonService;
class AdminPermissionController extends Controller
{
    protected $Comm;
    protected $commRepo;
    public function __construct(AuthComonService $Comm)
    {
        $this->commRepo = new CommonRepository(AdminPermission::class);
        $this->Comm = $Comm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('authmodule::permissions.index');
    }

    public function indexAjax(Request $request)
    {

        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $filter =$request->get('filter', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');
        $select  = [
            'id',
            'name',
            'controller',
            'method',
            'description',
            'route', 
            'status',
            'created_at'    
        ];
        $data = $this->commRepo->getData(
            $select,
            $search,
            $select,
            $filter,
            $sort_field,
            $sort_type,
            $limit ?? null,
            $pagination ?? null,
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authmodule::permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
       try {
        $this->commRepo->create($request->all());
        return back()->with('success', 'Permission created successfully');
       } catch (Exception $th) {
        return back()->with('error', $th->getMessage())->withInput($request->all());
       }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('authmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->commRepo->find($id);
        return view('authmodule::permissions.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $this->commRepo->update($id, $request->all());
            return back()->with('success', 'Permission updated successfully');
        } catch (Exception $th) {
            return back()->with('error', $th->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->commRepo->delete($id);
        return back()->with('success', 'Permission deleted successfully');
    }
}
