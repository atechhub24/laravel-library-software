<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Display all categories for all users
    public function index(Request $request)
    {
        $query = Category::query();

        // Apply search filter if present
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Apply sorting by column and direction if present
        $sortColumn = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        
        // Whitelist allowed sorting columns
        $allowedSortColumns = ['name', 'description', 'created_at', 'updated_at'];
        if (!in_array($sortColumn, $allowedSortColumns)) {
            $sortColumn = 'name';
        }

        $query->orderBy($sortColumn, $sortDirection);

        // Paginate the results
        $categories = $query->paginate(15);

        return view('categories.index', compact('categories', 'sortColumn', 'sortDirection'));
    }

    // Show the form for creating a new category (only for admin and librarian)
    public function create()
    {
        $this->authorizeAdminOrLibrarian();
        return view('categories.create');
    }

    // Store a new category in the database
    public function store(Request $request)
    {
        $this->authorizeAdminOrLibrarian();
        $request->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());
        return redirect()->route('categories.index')->with('status', 'Category created successfully.');
    }

    // Show the form for editing an existing category (only for admin and librarian)
    public function edit(Category $category)
    {
        $this->authorizeAdminOrLibrarian();
        return view('categories.edit', compact('category'));
    }

    // Update the specified category in the database
    public function update(Request $request, Category $category)
    {
        $this->authorizeAdminOrLibrarian();
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('status', 'Category updated successfully.');
    }

    // Delete the specified category from the database
    public function destroy(Category $category)
    {
        $this->authorizeAdminOrLibrarian();
        $category->delete();
        return redirect()->route('categories.index')->with('status', 'Category deleted successfully.');
    }

    // Helper function to authorize admin and librarian users
    protected function authorizeAdminOrLibrarian()
    {
        if (!in_array(Auth::user()->role->name, ['admin', 'librarian'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
