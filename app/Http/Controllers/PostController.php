<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $email = session('email');
        $user = User::where('email', $email)->first();
        $posts = User::find($user->id)->posts;

        return view('examples.posts')->with(['user' => $user, 'posts' => $posts]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'post' => ['required']
        ]);

        $user_id = $request->user_id;
        $title = $request->title;
        $post = $request->post;

        $created = Post::create([
            'user_id' => $user_id,
            'title' => $title,
            'post' => $post
        ]);

        if($created->save())
        {
            return redirect()->route('posts');
        }
    }
}
