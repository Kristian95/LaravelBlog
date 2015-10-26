<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Posts;
use App\Http;
use App\User;
use Redirect;
use App\Http\Requests\PostFormRequest;
use App\Http\Controllers\Controller;

class PostController extends Controller 
{
	public function index()
	{
		$posts = Posts::where('active',1)->orderBy('created_at','desc')->paginate(5);

		$title = 'Latest Post';

		return view('home')->withPosts($posts)->withTitle($title);
	}

	public function create(Request $request)
	{
		if($request->user()->can_post())
		{
			return view('posts.create');
		}
		else 
		{
			return redirect('/')->withErrors('You cant write posts');
		}
	}

	public function store(PostFormRequest $request)
	{
		$post = new Posts();
		$post->title = $request->get('title');
		$post->body = $request->get('body');
		$post->slug = str_slug($post->title);
		$post->author_id = $request->user()->id;
		if($request->has('save'))
		{
			$post->active = 0;
			$message = 'Post saved';
		}
		else 
		{
			$post->active = 1;
			$message = 'Post published';
		}
		$post->save();
		return redirect('edit/'.$post->slug)->withMessage($message);
	}

	public function show($slug)
	{
		$post = Posts::where('slug',$slug)->first();

		if(!$post)
		{
			return redirect('/')->withErrors('Page not found');
		}
		$comments = $post->comments;
		return view('posts.show')->withPost($post)->withComments($comments);
	}
}