<?php 

namespace App\Http\Controllers;

use App\Posts;
use App\Comments;
use Redirect;
use App\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class CommentController extends Controller
{
	//store a newly created resource
	public function store(Request $request)
	{
		$input['from_user']=$request->user()-id;
		$input['on_post']=$request->input('on_post');
		$input['body']= $request->input('body');
		$slug = $request->input('slug');
		Comments::create($input);

		return redirect($slug)->with('message','Comment published');
	}

	public function show($id)
	{

	}

	public function edit($id)
	{

	}

	public function update($id)
	{

	}

	public function destroy($id)
	{
		
	}
}