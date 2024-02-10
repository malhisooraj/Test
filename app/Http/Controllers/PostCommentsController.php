<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentsController extends Controller
{
    public function store(Post $post)
    {

        \request()->validate([
            'body' => 'required'
        ]);

        // add comment to the post
        $post->comments()->create([
            'user_id' => \request()->user()->id, //auth()->id or auth()->user()->id()
            'body' => \request('body'),
        ]);

        return back();
    }
}
