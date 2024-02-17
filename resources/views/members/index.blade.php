{{-- resources/views/members/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold my-4">Members</h1>
    <a href="{{ route('members.create') }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md mb-4">Add New Member</a>
    <div class="mt-3">
        <ul class="divide-y divide-gray-200">
            @foreach ($members as $member)
            <li class="py-4 flex flex-row justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">{{ $member->name }}</h3>
                    <p class="text-gray-500">Tel: {{ $member->phone }}</p>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('members.edit', $member->id) }}" class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-700 py-1 px-2 rounded-md mr-2">Edit</a>
                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block bg-red-500 hover:bg-red-600 text-white py-1 px-2 rounded-md">Delete</button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
