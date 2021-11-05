<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data' => $post
        ], 200);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail post',
            'data' => $post
        ], 200);
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post created',
                'data' => $post
            ]);
        } else {
            response()->json([
                'success' => false,
                'message' => 'Post failed to save'
            ], 409);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        $post = Post::find($id);

        if ($post) {
            $post->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data' => $post
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post not found'
        ], 404);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if ($post) {
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deleted'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post not found'
        ], 404);
    }
}
