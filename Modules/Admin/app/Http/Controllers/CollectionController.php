<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Services\AdminComonService;
use Modules\Admin\Http\Requests\CollectionRequest;
use Modules\Admin\Models\Collection;

class CollectionController extends Controller
{
    private CommonRepository $comReo;
    private AdminComonService $adminService;
    public function __construct(AdminComonService $adminService)
    {
        $this->adminService = $adminService;
        $this->comReo = new CommonRepository(Collection::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 1);
        if ($request->ajax()) {
            $data = $this->comReo->all($limit);

            return response()->json(['data' => $data], 200);
        }

        return view('admin::collections.index');
    }
    public function collectionAjax(Request $request)
    {
        // dd($request->all());
        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $filter = $request->get('filter', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');

        $data = $this->comReo->getData(
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
        return view('admin::collections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CollectionRequest $request): RedirectResponse
    {

        try {
            DB::beginTransaction();

            $datas = $request->all();
            unset($datas['images']);
            unset($datas['collections']);
            unset($datas['display']);

            $data = $this->comReo->create($datas);
            if ($images = $request->file('images')) {
                $imgPath =  $this->adminService
                    ->ImageUpload($images,  'images/collections');
                $data->file_path = $imgPath;
            }

            if ($request->has('display')) {
                $data->display = ($request->display == 'on') ? 1 : 0;
            }

            if ($request->has('collections')) {
                $collection = $this->comReo->findByField('title', $request->collections);

                $data->collection_id = (!empty($collection)) ? $collection->id : 0;
            }
            $data->save();
            DB::commit();
            return redirect()
                ->back()
                ->with('success', 'Collection created successfully');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::collections.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::collections.edit');
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
}
