<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    // INDEX
    public function index()
    {
        $authors = DB::table('authors')
            ->leftJoin('books', 'authors.id', '=', 'books.author_id')
            ->select(
                'authors.*',
                DB::raw('COUNT(books.id) as books_count')
            )
            ->groupBy('authors.id')
            ->orderBy('authors.id', 'desc')
            ->paginate(10);

        return view('authors.index', [
            'authors' => $authors,
            'title' => 'Authors',
            'description' => 'List of authors',
        ]);
    }

    // CREATE
    public function create()
    {
        return view('authors.create', [
            'title' => 'Create Author',
            'description' => 'Add new Author',
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors,email',
            'bio' => 'nullable',
            'status' => 'required'
        ]);

        DB::table('authors')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'bio' => $request->bio,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully.');
    }

    // EDIT
    public function edit($id)
    {
        $author = DB::table('authors')->where('id', $id)->first();

        return view('authors.edit', [
            'author' => $author,
            'title' => 'Edit Author',
            'description' => 'Edit the Author',
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:authors,email,' . $id,
            'bio' => 'nullable',
            'status' => 'required'
        ]);

        DB::table('authors')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
                'bio' => $request->bio,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully.');
    }

    // DELETE
    public function destroy($id)
    {
        DB::table('authors')->where('id', $id)->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author deleted successfully.');
    }
}
