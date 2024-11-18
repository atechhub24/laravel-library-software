<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Issued Books') }}
            </h2>
            <a href="{{ route('issues.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg">Issue a
                Book</a>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Search and Sorting -->
                    <form method="GET" action="{{ route('issues.index') }}" class="mb-6 flex gap-4">
                        <!-- Search Bar -->
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by book title or user name..."
                            class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full sm:w-1/3">

                        <!-- Sort Column -->
                        <select name="sort"
                            class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                            <option value="issue_date" {{ request('sort') == 'issue_date' ? 'selected' : '' }}>Issue
                                Date</option>
                            <option value="due_date" {{ request('sort') == 'due_date' ? 'selected' : '' }}>Due Date
                            </option>
                            <option value="return_date" {{ request('sort') == 'return_date' ? 'selected' : '' }}>Return
                                Date</option>
                        </select>

                        <!-- Sort Direction -->
                        <select name="direction"
                            class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending
                            </option>
                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending
                            </option>
                        </select>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Filter</button>
                    </form>
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left text-gray-600 dark:text-gray-400">
                                <th class="px-4 py-2">Book Title</th>
                                <th class="px-4 py-2">Issued To</th>
                                <th class="px-4 py-2">Issue Date</th>
                                <th class="px-4 py-2">Due Date</th>
                                <th class="px-4 py-2">Return Date</th>
                                <th class="px-4 py-2">Fine Amount</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-300">
                            @foreach ($issues as $issue)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $issue->book->title }}</td>
                                    <td class="px-4 py-2">{{ $issue->user->name }}</td>
                                    <td class="px-4 py-2">{{ $issue->issue_date }}</td>
                                    <td class="px-4 py-2">{{ $issue->due_date }}</td>
                                    <td class="px-4 py-2">{{ $issue->return_date ?? 'Not Returned' }}</td>
                                    <td class="px-4 py-2">{{ $issue->fine_amount ?? 'No Fine' }}</td>
                                    <td class="px-4 py-2">
                                        @if (is_null($issue->return_date))
                                            <form action="{{ route('issues.return', $issue->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-red-600 hover:underline">Return</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">Returned</span>
                                        @endif
                                        <a href="{{ route('issues.show', $issue->id) }}"
                                            class="text-blue-600 hover:underline ml-2">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $issues->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
