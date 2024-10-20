<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\Blog\Models\Blog;


class BlogController extends Controller
{
    // Display a listing of the blog Blogs
    public function index()
    {
        $blogs = Blog::all();
        return view('Blogs.index', compact('blogs'));
    }

    // Show the form for creating a new Blog
    public function create()
    {
        return view('Blogs.create');
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
            'published' => $request->status ?? 0,
            'category_id' => $request->category_id,
            'created_by'=> auth()->user()->id
        ];
        if ($request->hasFile('image')) {
            $img = $this->imageUpload($request->file('image'), 'images/blog');
            $data['featured_image'] = $img;
        }
        Blog::create($data);
        return redirect()->route('Blogs.index');
    }

    // Display the specified blog Blog
    public function show(Blog $Blog)
    {
        return view('Blogs.show', compact('Blog'));
    }

    // Show the form for editing the specified Blog
    public function edit(Blog $Blog)
    {
        return view('Blogs.edit', compact('Blog'));
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
            'published' => $request->status ?? 0,
            'category_id' => $request->category_id,
            'updated_by'=> auth()->user()->id
        ];
        if ($request->hasFile('image')) {
            if ($Blog->featured_image) {
                @unlink(public_path($Blog->featured_image));
            }
            $img = $this->imageUpload($request->file('image'), 'images/blog');
            $data['featured_image'] = $img;
        }
        $Blog->update($data);
        return redirect()->route('Blogs.index');
    }

    // Remove the specified Blog from storage
    public function destroy(Blog $Blog)
    {
        $Blog->delete();
        return redirect()->route('Blogs.index');
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
