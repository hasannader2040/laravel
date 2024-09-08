<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Jobs\SendPostNotification;

class PostController extends Controller
{
    public function thebest()
    {
        $posts = Post::with('category')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post->user_id) {
            $post->delete();
        }
        return redirect('/home');
    }

    public function actuallyUpdatePost(Post $post, Request $request)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/');
    }

    public function showHomePage()
    {
        $categories = Category::all(); // Fetch all categories
        // $posts = Post::latest()->get(); // Or however you fetch posts
        $posts = Post::paginate(10);
        return view('home', compact('categories', 'posts')); // Pass categories to the view
    }

    public function showEditScreen(Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/'); //
        }

        return view('edit-posts', ['post' => $post]);
    }

    public function createPost(Request $request)  //database
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['category_id'] = strip_tags($incomingFields['category_id']);
        $incomingFields['user_id'] = auth()->id();

        $post = Post::create($incomingFields);

        // Send email to subscribers
        dispatch(new SendPostNotification($post));

        return redirect()->route('home');
    }

    //$posts = Post::paginate(10);


    public function links()
    {
        $posts = Post::paginate(10);
        return view('links', compact('posts')); // home.blade.php
    }

    public function index()
    {
        $posts = Post::with('category')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function formCreatePost()
    {

        return view('home');
    }


    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email|unique:subscriptions,email']);
        Subscription::create(['email' => $request->email]);
        return view('home')->with('success', 'Subscribed successfully!');
    }
}
