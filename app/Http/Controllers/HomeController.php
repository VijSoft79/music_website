<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $curatorCount = User::role('curator')->where('is_approve', 1)->count();
        $musicianCount = User::role('musician')->where('is_approve', 1)->count();
        $newUserCount = User::role('musician')->where('is_approve', 0)->count();
        
        $posts = Post::orderBy('id', 'desc')->take(4)->where('status', 'publish')->get();

        return view('home', compact(['curatorCount','musicianCount','newUserCount', 'posts']));
    }
}
