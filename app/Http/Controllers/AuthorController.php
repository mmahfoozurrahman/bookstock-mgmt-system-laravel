<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //
    public function index()
    {
        return view('authors.index', [
            //''=> Author::all(),
            //'books' => Book::all(),
            'title' => 'List of Authors',
            'description' => 'List of Authors'
        ]);
    }

    public function create()
    {
        return view('authors.create', [
            'title' => 'Create Author',
            'description' => 'Create Author'
        ]);
    }
}
