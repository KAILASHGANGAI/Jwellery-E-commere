<?php

namespace App\Http\Controllers;

use App\Services\commonServices;
use Illuminate\Http\Request;
use Modules\Admin\Models\Collection;
use Modules\Admin\Models\Product;

class CollectionController extends Controller
{

    protected $comm;
    public function __construct(commonServices $comm)
    {
        $this->comm = $comm;
    }

    public function index(Request $request)
    {
        $select = ['id', 'title', 'slug', 'file_path', 'collection_id'];
        $condition = ['status' => 'active', 'display' => 1, 'collection_id' => 0];
        $model =  Collection::query()->with(['children' => function ($q) {
            $q->select('id', 'title', 'slug', 'file_path',  'collection_id');
            $q->where('status', 'active');
            $q->where('display', 1);
            $q->where('collection_id', '!=', 0);
        }]);
        $request['order'] = 'id';
        $request['orderType'] = 'asc';
        $data = $this->comm->getData(
            $model,
            $select,
            $condition,
            1,
            $request
        );

        if ($request->ajax()) {

            return response()->json($data);
        }
        return response()->json($data);
    }

    public function showAllChildrens(Request $request)
    {

        $select = ['id', 'title', 'slug', 'file_path', 'collection_id'];
        $condition = ['status' => 'active', 'display' => 1];
        $request['order'] = 'id';
        $request['orderType'] = 'asc';
        $limitflag = 1;
        $data = $this->comm->getData(
            Collection::query()->where('collection_id', '!=', 0),
            $select,
            $condition,
            $limitflag,
            $request
        );

        return response()->json($data);
    }

    public function show($slug)
    {

        $select = ['id', 'slug'];
        $condition = ['slug' => $slug];
        $collection = $this->comm->getData(
            Collection::query(),
            $select,
            $condition,
            -1
        );
        $request['pagination'] = 5;
        $request['order'] = 'id';
        $request['orderType'] = 'asc';
        $productCondition = ['status' => 'active', 'display' => 1, 'collection_id' => $collection->id];
        $productselect = ['id', 'title', 'slug', 'price', 'compare_price', 'description'];
        $products = $this->comm->getData(
            Product::query()->with([
                'images:id,product_id,image_path',
                'variations:id,product_id,sku,barcode,inventory'
            ]),
            $productselect,
            $productCondition,
            1
        );

        return view('pages.collection', compact('collection', 'products'));

    }
}