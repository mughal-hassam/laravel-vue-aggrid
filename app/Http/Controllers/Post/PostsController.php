<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return Inertia::render('Post/index', compact('posts'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Post $post)
    {
    }

    public function edit(Post $post)
    {
    }

    public function update(Request $request, Post $post)
    {
    }

    public function destroy(Post $post)
    {
    }
}
