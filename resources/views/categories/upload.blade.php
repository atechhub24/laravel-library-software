<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Categories CSV') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                <form action="{{ route('categories.uploadCsv') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-400">Select CSV File</label>
                        <input type="file" name="csv_file" required
                            class="border border-gray-300 rounded-lg px-4 py-2">
                        @error('csv_file')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Upload</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
