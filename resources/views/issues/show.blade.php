<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Issue Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Book:') }} {{ $issue->book->title }}</h3>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Issued To:') }} {{ $issue->user->name }}</h3>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Issue Date:') }} {{ $issue->issue_date }}</h3>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">{{ __('Due Date:') }} {{ $issue->due_date }}</h3>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">
                            {{ __('Return Date:') }}
                            {{ $issue->return_date ?? 'Not Returned' }}
                        </h3>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold">
                            {{ __('Fine Amount:') }}
                            {{ $issue->fine_amount ?? 'No Fine' }}
                        </h3>
                    </div>
                    <a href="{{ route('issues.index') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        {{ __('Back to List') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
