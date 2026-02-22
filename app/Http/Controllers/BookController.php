<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index()
    {
        $books = DB::table('books')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->select(
                'books.*',
                'authors.name as author_name',
                'categories.name as category_name'
            )
            ->orderBy('books.id', 'desc')
            ->paginate(10);

        return view('books.index', [
            'books' => $books,
            'title' => 'List of Books',
            'description' => 'Manage your book collection'
        ]);

    }

    public function create()
    {
        $categories = DB::table('categories')->orderBy('name')->get();
        $authors = DB::table('authors')->orderBy('name')->get();

        return view('books.create', [
            'title' => 'Create Book',
            'description' => 'Add a new book to the collection',
            'categories' => $categories,
            'authors' => $authors
        ]);
    }

    public function store(Request $request)
    {
        // --- Validation ---
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'status' => 'required|in:available,borrowed,reserved',
            // image must be jpeg/png/jpg and under 2MB (2048 KB)
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // --- Handle file upload ---
        // If the user uploaded a cover image, store it in storage/app/public/covers
        // The path returned (e.g. "covers/abc123.jpg") is what we save in DB
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        // --- Insert into DB using Query Builder ---
        DB::table('books')->insert([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'published_at' => $request->published_at ? Carbon::parse($request->published_at)->format('Y-m-d') : null,
            'status' => $request->status,
            'cover_image' => $coverPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    public function edit(string $id)
    {
        // Fetch the book we want to edit
        $book = DB::table('books')->where('id', $id)->first();

        abort_if(!$book, 404);

        // Also fetch all categories and authors for the dropdowns
        $categories = DB::table('categories')->orderBy('name')->get();
        $authors = DB::table('authors')->orderBy('name')->get();

        return view('books.edit', [
            'book' => $book,
            'categories' => $categories,
            'authors' => $authors,
            'title' => 'Edit Book',
            'description' => 'Edit the Book'
        ]);
    }

    public function update(Request $request, string $id)
    {
        // Fetch existing book first (to handle old image)
        $book = DB::table('books')->where('id', $id)->first();
        abort_if(!$book, 404);

        // --- Validation ---
        // Note: isbn unique rule IGNORES the current book's own row
        // "unique:books,isbn,{$id}" means "isbn must be unique in books table,
        //  column isbn, BUT ignore the row with id = $id"
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => "required|string|unique:books,isbn,{$id}",
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // --- Handle file upload ---
        // Start with the old image path (don't delete it yet)
        $coverPath = $book->cover_image;

        if ($request->hasFile('cover_image')) {
            // Delete the OLD image from storage if it exists
            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }
            // Store the new image
            $coverPath = $request->file('cover_image')->store('covers', 'public');
        }

        // --- Update the record ---
        DB::table('books')->where('id', $id)->update([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'author_id' => $request->author_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'status' => $request->status,
            'published_at' => $request->published_at,
            'cover_image' => $coverPath,
            'updated_at' => now(),
        ]);

        return redirect()->route('books.edit', $id)
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(string $id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        abort_if(!$book, 404);

        // Delete the cover image file from storage first
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        // Now delete the database record
        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully!');
    }
}
