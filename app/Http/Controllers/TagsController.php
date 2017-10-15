<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

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

        return Tag::create($attributes);
    }
}
