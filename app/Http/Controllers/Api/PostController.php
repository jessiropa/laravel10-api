<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// import model post
use App\Models\Post;
// import resource postresource
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    public function index(){
        $posts = Post::latest()->paginate(5);
        return new PostResource(true, 'List Data Posts', $posts);   
    }

    public function store(Request $request){        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        // upload image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $post = Post::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'content' => $request->content
        ]);

        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);   
    }

    public function show($id){
        $post = Post::find($id);

        return new PostResource(true, 'Detail Data Post!', $post);
    }
}