<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function index(Tag $tag)
    {
        return view('posts.index', ['posts' => $tag->posts()->latest()->paginate(10)]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate(['name' => 'required|unique:tags,name']);
        $tag = Tag::create($attributes);
        return $tag;
    }
}
