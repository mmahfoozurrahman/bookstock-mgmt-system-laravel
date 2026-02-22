<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    // Display list
    public function index()
    {
        $categories = DB::table('categories')
            ->leftJoin('books', 'categories.id', '=', 'books.category_id')
            ->select(
                'categories.*',
                DB::raw('COUNT(books.id) as books_count')
            )
            ->groupBy('categories.id')
            ->orderBy('categories.id', 'desc')
            ->paginate(10);
        //dd($categories);

        return view('categories.index', [
            'categories' => $categories,
            'title' => 'Categories',
            'description' => 'List of all categories',
        ]);
    }

    // Show create form
    public function create()
    {
        return view('categories.create');
    }

    // Store category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        DB::table('categories')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        return view('categories.edit', compact('category'));
    }

    // Update category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        DB::table('categories')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'updated_at' => now(),
            ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // Delete category
    public function destroy($id)
    {
        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
