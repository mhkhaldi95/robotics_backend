<?php

namespace Modules\News\Http\Controllers\Student;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller ;
use Modules\News\Entities\Post;
use Validator;

class PostController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware(['authorizor:students']);
    }

    public function index()
    {
        if(!$this->user->hasTerm('read_post')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لقراءة الأخبار ، يرجى شراء باقة',
            ]);
        }

        $posts = Post::where('approved_at',null)->get();
        return response()->json($posts);
    }

    public function create()
    {
        return view('news::create');
    }

    public function store(Request $request)
    {
    }

    public function show(Post $post)
    {
        if(!$this->user->hasTerm('read_post')){
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لقراءة الأخبار ، يرجى شراء باقة',
            ]);
        }

        if($post->approved_at == null){
            return response()->json([
                'success' => false,
                'message' => 'هذا الخبر لم يتم الموافقة عليه بعد',
            ]);
        }
        return response()->json($post);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
