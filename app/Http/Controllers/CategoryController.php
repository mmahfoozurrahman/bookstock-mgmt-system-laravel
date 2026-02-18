<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', [
            // 'categories'=> Category::all(),
            'title' => 'Categories',
            'description' => 'List of all categories'
        ]);
    }

    public function create()
    {
        return view('categories.create', [
            'title' => 'Create Category',
            'description' => 'Create Category'
        ]);
    }
}
