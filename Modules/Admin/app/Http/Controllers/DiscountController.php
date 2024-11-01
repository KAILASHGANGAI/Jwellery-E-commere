<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Http\Requests\DiscountRequest;
use Modules\Admin\Models\Collection;
use Modules\Admin\Models\Discount;
use Modules\Admin\Models\DiscountCollection;
use Modules\Admin\Models\DiscountProduct;
use Modules\Admin\Models\Product;
use Modules\Admin\Services\AdminComonService;

class DiscountController extends Controller
{
    protected CommonRepository $comRepo;
    protected AdminComonService $adminService;

    public function __construct( AdminComonService $adminService)
    {
        $this->adminService = $adminService;
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
            'start_date',
            'end_date',
            'type',
            'value',
            'status',
            'discount_on',
            'created_at',
        ];
        $data = $this->comRepo->getData(
            $select,
            $search,
            $select,
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
        return view('admin::discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request): RedirectResponse
    {

        try {
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
                'type' => $request->type,
                'value' => $request->value,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'discount_on' => $request->discount_on,
                'status' => $request->status,
                'product_ids' => $request->discount_on == 'products' ? implode(',', $request->ids) : null,
                'collection_ids' => $request->discount_on == 'collections' ? implode(',', $request->ids) : null,
                'tags' => $request->tags ?? null
            ];

            if ($images = $request->file('images')) {
                $imgPath =  $this->adminService
                    ->ImageUpload($images,  'images/discounts');
                $data['image'] = $imgPath;
            }

            $discount = $this->comRepo->create($data);
            if ($request->discount_on == 'products') {
                foreach ($request->ids as $id) {
                    DiscountProduct::create([
                        'discount_id' => $discount->id,
                        'product_id' => $id,
                        'status' => '1',
                    ]);
                }
            }

            if ($request->discount_on == 'collections') {
                foreach ($request->ids as $id) {
                    DiscountCollection::create([
                        'discount_id' => $discount->id,
                        'collection_id' => $id,
                        'status' => '1',
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Discount created successfully');
        } catch (Exception $e) {
            DB::rollBack();
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
        $discount = $this->comRepo->find($id);
        return view('admin::discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, $id): RedirectResponse
    {
        try {
            $discount = $this->comRepo->find($id);
            DB::beginTransaction();
            $data = [
                'name' => $request->name,
                'type' => $request->type,
                'value' => $request->value,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'discount_on' => $request->discount_on,
                'status' => $request->status,
                'product_ids' => $request->discount_on == 'products' ? implode(',', $request->ids) : null,
                'collection_ids' => $request->discount_on == 'collections' ? implode(',', $request->ids) : null,
                'tags' => $request->tags ?? null
            ];

            if ($images = $request->file('images')) {
                $imgPath =  $this->adminService
                    ->ImageUpload($images,  'images/discounts');
                    if (file_exists($discount->image)) {
                        unlink($discount->image);
                                               
                    }
                $data['image'] = $imgPath;
            }

            $discount = $this->comRepo->update($id,$data);
            if ($request->discount_on == 'products') {
                $desabled = DiscountProduct::where('discount_id', $discount->id)->update(['status'=> '0']);
                foreach ($request->ids as $id) {
                    $desabled->update(['status' => '0']);
                    DiscountProduct::updateOrCreate([
                        'discount_id' => $discount->id,
                        'product_id' => $id,
                    ],[
                        'status' => '1',
                    ]);
                }
            }

            if ($request->discount_on == 'collections') {
                $desabled = DiscountCollection::where('discount_id', $discount->id)->update(['status'=> '0']);
                foreach ($request->ids as $id) {
                    DiscountCollection::updateOrCreate([
                        'discount_id' => $discount->id,
                        'collection_id' => $id,
                    ],[
                        'status' => '1',
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Discount Updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
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

    public function getLists(Request $request)
    {
        $data = [];
        if ($request->type == 'collections') {
            $query = new CommonRepository(Collection::class);
            $select = [
                'id',
                'title',
                'status'
            ];
            $data = $query->getData(
                $select,
                null,
                null,
                null,
                'title',
                'asc',
                null,
                5
            );
        }
        if ($request->type == 'products') {

            $query = new CommonRepository(Product::class);
            $select = [
                'id',
                'title',
                'status'
            ];
            $data = $query->getData(
                $select,
                null,
                null,
                null,
                'title',
                'asc',
                null,
                5
            );
        }
        return response()->json($data, 200);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->get('ids');

        $this->comRepo->bulkDelete($ids);

        return response()->json(['success' => 'Deleted successfully.']);
    }
}
