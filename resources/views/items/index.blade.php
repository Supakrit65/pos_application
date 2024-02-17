{{-- resources/views/items/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold my-4">Items</h1>
    <a href="{{ route('items.create') }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md mb-4">Add New Item</a>
    <div class="mt-3">
        <ul class="divide-y divide-gray-200">
            @foreach ($items as $item)
            <li class="py-4 flex flex-row justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">{{ $item->name }} - ฿{{ number_format($item->price, 2) }}</h3>
                    <p>Description: {{ $item->description ? $item->description : 'N/A' }}</p>
                    <p>Stock: {{ $item->stock }}</p>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('items.edit', $item->id) }}" class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-700 py-1 px-2 rounded-md mr-2">Edit</a>
                    <form action="{{ route('items.deleteItem', $item->id) }}" method="POST" class="inline">
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
