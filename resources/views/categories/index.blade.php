<div>
    <!-- Happiness is not something readymade. It comes from your own actions. - Dalai Lama -->
</div>
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

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            @if (auth()->user()->role->name !== 'student')
                                <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                @if (auth()->user()->role->name !== 'student')
                                    <td>
                                        <a href="{{ route('categories.edit', $category) }}"
                                            class="text-blue-600">Edit</a> |
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
