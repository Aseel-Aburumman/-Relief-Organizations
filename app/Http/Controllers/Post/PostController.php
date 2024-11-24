<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::getAllPosts();
        return view('dashboard.post.index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::getPostById($id);
        return view('dashboard.post.show', compact('post'));
    }

    public function create()
    {
        $languages = \App\Models\Language::all();
        return view('dashboard.post.create', compact('languages'));
    }

    public function store(PostStoreRequest $request)
    {
        Post::createPost($request->validated());
        return redirect()->route('posts.manage')->with('success', 'Post created successfully');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $languages = \App\Models\Language::all();
        return view('dashboard.post.edit', compact('post', 'languages'));
    }

    public function update(PostUpdateRequest $request, $id)
    {
        Post::updatePost($id, $request->validated());
        return redirect()->route('posts.manage')->with('success', 'Post updated successfully');
    }

    public function destroy($id)
    {
        Post::deletePost($id);
        return redirect()->route('posts.manage')->with('success', 'Post deleted successfully');
    }
}
