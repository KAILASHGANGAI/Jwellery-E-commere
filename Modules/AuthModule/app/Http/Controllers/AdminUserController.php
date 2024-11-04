<?php

namespace Modules\AuthModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\AuthModule\Http\Requests\AdminUserRequest;
use Modules\AuthModule\Models\AdminRole;
use Modules\AuthModule\Models\AdminRoleUser;
use Modules\AuthModule\Models\AdminUser;
use Modules\AuthModule\Services\AuthComonService;

class AdminUserController extends Controller
{

    protected $Comm;
    protected $commRepo;
    public function __construct(AuthComonService $Comm)
    {
        $this->commRepo = new CommonRepository(AdminUser::class);
        $this->Comm = $Comm;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('authmodule::users.index');
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
            'status',
            'is_super_admin',
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
            ['adminUserRole', 'adminUserRole.adminRole:id,name']
        );

        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles  = $this->Comm->getData(
            AdminRole::query(),
            ['id', 'name']
        );
        return view('authmodule::users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminUserRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $user = $this->commRepo->create($data);
            if (isset($data['role'])) {
                $this->Comm->createOrUpdateByField(
                    AdminRoleUser::class,
                    [
                        'admin_user_id' => $user->id,
                        'admin_role_id' => $data['role']
                    ],
                    ['status' => '1']
                );
            }
            DB::commit();
            return redirect()->back()->with('success', 'User created successfully');
        } catch (Exception $th) {
            dd($th);
            // Optionally return an error message to the user
            return redirect()->back()->withInput()->with('error', 'There was an error creating the user. Please try again.');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('authmodule::users.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = AdminUser::with(['adminUserRole'])->find($id);
        $roles  = $this->Comm->getData(
            AdminRole::query(),
            ['id', 'name']
        );
        return view('authmodule::users.edit', compact('data', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required |max:255',
            'phone' => 'required |max:255',
            'email' => 'required|email |max:255',
            'status' => 'required',
            'is_super_admin' => 'nullable'
        ]);
        try {
            $user = $this->commRepo->find($id);
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => $request->status,
                'is_super_admin' => $request->is_super_admin ?? 0
            ];

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            $user = $this->commRepo->update($id, $data);
            if (isset($request->role)) {
               $this->Comm->createOrUpdateByField(
                    AdminRoleUser::class,
                    ['admin_user_id' => $user->id],
                    ['status' => $request->status,   'admin_role_id' => $request->role]
                );
            
            }
            DB::commit();
            return redirect()->back()->with('success', 'User updated successfully');
        } catch (Exception $th) {
            dd($th);
            // Optionally return an error message to the user
            return redirect()->back()->withInput()->with('error', 'There was an error creating the user. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->commRepo->delete($id);
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $this->commRepo->bulkDelete($request->ids);
        return response()->json(['success' => 'Deleted successfully.']);
    }
}
