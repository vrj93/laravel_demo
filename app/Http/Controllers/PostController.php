<?php

namespace App\Http\Controllers;

use App\Jobs\CreatePost;
use App\Models\Post;
use App\Models\User;
use App\Notifications\MyFirstNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    public function index()
    {
        $email = session('email');
        $user = User::where('email', $email)->first();
        $posts = User::find($user->id)->posts;

        $searchPost = new Post;
        $searchPost->searchable();

        return view('examples.posts')->with(['user' => $user, 'posts' => $posts]);
    }

    public function store(Request $request)
    {
        $email = session('email');

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

        $user = User::find($user_id);

        $details = [
            'data' => $title,
            'notifiable_id' => $user_id
        ];

        if($created->save())
        {
            dispatch(new CreatePost($email))->delay(now()->addMinutes(1)); //Queue

            Notification::send($user, new MyFirstNotification($details)); //Notification

            return redirect()->route('posts');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'title_e' => ['required'],
            'post_e' => ['required']
        ]);

        Post::where('id', $request->post_id)->update([
            'title' => $request->title_e,
            'post' => $request->post_e
        ]);

        return redirect()->route('posts');
    }

    public function delete($id)
    {
        Post::where('id', $id)->delete();

        return back();
    }

    public function search(Request $request)
    {
        $email = session('email');
        $user = User::where('email', $email)->first();
        $result = Post::search($request->searchText)->where('user_id', $user->id)->get();

        return view('examples.searchpost')->with('searchResult', $result);
    }
}
