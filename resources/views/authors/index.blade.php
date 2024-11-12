<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Authors') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('authors.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg">Add
                    Author</a>
                <a href="{{ route('authors.upload') }}" class="bg-purple-500 text-white px-4 py-2 rounded-lg">Upload
                    Authors</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6">{{ session('status') }}</div>
            @endif

            <form method="GET" action="{{ route('authors.index') }}" class="mb-4 flex gap-4 items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search authors..."
                    class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full sm:w-auto">

                <select name="sort"
                    class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date
                    </option>
                    <option value="updated_at" {{ request('sort') == 'updated_at' ? 'selected' : '' }}>Updated Date
                    </option>
                </select>

                <select name="direction"
                    class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Filter</button>
            </form>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($authors as $author)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $author->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $author->bio ?? 'No bio available' }}</p>
                        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                            <div>Created: {{ $author->created_at->format('Y-m-d') }}</div>
                            <div>Updated: {{ $author->updated_at->format('Y-m-d') }}</div>
                        </div>

                        <div class="flex justify-end mt-4 space-x-2">
                            <a href="{{ route('authors.edit', $author) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form action="{{ route('authors.destroy', $author) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $authors->appends(request()->input())->links() }}</div>
        </div>
    </div>
</x-app-layout>
