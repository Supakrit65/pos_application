{{-- resources/views/members/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white my-4">Members</h1>
    <a href="{{ route('members.create') }}" class="inline-block bg-blue-600 text-white py-2 px-4 rounded-md mb-4">Add New Member</a>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($members as $member)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $member->name }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">ID: {{ $member->id }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Tel: {{ $member->phone }}</p>
            <div class="flex justify-end">
                <a href="{{ route('members.edit', $member->id) }}" class="bg-gray-200 text-gray-700 py-1 px-3 rounded-md mr-2 hover:bg-gray-300 hover:text-gray-800">Edit</a>
                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700 hover:text-red-100">Delete</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
