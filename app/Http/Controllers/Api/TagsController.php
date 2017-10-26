<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::all();

        return response($tags, 200);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate(['name' => 'required|unique:tags,name']);

        $tag = Tag::create($attributes);

        return response($tag, 201);
    }
}
