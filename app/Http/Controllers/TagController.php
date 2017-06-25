<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::select('id', 'name', 'slug', 'count')
            ->with(['posts' => function ($query) {
                return $query->select('id', 'title');
            }])
            ->get();

        return view('tag.index', compact('tags'));
    }
}
