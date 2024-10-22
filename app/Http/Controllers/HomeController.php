<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Blog\Models\Blog;

class HomeController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->take(10)->get();
        return view('welcome', compact('blogs'));
    }
}
