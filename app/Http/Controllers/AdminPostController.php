<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::filter(['status' => 'published'])->paginate(50)
        ]);
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'slug' => ['required', Rule::unique('posts', 'slug')],
            'excerpt' => 'required',
            'status' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        if($request->hasfile('thumbnail'))
        {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $request->thumbnail->storeAs('public/thumbnails', $filename);
            $attributes['thumbnail'] = $filename;

        }

        $attributes['user_id'] = auth()->id();
       // $attributes['thumbnail'] = $request->file('thumbnail')->store('thumbnails');

        Post::create($attributes);

        return redirect('/')->with('success', 'Post has been created!');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post, Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
            'excerpt' => 'required',
            'status' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        if ($attributes['thumbnail'] ?? false) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $request->thumbnail->storeAs('public/thumbnails', $filename);
            $attributes['thumbnail'] = $filename;
        }

        $post->update($attributes);

        return back()->with('success', 'Post Updated!');

    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post Deleted!');
    }
}
