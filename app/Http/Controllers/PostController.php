<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('posts');
    }


    public function traer(){
        $post = Post::orderBy('title')->get();
        return response()->json([
            'posts' => $post
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function consumiApi(){
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');
        foreach ($response->json() as $post) {
          
            Post::create([
                'userId' => $post['userId'],
                'title' => $post['title'],
                'body' => $post['body']
            ]);
        }
        
        return response()->json([
            'message' => 'API Consumida Exitosamente',
        ],200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mesage' => 'Incorrect Data'
            ], 403);
        }

        $validated = $validator->validated();
        

        $post = Post::create([
            'userId' => $validated['userId'],
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return response()->json([
            'message' => 'Post Created',
            'post' => $post
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'userId' => 'required|numeric',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'mesage' => 'Incorrect Data'
            ], 403);
        }

        $validated = $validator->validated();

        $post->userID = $validated['userId'];
        $post->title = $validated['title'];
        $post->body = $validated['body'];
        $post->save();

        return response()->json([
            'post' => $post,
            'message' => 'Post Updated',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->first();
        $post->delete();

        return response()->json([
            'message' => 'Post Deleted'
        ], 200);
    }
}