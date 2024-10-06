<?php

namespace App\Http\Controllers;

use App\Services\commonServices;
use Illuminate\Http\Request;
use Modules\Admin\Models\Product;

class ProductController extends Controller
{
    protected $comm;
    public function __construct(commonServices $comm)
    {
        $this->comm = $comm;
    }

    public function index(Request $request)
    {

        $select = ['id', 'title', 'slug', 'price', 'compare_price', 'description', 'collections', 'tags'];
        $condition = ['status' => 'active', 'display' => 1];
        $request->order ?? $request['order'] = 'id';
        $request->orderType ?? $request['orderType'] = 'asc';
        $request->orderType ?? 'asc';
        $tag = $request->tag ?? null;
        $query = Product::query()->with(['images:id,product_id,image_path', 'variations:id,product_id,sku,barcode,inventory']);
        $request->pagination ?? $request['pagination'] = 20;
        if ($tag) {
            $query->where('tags', 'like', '%' . $tag . '%');
        }
        $limitflag = null;
        $products = $this->comm->getData(
            $query,
            $select,
            $condition,
            $limitflag,
            $request
        );
  
        return view('pages.collection', compact('products'));
    }

    public function ajaxIndex(Request $request)
    {

        $select = ['id', 'title', 'slug', 'price', 'compare_price', 'description', 'collections', 'tags'];
        $condition = ['status' => 'active', 'display' => 1];
        $request->order ?? $request['order'] = 'id';
        $request->orderType ?? $request['orderType'] = 'asc';
        $request->orderType ?? 'asc';
        $tag = $request->tag ?? null;
        $query = Product::query()->with(['images:id,product_id,image_path', 'variations:id,product_id,sku,barcode,inventory']);

        if ($tag) {
            $query->where('tags', 'like', '%' . $tag . '%');
        }
        $limitflag = 1;
        $data = $this->comm->getData(
            $query,
            $select,
            $condition,
            $limitflag,
            $request
        );
        return response()->json($data);
    }
    public function show($slug)
    {

        $select = ['id', 'title', 'slug', 'price', 'compare_price', 'description', 'collections', 'tags'];
        $condition = ['status' => 'active', 'display' => 1, 'slug' => $slug];
        $data = $this->comm->getSingleData(
            Product::query()->with(['images:id,product_id,image_path', 'variations:id,product_id,sku,barcode,inventory']),

            $select,
            $condition
        );
        // dd($data);
        return view('products.product-details', compact('data'));
    }
    // app/Http/Controllers/CartController.php
    public function add(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        return response()->json(['message' => 'Product added to cart'], 200);
    }

    public function search(Request $request)
    {
        $search = $request->get('search', null);
        $select = ['id', 'title', 'slug', 'price', 'compare_price', 'description', 'collections', 'tags'];
        $condition = ['status' => 'active', 'display' => 1];
        $request->order ?? $request['order'] = 'id';
        $request->orderType ?? $request['orderType'] = 'asc';
        $request->pagination ?? $request['pagination'] = 10;
        $products = $this->comm->getData(
            Product::query()->with([
                'images:id,product_id,image_path',
                'variations:id,product_id,sku,barcode,inventory'
            ])
                ->where($condition)
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('tags', 'like', '%' . $search . '%')
                        ->orWhere('collections', 'like', '%' . $search . '%');
                }),
            $select,
            [],
            0,
            $request
        );

       return  view('pages.search', compact('products'));  
    }
}
