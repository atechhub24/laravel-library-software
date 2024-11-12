<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Upload Authors') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6">{{ session('status') }}</div>
            @endif

            <form action="{{ route('authors.upload.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Upload CSV File</label>
                    <input type="file" name="csv_file"
                        class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full">
                </div>

                <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded-lg">Upload Authors</button>
            </form>
        </div>
    </div>
</x-app-layout>
