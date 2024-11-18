<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Issued Books') }}
            </h2>
            <a href="{{ route('issues.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg">Issue a
                Book</a>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="text-left text-gray-600 dark:text-gray-400">
                                <th class="px-4 py-2">Book Title</th>
                                <th class="px-4 py-2">Issued To</th>
                                <th class="px-4 py-2">Issue Date</th>
                                <th class="px-4 py-2">Due Date</th>
                                <th class="px-4 py-2">Return Date</th>
                                <th class="px-4 py-2">Fine Amount</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-300">
                            @foreach ($issues as $issue)
                                <tr class="border-t border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $issue->book->title }}</td>
                                    <td class="px-4 py-2">{{ $issue->user->name }}</td>
                                    <td class="px-4 py-2">{{ $issue->issue_date }}</td>
                                    <td class="px-4 py-2">{{ $issue->due_date }}</td>
                                    <td class="px-4 py-2">{{ $issue->return_date ?? 'Not Returned' }}</td>
                                    <td class="px-4 py-2">{{ $issue->fine_amount ?? 'No Fine' }}</td>
                                    <td class="px-4 py-2">
                                        @if (is_null($issue->return_date))
                                            <form action="{{ route('issues.return', $issue->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-red-600 hover:underline">Return</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">Returned</span>
                                        @endif
                                        <a href="{{ route('issues.show', $issue->id) }}"
                                            class="text-blue-600 hover:underline ml-2">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
