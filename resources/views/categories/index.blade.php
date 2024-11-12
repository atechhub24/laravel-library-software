<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif



            <!-- Search and Sort Form -->
            <form method="GET" action="{{ route('categories.index') }}"
                class="mb-4 flex flex-col sm:flex-row items-center gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..."
                    class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full sm:w-auto">

                <select name="sort"
                    class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full sm:w-auto">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="description" {{ request('sort') == 'description' ? 'selected' : '' }}>Description
                    </option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date
                    </option>
                    <option value="updated_at" {{ request('sort') == 'updated_at' ? 'selected' : '' }}>Updated Date
                    </option>
                </select>

                <select name="direction"
                    class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full sm:w-auto">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>

                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full sm:w-auto">Filter</button>

                @if (auth()->user()->role->name !== 'student')
                    <a href="{{ route('categories.create') }}"
                        class="bg-green-500 text-white px-4 py-2 rounded-lg inline-block">Add New Category</a>
                @endif
            </form>

            <!-- Categories Card View -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($categories as $category)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 transition transform hover:scale-105">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $category->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">
                            {{ $category->description ?? 'No description available' }}</p>

                        <div class="flex justify-between items-center mt-4 text-sm text-gray-500 dark:text-gray-400">
                            <div>Created: {{ $category->created_at->format('Y-m-d') }}</div>
                            <div>Updated: {{ $category->updated_at->format('Y-m-d') }}</div>
                        </div>

                        @if (auth()->user()->role->name !== 'student')
                            <div class="flex justify-end mt-4 space-x-2">
                                <a href="{{ route('categories.edit', $category) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $categories->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
