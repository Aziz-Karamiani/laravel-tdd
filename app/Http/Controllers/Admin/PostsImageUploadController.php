<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostsImageUploadController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        $image = $request->file('image');
        $image->move(public_path("storage/upload/posts/"), $image->hashName());
        return response()->json(['url' => public_path("storage/upload/posts/{$image->hashName()}")]);
    }
}
