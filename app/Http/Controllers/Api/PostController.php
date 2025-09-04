<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// import model post
use App\Models\Post;
// import resource postresource
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    //
    public function index(){
        $posts = Post::latest()->paginate(5);
        return new PostResource(true, 'List Data Posts', $posts);   
    }
}