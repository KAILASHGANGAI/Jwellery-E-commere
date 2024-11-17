<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\CommonRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Http\Requests\ProductRequest;
use Modules\Admin\Models\Collection;
use Modules\Admin\Models\Product;
use Modules\Admin\Services\AdminComonService;
use Illuminate\Support\Str;
use Modules\Admin\Models\Image;
use Modules\Admin\Models\Variation;

class ProductController extends Controller
{
    private CommonRepository $comReo;
    private AdminComonService $adminService;
    public function __construct(AdminComonService $adminService)
    {
        $this->adminService = $adminService;
        $this->comReo = new CommonRepository(Product::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::products.index');
    }
    public function productAjax(Request $request)
    {
        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $filter = $request->get('filter', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');
        $select  = [
            'id',
            'title',
            'product_type',
            'description',
            'status',
            'display',
            'price',
            'compare_price',
            'cost',
            'created_at',
        ];
        $searchableFields = [
            'title',
            'status',
            'display',
            'description',
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
            ['images:id,product_id,image_path', 'variations:id,product_id,inventory']
        );

        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::products.create');
    }
    public function new()
    {
        return view('admin::products.new');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            dd($request->all());
            DB::beginTransaction();
            $collectionID = $this->adminService->findByField(
                Collection::class,
                'title',
                $request->collections
            );

            $products = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'status' => $request->status,
                'price' => $request->price,
                'compare_price' => $request->compare_price,
                'cost' => $request->cost,
                'display' => isset($request->display) && $request->display == 'on' ? 1 : 0,
                'vendor' => $request->vendor,
                'product_type' => $request->product_type,
                'collections' => $request->collections,
                'collection_id' => $collectionID ? $collectionID->id : 0,
                'tags' => $request->tags,
            ];
            $product = $this->comReo->create($products);
            foreach ($request->name as $key => $value) {
                $vdata = [
                    'name' => $value,
                    'product_id' => $product->id,
                    'sku' => $request->sku[$key],
                    'barcode' => $request->barcode[$key],
                    'inventory' => $request->inventory[$key],
                ];
                $product->variations()->create($vdata);
            }

            if ($request->hasFile('images') && $images = $request->file('images')) {
                foreach ($images as $key => $image) {

                    $imageName = $image->getClientOriginalName();
                    $imgPath = $this->adminService->ImageUpload($image,  'images/products');
                    $idata = [
                        'product_id' => $product->id,
                        'name' => $imageName ?? null,
                        'image_path' => $imgPath,
                        'image_url' => config('app.url') . '/' . $imgPath
                    ];

                    $product->images()->create($idata);
                }
            }
            DB::commit();
            return back()->with('success', 'Product created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withInput($request->all())->with('error', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = $this->comReo->find($id);
        return view('admin::products.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            // dd($request->all());
            DB::beginTransaction();
            $collectionID = $this->adminService->findByField(
                Collection::class,
                'title',
                $request->collections
            );

            $products = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'status' => $request->status,
                'price' => $request->price,
                'compare_price' => $request->compare_price,
                'cost' => $request->cost,
                'display' => isset($request->display) && $request->display == 'on' ? 1 : 0,
                'vendor' => $request->vendor,
                'product_type' => $request->product_type,
                'collections' => $request->collections,
                'collection_id' => $collectionID ? $collectionID->id : 0,
                'tags' => $request->tags,
            ];
            $product = $this->comReo->update($id,$products);
            foreach ($request->name as $key => $value) {
                $vdata = [
                    'name' => $value,
                    'barcode' => $request->barcode[$key],
                    'inventory' => $request->inventory[$key],
                ];
                $condition = [
                    'product_id' => $product->id,
                    'sku' => $request->sku[$key],
                ];
                $this->adminService->createOrUpdateByField(Variation::class, $condition, $vdata);
            }

            if ($request->hasFile('images') && $images = $request->file('images')) {
                Image::where('product_id', $product->id)->update(['is_deleted'=>1]);
                foreach ($images as $key => $image) {

                    $imageName = $image->getClientOriginalName();
                    $imgPath = $this->adminService->ImageUpload($image,  'images/products');
                    $idata = [
                        'product_id' => $product->id,
                        'name' => $imageName ?? null,
                        'image_path' => $imgPath,
                        'image_url' => config('app.url') . '/' . $imgPath
                    ];

                    $product->images()->create($idata);
                }
            }
            DB::commit();
            return back()->with('success', 'Product created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return back()->withInput($request->all())->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->comReo->find($id);
        $data->delete();
        return back()->with('success', 'Product deleted successfully');
        
    }
    public function bulkDelete(Request $request){

        $ids = $request->ids;
        $this->comReo->bulkDelete($ids);
        return response()->json(['success' => 'Products deleted successfully.'], 200);
    }
}
