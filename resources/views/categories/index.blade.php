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

            @if (auth()->user()->role->name !== 'student')
                <a href="{{ route('categories.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-6 inline-block">Add Category</a>
            @endif

            <!-- Search and Sort Form -->
            <form method="GET" action="{{ route('categories.index') }}" class="mb-4 flex">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..."
                    class="border border-gray-300 rounded-l-lg px-4 py-2">

                <select name="sort" class="border-t border-b border-gray-300 px-2 py-2">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="description" {{ request('sort') == 'description' ? 'selected' : '' }}>Description
                    </option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date
                    </option>
                    <option value="updated_at" {{ request('sort') == 'updated_at' ? 'selected' : '' }}>Updated Date
                    </option>
                </select>

                <select name="direction" class="border-t border-b border-r border-gray-300 px-2 py-2 rounded-r-lg">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg ml-2">Filter</button>
            </form>

            <!-- Categories Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border-b text-left">Name</th>
                            <th class="px-4 py-2 border-b text-left">Description</th>
                            <th class="px-4 py-2 border-b text-left">Created At</th>
                            <th class="px-4 py-2 border-b text-left">Updated At</th>
                            @if (auth()->user()->role->name !== 'student')
                                <th class="px-4 py-2 border-b text-left">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border-b">{{ $category->name }}</td>
                                <td class="px-4 py-2 border-b">{{ $category->description }}</td>
                                <td class="px-4 py-2 border-b">{{ $category->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 border-b">{{ $category->updated_at->format('Y-m-d') }}</td>
                                @if (auth()->user()->role->name !== 'student')
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="text-blue-600 hover:text-blue-800">Edit</a> |
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $categories->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
