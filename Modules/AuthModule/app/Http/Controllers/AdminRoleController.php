<?php

namespace Modules\AuthModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\AuthModule\Http\Requests\AdminRoleRequest;
use Modules\AuthModule\Models\AdminPermission;
use Modules\AuthModule\Models\AdminRole;
use Modules\AuthModule\Models\AdminRolePermission;
use Modules\AuthModule\Services\AuthComonService;

class AdminRoleController extends Controller
{
    protected $Comm;
    protected $commRepo;
    public function __construct(AuthComonService $Comm)
    {
        $this->commRepo = new CommonRepository(AdminRole::class);
        $this->Comm = $Comm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('authmodule::roles.index');
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
            'description',
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
        $permissions = $this->Comm->getData(
            AdminPermission::query(),
            ['id', 'name', 'description'],
            ['status' => '1'],
            'id',
            'asc',
        );
        // dd($permissions);
        return view('authmodule::roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRoleRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $role = $this->Comm->create(
                AdminRole::class,
                [
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status
                ]
            );
            if (isset($request->permissions)) {
                foreach ($request->permissions as $key => $value) {
                    $this->Comm->create(
                        AdminRolePermission::class,
                        [
                            'admin_role_id' => $role->id,
                            'admin_permission_id' => $value,
                            'status' => $request->status
                        ]
                    );
                }
            }

            DB::commit();
            return back()->with('success', 'Role created successfully');
        } catch (Exception $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage())->withInput($request->all());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('authmodule::roles.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = AdminRole::with(['role_permissions'=>function($query){
            $query->where('status','1');
        }])->find($id);
        $permissions = $this->Comm->getData(
            AdminPermission::query(),
            ['id', 'name', 'description'],
            ['status' => '1'],
            'id',
            'asc',
        );

        return view('authmodule::roles.edit', compact('data', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRoleRequest $request, $id): RedirectResponse
    {
        // dd($request->all());
      
        try {
            $data = $this->commRepo->find($id);
            DB::beginTransaction();
            $role = $this->commRepo->update(
                $id,
                [
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status
                ]
            );
           
            if (isset($request->permissions)) {
                $data->role_permissions()->update([
                    'status' => '0'
                ]);
                foreach ($request->permissions as $key => $value) {
                    $this->Comm->createOrUpdateByField(
                        AdminRolePermission::class,
                        [
                            'admin_role_id' => $role->id,
                            'admin_permission_id' => $value
                        ],
                        [
                            'status' => '1'
                        ]
                    );
                }
            }

            DB::commit();
            return back()->with('success', 'Role updated successfully');
        } catch (Exception $th) {
            DB::rollBack();
            return back()->with('error', $th->getMessage())->withInput($request->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->commRepo->delete($id);
        return back()->with('success', 'Customer deleted successfully');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->get('ids');

        $this->commRepo->bulkDelete($ids);

        return response()->json(['success' => 'Deleted successfully.']);
    }
}
