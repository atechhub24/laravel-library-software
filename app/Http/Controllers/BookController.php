<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $sortColumn = $request->input('sort', 'title');
        $sortDirection = $request->input('direction', 'asc');

        $books = $query->orderBy($sortColumn, $sortDirection)->paginate(15);

        return view('books.index', compact('books', 'sortColumn', 'sortDirection'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'published_date' => 'date']);

        $book = Book::create($request->all());
        $book->authors()->attach($request->authors);
        $book->categories()->attach($request->categories);

        return redirect()->route('books.index')->with('status', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate(['title' => 'required', 'published_date' => 'date']);

        $book->update($request->all());
        $book->authors()->sync($request->authors);
        $book->categories()->sync($request->categories);

        return redirect()->route('books.index')->with('status', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('status', 'Book deleted successfully.');
    }

    public function showUploadForm()
    {
        return view('books.upload');
    }

    public function upload(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt']);
        
        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        foreach ($data as $row) {
            $book = Book::create(['title' => $row[0], 'description' => $row[1], 'published_date' => $row[2]]);
            $book->authors()->attach(explode('|', $row[3])); // Assume author IDs are separated by '|'
            $book->categories()->attach(explode('|', $row[4])); // Assume category IDs are separated by '|'
        }

        return redirect()->route('books.index')->with('status', 'Books imported successfully.');
    }
}
