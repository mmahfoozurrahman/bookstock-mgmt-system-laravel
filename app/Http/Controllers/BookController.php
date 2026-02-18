<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return view('books.index', [
            //''=> Author::all(),
            //'books' => Book::all(),
            'title' => 'List of Books',
            'description' => 'List of Books'
        ]);
    }

    public function create()
    {
        return view('books.create', [
            'title' => 'Create Book',
            'description' => 'Create Book'
        ]);
    }
}
