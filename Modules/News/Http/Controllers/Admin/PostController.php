<?php

namespace Modules\News\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Carbon\Carbon;
use DateTimeZone;
use Modules\News\Entities\Post;
use Validator;

class PostController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:admins']);
    }

    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $valditor = Validator::make($request->all(), Post::$rules,Post::$messages);

        if($valditor->fails()){
            return response()->json($valditor->errors(),404);
        }

        $post = Post::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'approved_at' => Carbon::now(new DateTimeZone('Asia/riyadh')),
        ]);


        $this->user->posts()->save($post);

        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'post' => $post
        ]);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function edit(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $valditor = Validator::make($request->all(), Post::$rules,Post::$messages);

        $post->update($valditor->validated());
            return response()->json([
                'success' => true,
                'message' => 'sucess',
                'post' => $post
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'sucess',
            'post' => $post
        ]);
    }
}
