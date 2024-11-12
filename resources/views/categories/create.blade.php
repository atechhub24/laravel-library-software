<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Category Name:</label>
                    <input type="text" id="name" name="name" class="w-full border-gray-300 rounded-lg"
                        required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700">Description:</label>
                    <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Create Category</button>
            </form>
        </div>
    </div>
</x-app-layout>
