<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IssueController extends Controller
{
    // Display a list of all issued books
    public function index(Request $request)
    {
        $query = Issue::with('user', 'book');
    
        // Search by book title or user name
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }
    
        // Sorting
        $sortColumn = $request->input('sort', 'issue_date');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortColumn, $sortDirection);
    
        // Pagination
        $issues = $query->paginate(10)->appends($request->all());
    
        return view('issues.index', compact('issues', 'sortColumn', 'sortDirection'));
    }

    // Show the form for issuing a new book
    public function create()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'student');
        })->get();
        $books = Book::where('status', 'available')->get();
        return view('issues.create', compact('users', 'books'));
    }

    // Store the newly issued book record in the database
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->isIssued()) {
            return redirect()->back()->withErrors(['book_id' => 'This book is already issued.']);
        }

        $book->update(['status' => 'issued']);

        Issue::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('issues.index')->with('success', 'Book issued successfully.');
    }


    // Display details of a specific issue
    public function show($id)
    {
        $issue = Issue::with('user', 'book')->findOrFail($id);
        return view('issues.show', compact('issue'));
    }

    // Return a book and calculate any applicable fine
    public function returnBook(Request $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $returnDate = Carbon::now();
        $issue->return_date = $returnDate;

        // Calculate fine if the book is returned late
        if ($returnDate->greaterThan(Carbon::parse($issue->due_date))) {
            $daysLate = $returnDate->diffInDays(Carbon::parse($issue->due_date));
            $fineAmount = $daysLate * 5;  // Example: 5 currency units per day
            $issue->fine_amount = $fineAmount;
        }

        $issue->save();

        $issue->book->update(['status' => 'available']);

        return redirect()->route('issues.index')->with('success', 'Book returned successfully with a fine of ' . $issue->fine_amount . ' currency units.');
    }
}
