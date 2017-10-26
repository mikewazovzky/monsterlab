<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsAdjustmentsController extends Controller
{
    public function index(Post $post)
    {
        return view(
            'posts.adjustments',
            ['adjustments' => $post->adjustments()->paginate(10)]
        );
    }
}
