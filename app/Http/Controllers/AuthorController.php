<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    // List authors with search and sort
    public function index(Request $request)
    {
        $query = Author::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('bio', 'like', '%' . $request->search . '%');
        }

        $sortColumn = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');

        $allowedSortColumns = ['name', 'created_at', 'updated_at'];
        if (!in_array($sortColumn, $allowedSortColumns)) {
            $sortColumn = 'name';
        }

        $query->orderBy($sortColumn, $sortDirection);
        $authors = $query->paginate(15);

        return view('authors.index', compact('authors', 'sortColumn', 'sortDirection'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:authors,name',
            'bio' => 'nullable|string',
        ]);

        Author::create($request->all());
        return redirect()->route('authors.index')->with('status', 'Author created successfully.');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|unique:authors,name,' . $author->id,
            'bio' => 'nullable|string',
        ]);

        $author->update($request->all());
        return redirect()->route('authors.index')->with('status', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('authors.index')->with('status', 'Author deleted successfully.');
    }
    public function showUploadForm()
    {
        return view('authors.upload');
    }

    public function upload(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt']);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        foreach ($data as $row) {
            Author::create(['name' => $row[0], 'bio' => $row[1]]);
        }

        return redirect()->route('authors.index')->with('status', 'Authors imported successfully.');
    }

}
