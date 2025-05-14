<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    public function index(): mixed
    {
        $posts = Post::where('status', 'publish')->orderBy('id', 'desc')->paginate(5);
        $recents = Post::limit(4)->get();
        // dd();
        return view('pages.blogs.index', [
            'posts' => $posts,
            'recents' => $recents,
        ]);
    }

    public function show($slug)
    {
        $recents = Post::limit(4)->get();
        $post = Post::findBySlug($slug);

        return view(view: 'pages.blogs.show', data: [
            'blog' => $post,
            'recents' => $recents,
        ]);
    }

}
