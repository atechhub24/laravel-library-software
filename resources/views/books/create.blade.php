<!-- resources/views/books/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <form method="POST" action="{{ route('books.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}"
                            class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                    </div>

                    <div class="mb-4">
                        <label for="authors" class="block text-gray-700 dark:text-gray-300">Authors</label>
                        <select name="authors[]" id="authors" multiple
                            class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="categories" class="block text-gray-700 dark:text-gray-300">Categories</label>
                        <select name="categories[]" id="categories" multiple
                            class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Book</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
