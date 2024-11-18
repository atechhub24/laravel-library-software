<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Books') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('books.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg">Add
                    Books</a>
                <a href="{{ route('books.upload') }}" class="bg-purple-500 text-white px-4 py-2 rounded-lg">Upload
                    Bookss</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex gap-4">
                    <!-- Filter and Search -->
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by title, author, or category..."
                        class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full sm:w-1/3">

                    <!-- Sorting -->
                    <select name="sort"
                        class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date
                        </option>
                    </select>

                    <select name="direction"
                        class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending
                        </option>
                    </select>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Filter</button>
                </form>

                <!-- Book Table -->
                <table class="min-w-full table-auto text-gray-800 dark:text-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Title</th>
                            <th class="px-6 py-3 text-left">Authors</th>
                            <th class="px-6 py-3 text-left">Categories</th>
                            <th class="px-6 py-3 text-left">Availability</th>
                            <th class="px-6 py-3 text-left">Created At</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr class="border-t border-gray-300 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $book->title }}</td>
                                <td class="px-6 py-4">{{ $book->authors->pluck('name')->join(', ') }}</td>
                                <td class="px-6 py-4">{{ $book->categories->pluck('name')->join(', ') }}</td>
                                <td class="px-6 py-4">
                                    @if ($book->isAvailable())
                                        <a href="{{ route('issues.create', ['book_id' => $book->id]) }}"
                                            class="text-green-500 hover:text-green-700">Issue Book</a>
                                    @else
                                        <span class="text-red-500 font-semibold">Issued</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $book->created_at->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('books.edit', $book) }}"
                                        class="text-blue-500 hover:text-blue-700">Edit</a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $books->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
