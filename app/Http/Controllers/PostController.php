<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use App\Posts;
use App\Http;
use App\User;
use App\Categories;
use Redirect;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\PostFormRequest;
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
        	$categories = Categories::all();
			return view('posts.create')->withCategories($categories);
		}
		else 
		{
			return redirect('/')->withErrors('You cant write posts');
		}
	}

	public function store(Request $request)
	{
		$post = new Posts();
		$post->title = $request->get('title');
		$post->body = $request->get('body');
		$post->slug = str_slug($post->title);
		$post->author_id = $request->user()->id;
		$post->category_id = $request->category_id;
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
		//return redirect('edit/'.$post->slug)->withMessage($message);
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

	public function edit($id)
	{
		$categories = Categories::all();
		$cat = DB::table('categories')
			->join('posts','categories.id', '=', 'posts.category_id')
			->where('posts.category_id', '=', $id)
			->select('categories.id', 'categories.title')
			->get();
		$cat = $cat[0];
		$post = Posts::find($id);
        return view('posts.edit')->withPost($post)->withCategories($categories)->withCat($cat);
	}

	public function update($id)
	{	
        $post = Posts::find($id);
        $post->title = $requset->title;
        $post->category_id = $request->category_id;
        $post->save();

        return view('home');
	}
}