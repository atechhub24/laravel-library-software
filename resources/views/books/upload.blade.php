<!-- resources/views/books/upload.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Books CSV') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <form method="POST" action="{{ route('books.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="csv_file" class="block text-gray-700 dark:text-gray-300">CSV File</label>
                        <input type="file" name="csv_file" id="csv_file" required
                            class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2">
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Upload</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
