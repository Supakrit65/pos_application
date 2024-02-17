{{-- resources/views/members/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold my-4">Create Member</h1>
    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <div class="mb-4 w-[40%]">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="name" name="name" required>
        </div>
        <div class="mb-4 w-[40%]">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="tel" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" id="phone" name="phone" required>
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Create Member</button>
    </form>
</div>
@endsection
