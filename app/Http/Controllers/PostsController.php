<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\PostsRequest as PostsRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $posts = Post::latest()->paginate(15);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        $tags = Tag::all();

        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostsRequest  $request
     * @return RedirectResponse
     */
    public function store(PostsRequest $request)
    {
        $post = auth()->user()->posts()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
        ]);

        $post->tags()->attach($request->input('tags'));

        return redirect()->route('posts.index')->with('message', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return Application|Factory|View|void
     */
    public function show(Post $post)
    {
        $comments = $post->comments()->latest()->paginate(10);

        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return Application|Factory|View
     */
    public function edit(Post $post)
    {
        $tags = Tag::all();

        return view('posts.edit', compact('tags', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostsRequest  $request
     * @param  Post  $post
     * @return RedirectResponse
     */
    public function update(PostsRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
        ]);

        $post->tags()->sync($request->input('tags'));

        return redirect()->route('posts.index')->with('message', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        $post->comments()->delete();
        $post->delete();

        return redirect()->route('posts.index')->with('message', 'Post deleted successfully.');
    }
}
