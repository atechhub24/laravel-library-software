<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Add New Author') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            <form action="{{ route('authors.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Name</label>
                    <input type="text" name="name"
                        class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-800 dark:text-gray-200 font-semibold mb-2">Bio</label>
                    <textarea name="bio"
                        class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 rounded-lg px-4 py-2 w-full"></textarea>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Author</button>
            </form>
        </div>
    </div>
</x-app-layout>
