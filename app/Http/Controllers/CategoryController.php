<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', ['categories' => $categories]);
    }

    public function form()
    {
        $request = request();

        $data = [];

        if ($request->method() == 'POST') {

            Category::updateOrCreate(
                ['id' => $request->get('id')],
                [
                    'title' => $request->get('title'),
                    'slug' => $request->get('slug'),
                ]
            );

            return redirect('/categories');
        }

        if (!empty($id = $request->route()->parameter('id'))) {
            $data['category'] = Category::find($id);
        }

        return view('categories.form', $data);
    }

    public function delete()
    {
        $category = Category::find(request()->route()->parameter('id'));
        $category->post()->update(['category_id' => null]);
        $category->delete();

        return redirect('/categories');
    }
}
