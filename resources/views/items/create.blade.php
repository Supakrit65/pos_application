{{-- resources/views/items/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto dark:bg-gray-900 dark:text-white"> 
    <h1 class="text-3xl font-bold my-4 dark:text-white">Add New Item</h1> 

    <form action="{{ route('items.createItem') }}" method="POST" class="max-w-md dark:text-gray-300"> 
        @csrf

        <div class="mb-4"> 
            <label for="name" class="block text-sm font-medium dark:text-gray-300">Name</label> 
            <input type="text" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 
                         dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" 
                   id="name" name="name" required>
        </div>

        <div class="mb-4"> 
            <label for="description" class="block text-sm font-medium dark:text-gray-300">Description</label> 
            <textarea 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 
                      dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" 
                id="description" name="description"></textarea>
        </div>

        <div class="mb-4"> 
            <label for="price" class="block text-sm font-medium dark:text-gray-300">Price</label>
            <input type="number" 
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 
                  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" 
            id="price" name="price" step="1" required min="0">
        </div>

        <div class="mb-4"> 
            <label for="stock" class="block text-sm font-medium dark:text-gray-300">Stock</label> 
            <input type="number" 
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 
                       dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500" 
                   id="stock" name="stock" step="1" required min="0">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white
                          bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                          dark:bg-blue-500 dark:hover:bg-blue-600"> 
                Submit
            </button>

            <a href="{{ route('items.index') }}" 
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium 
                      text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500
                      dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
