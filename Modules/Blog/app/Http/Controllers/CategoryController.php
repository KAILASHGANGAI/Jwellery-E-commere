<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Blog\Http\Requests\CategoryRequest;
use Modules\Blog\Models\Category;
use Modules\Blog\Services\CommonService;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    protected $commonService;

    public function __construct()
    {
        $this->commonService = new CommonService(Category::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('blog::category.index');
    }
    public function indexAjax(Request $request)
    {
        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');

        $select = ['id', 'title', 'slug', 'created_at', 'updated_at'];
        $searchableFields = [
            'title'
        ];
        $data = $this->commonService->getData(
            $select,
            $search,
            $searchableFields,
            null,
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
        return view('blog::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        try {
            $data = [
                'title' => $request->title,
                'slug' => $request->slug ?? Str::slug($request->title),
            ];
            $this->commonService->create($data);
            return back()->with('success', 'Category created successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $category = Category::find($id);
        $category->update([
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
        ]);

        return back()->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->commonService->delete($id);
        return back()->with('success', 'Deleted Successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $this->commonService->bulkDelete($ids);
        return response()->json(['success' => 'Products deleted successfully.'], 200);
    }
}
