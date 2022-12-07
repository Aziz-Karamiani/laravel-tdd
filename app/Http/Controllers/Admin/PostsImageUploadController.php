<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostsImageUploadController extends Controller
{
    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        // Image validation
        $request->validate(['image' => 'image|max:250|dimensions:max_width=100,max_height=200']);

        $image = $request->file('image');
        $image->move(public_path('storage/upload/posts/'), $image->hashName());

        return response()->json(['url' => public_path("storage/upload/posts/{$image->hashName()}")]);
    }
}
