<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blog\Models\Blog;
use Modules\Blog\Models\Category;

class BlogController extends Controller
{

    public function index()
    {
        $blogs = Blog::latest()->paginate(16);
        $categories = Category::select('id', 'title', 'slug')->get();
        $recentBlogs = Blog::latest()->take(5)->get(['id', 'title', 'slug', 'featured_image', 'created_at']);
        return view('blogs.blogs', compact('blogs', 'categories', 'recentBlogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        $categories = Category::select('id', 'title', 'slug')->get();
        $recentBlogs = Blog::latest()->take(5)->get(['id', 'title', 'slug', 'featured_image', 'created_at']);
        return view('blogs.blog-details', compact('blog', 'categories', 'recentBlogs'));
    }

    public function category($slug)
    {

        $category = Category::where('slug', $slug)->first();
        $blogs = Blog::where('category_id', $category->id)->latest()->paginate(16);
        $categories = Category::select('id', 'title', 'slug')->get();
        $recentBlogs = Blog::latest()->take(5)->get(['id', 'title', 'slug', 'featured_image', 'created_at']);
        return view(
            'blogs.blogs',
            compact('blogs', 'categories', 'recentBlogs', 'category')
        );
    }
}
