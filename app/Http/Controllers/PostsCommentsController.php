<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostsCommentsController extends Controller
{
    /**
     * @param  Request  $request
     * @param  Post  $post
     * @return JsonResponse
     */
    public function store(Request $request, Post $post)
    {
        $request->validate(['text' => 'required']);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'text' => $request->input('text'),
        ]);

        return response()->json(['created' => true]);
    }
}
