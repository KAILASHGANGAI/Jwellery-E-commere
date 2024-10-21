<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\Blog\Models\Blog;
use Illuminate\Support\Str;
use Modules\Blog\Services\CommonService;

class BlogController extends Controller
{
    protected $commonService;

    public function __construct()
    {
        $this->commonService = new CommonService(Blog::class);
    }

    // Display a listing of the blog Blogs
    public function index()
    {
        $blogs = Blog::all();
        return view('blog::blogs.index', compact('blogs'));
    }

    public function indexAjax(Request $request)
    {
        $pagination = $request->get('limit', 20);
        $search = $request->get('search', null);
        $filter = $request->get('filter', null);

        $sort_field = $request->get('sort_field', 'created_at');
        $sort_type = $request->get('sort_type', 'desc');

        $select = ['id', 'title', 'slug', 'category_id', 'status', 'featured_image', 'created_at', 'updated_at', 'created_by', 'updated_by'];
        $searchableFields = [
            'title',
            'status',
            'created_at',
        ];
        $data = $this->commonService->getData(
            $select,
            $search,
            $searchableFields,
            $filter,
            $sort_field,
            $sort_type,
            $limit ?? null,
            $pagination,
            ['createdBy:id,name']
        );

        return response()->json($data, 200);
    }

    // Show the form for creating a new Blog
    public function create()
    {
        return view('blog::blogs.create');
    }

    // Store a newly created blog Blog in storage
    public function store(BlogRequest $request)
    {
        $data = [
            'title' => $request->title,
            'slug' => $request->slug ?? Str::slug($request->title),
            'content' => $request->content,
            'keywords' => $request->keywords ?? null,
            'description' => $request->description ?? null,
            'tags' => $request->tags ?? null,
            'status' => $request->status ?? 0,
            'category_id' => $request->category_id,
            'created_by' => auth()->user()->id
        ];

        if ($request->hasFile('image')) {
            $img = $this->imageUpload($request->file('image'), 'images/blog');
            $data['featured_image'] = $img;
        }
        Blog::create($data);
        return redirect()->route('blogs.index')->with('success', 'Created Successfully');
    }

    // Display the specified blog Blog
    public function show(Blog $Blog)
    {
        return view('blog::blogs.show', compact('Blog'));
    }

    // Show the form for editing the specified Blog
    public function edit(Blog $Blog)
    {
        return view('blog::blogs.edit', compact('Blog'));
    }

    // Update the specified Blog in storage
    public function update(BlogRequest $request, $id)
    {
        $Blog = Blog::findOrFail($id);
        $data = [
            'title' => $request->title,
            'slug' => $request->slug ?? \Str::slug($request->title),
            'content' => $request->content,
            'keywords' => $request->keywords ?? null,
            'description' => $request->description ?? null,
            'tags' => $request->tags ?? null,
            'status' => $request->status ?? 0,
            'category_id' => $request->category_id,
            'updated_by' => auth()->user()->id
        ];
        if ($request->hasFile('image')) {
            if ($Blog->featured_image) {
                @unlink(public_path($Blog->featured_image));
            }
            $img = $this->imageUpload($request->file('image'), 'images/blog');
            $data['featured_image'] = $img;
        }
        $Blog->update($data);
        return redirect()->route('blogs.index')->with('success', 'Blog Updated Successfully.');
    }

    // Remove the specified Blog from storage
    public function destroy(Blog $Blog)
    {
        $Blog->delete();
        return redirect()->route('blog::blogs.index');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $this->commonService->bulkDelete($ids);
        return response()->json(['success' => 'Products deleted successfully.'], 200);
    }

    public function imageUpload($image, $path)
    {

        // Generate a unique name for the file
        $fileName = uniqid('photo_') . '.' . $image->getClientOriginalExtension();

        // Move the file to the public/photos/products directory
        $image->move(public_path($path), $fileName);

        // Store the file path
        $imagePaths = $path . '/' . $fileName;

        return $imagePaths;
    }
}
