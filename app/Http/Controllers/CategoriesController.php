<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Categories;
use Session;

class CategoriesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // display a view of all of our categories
        // it will also have a form to create a new category

        $categories = Categories::all();
        return view('categories.index')->withCategories($categories);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Save a new category and then redirect back to index

        $categories = new Categories;

        $this->validate($request, array(
                'title' => 'min:3|max:255',
            ));

        $categories->title = $request->title;
        $categories->save();

        Session::flash('success', 'The blog post was successfully save!');

        return redirect('/');
    }

    public function create(Request $request)
    {
        return view('categories.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function edit($id)
    {
        $category = Categories::find($id);
        return view('categories.edit')->withCategories($category);
    }

    public function update(Request $request, $id)
    {
        $category = Categories::find($id);
        $category->title = $requset->title;
        $category->save();

        return view('categories.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::find($id);
        $category->delete();

        return View('categories.index');
    }
}
