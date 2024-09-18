<?php

namespace App\Http\Controllers;

use App\Services\commonServices;
use Illuminate\Http\Request;
use Modules\Admin\Models\Collection;

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
        $data = $this->comm->getData(
            $model,
            $select,
            $condition,
            0,
        );

        if ($request->ajax()) {

            return response()->json($data);
        }
        return response()->json($data);
    }

    public function showAllChildrens(Request $request){

        $select = ['id', 'title', 'slug', 'file_path', 'collection_id'];
        $condition = ['status' => 'active', 'display' => 1];
        $data = $this->comm->getData(
            Collection::query()->where('collection_id', '!=', 0),
            $select,
            $condition,
            0,
            'id',
            'asc',
        );

        return response()->json($data);
    }

    public function show($slug){

        $select = ['id', 'title', 'slug', 'file_path', 'collection_id'];
        $condition = ['slug' => $slug];
        $data = $this->comm->getData(
            Collection::query(),
            $select,
            $condition,
            1
        );

        return response()->json($data);
    }
}
