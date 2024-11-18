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
    public function index()
    {
        $issues = Issue::with('user', 'book')->get();
        return view('issues.index', compact('issues'));
    }

    // Show the form for issuing a new book
    public function create()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'student');
        })->get();
        $books = Book::all();
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

        return redirect()->route('issues.index')->with('success', 'Book returned successfully with a fine of ' . $issue->fine_amount . ' currency units.');
    }
}
