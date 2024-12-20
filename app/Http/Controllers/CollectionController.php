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

    /**
     * Retrieve a list of active parent collections along with their active children collections.
     *
     * This method fetches collections with a `collection_id` of zero, indicating they are parent collections,
     * and includes their associated children collections that are active and displayed.
     * The results are ordered by the 'id' field in ascending order and returned as a JSON response.
     *
     * @param Request $request The incoming HTTP request containing optional query parameters.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of collections and their children.
     * Used for the navbar 
     */
    public function index(Request $request, $all = false)
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
        if ($all) {
            return $data;
        }

        return response()->json($data);
    }

    /**
     * Retrieve a list of all active children collections.
     *
     * This method fetches collections with a `collection_id` of not zero, indicating they are children collections,
     * and includes their associated children collections that are active and displayed.
     * The results are ordered by the 'id' field in ascending order and returned as a JSON response.
     *
     * @param Request $request The incoming HTTP request containing optional query parameters.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of children collections.
     */
    public function allCollection(Request $request){
        $collections = $this->index($request, true);
        return view('pages.collections', compact('collections'));
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

    public function show(Request $request, $slug)
    {

        $select = ['id', 'slug'];
        $condition = ['slug' => $slug];
        $collection = $this->comm->getData(
            Collection::query(),
            $select,
            $condition,
            -1
        );
        $request->pagination ? $request->pagination : $request['pagination'] = 1;
        $request->order ?  $request->order : $request['order'] = 'id';
        $request->orderType ?  $request->orderType : $request['orderType'] = 'asc';

        $productCondition = ['status' => 'active', 'display' => 1, 'collection_id' => $collection->id];
        $productselect = ['id', 'title', 'slug', 'price', 'compare_price', 'description'];

        // Split the tags by commas to create an array
        $tags = explode(',', $collection->tags);

        // Query to get products by collection_id and matching tags
        $products = $this->comm->getData(
            Product::query()->with([
                'images:id,product_id,image_path',
                'variations:id,product_id,sku,barcode,inventory'
            ]),
            $productselect,
            $productCondition,
            1
        );
//         $products2 = $this->comm->getData(
//             Product::query()->with([
//                 'images:id,product_id,image_path',
//                 'variations:id,product_id,sku,barcode,inventory'
//             ])
//                 // Filter products that match collection_id
//                 ->orWhere(function ($query) use ($tags) {
//                     foreach ($tags as $tag) {
//                         $query->orWhere('tags', 'like', '%' . trim($tag) . '%');
//                     }
//                 }),
//             $productselect,
//             null,
//             1
//         );
// dd($products1, $products2);
//         $products = array_merge($products1, $products2);

        return view('pages.collection', compact('collection', 'products'));
    }
}
