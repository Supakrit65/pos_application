{{-- resources/views/items/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto dark:bg-gray-900 dark:text-white"> 
    <h1 class="text-3xl font-bold my-4 dark:text-white">Items</h1> 

    <a href="{{ route('items.create') }}" 
       class="inline-block bg-blue-500 text-white py-2 px-4 rounded-md mb-4 
              hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
        Add New Item
    </a> 

    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">  
      @foreach ($items as $item)
        <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gray-800 flex flex-col justify-between"> 
            <div> 
                <h3 class="text-lg font-bold dark:text-white">
                    {{ $item->name }} - ฿{{ number_format($item->price, 2) }}
                </h3>
                <p class="text-gray-600 dark:text-gray-300">
                    Description: {{ $item->description ? $item->description : 'N/A' }}
                </p>
                <p class="text-gray-600 dark:text-gray-300">Stock: {{ $item->stock }}</p>
            </div>

            <div class="flex items-center justify-end mt-4">  
                <a href="{{ route('items.edit', $item->id) }}" 
                   class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-700 
                         py-1 px-2 rounded-md mr-2 
                         dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                    Edit
                </a> 

                <form action="{{ route('items.deleteItem', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-block bg-red-500 hover:bg-red-600 text-white 
                                  py-1 px-2 rounded-md
                                  dark:bg-red-600 dark:hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>  
        </div> 
      @endforeach
    </div> 
</div> 
@endsection      
