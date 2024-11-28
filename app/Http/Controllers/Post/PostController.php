<?php

namespace App\Http\Controllers\Post;

use App\Models\Language;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user = User::find($user->id);
        if ($user->hasRole('admin')) {

            $posts = Post::getAllPosts();
        } elseif ($user->hasRole('organization')) {
            $organization = Organization::fetchOrganizationWithNeedsAndDonations(auth()->id());

            $posts = Post::fetchPostsWithImagesWityhoutLang($organization->id);
        }
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


    public function getOne($id)
    {
        $languageId = Language::getLanguageIdByLocale();


        $post = Post::with('images')
            ->where('id', $id)
            ->first();
        $organization = Organization::with(['userDetail' => function ($query) use ($languageId) {
            $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
        }])
            ->find($post->organization_id);
        $posts = Post::with('images')
            ->where('lang_id', $languageId)

            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('organization.single-blog', compact('post', 'posts', 'organization'));
    }

    public function getAll($organization_id)
    {
        $languageId = Language::getLanguageIdByLocale();

        $organization = Organization::with(['userDetail' => function ($query) use ($languageId) {
            $query->orderByRaw("FIELD(language_id, ?, 1, 2)", [$languageId]);
        }])
            ->find($organization_id);

        $posts = Post::with('images')
            ->where('lang_id', $languageId)
            ->where('organization_id', $organization_id)

            ->orderBy('created_at', 'desc')
            ->paginate(6);


        return view('organization.blog', compact('posts', 'organization'));
    }
}
