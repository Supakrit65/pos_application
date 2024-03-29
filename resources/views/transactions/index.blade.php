@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                
                @if(session('success'))
                    <div class="alert-box mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert-box mb-4 text-sm font-medium text-red-600 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success') || session('error'))
                <script>
                    setTimeout(function() {
                        const alertBox = document.querySelector('.alert-box');
                        if (alertBox) {
                            alertBox.style.display = 'none';
                        }
                    }, 5000);
                </script>
                @endif
                
                <!-- Display current total price -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold">
                        @php
                            $total = $sale ? $sale->getTotal() : 0;
                            $discountRate = session('discount_applied') ? 0.1 : 0; // 10% discount
                            $discountAmount = $total * $discountRate;
                            $totalAfterDiscount = $total - $discountAmount;
                        @endphp
            
                        @if(session('member_info'))
                            <span class="text-base text-gray-700 dark:text-gray-300">Original Total: ฿{{ number_format($total, 2) }}</span> <br>
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Discounted Total: ฿{{ number_format($totalAfterDiscount, 2) }}</span>
                            <span class="text-sm text-gray-600 dark:text-gray-400">(10% member discount applied)</span>
                        @else 
                            <span class="text-lg font-semibold text-gray-800 dark:text-white">Total: ฿{{ number_format($total, 2) }}</span> 
                        @endif
                    </h3>
                </div>
                
                <!-- Member Discount Check Form -->
                <div class="mt-6 mb-4">
                    <h4 class="text-md font-semibold mb-2 dark:text-gray-300">Check Member Discount</h4>
                    <form action="{{ route('transactions.checkMember') }}" method="POST" class="flex items-center">
                        @csrf
                        <input type="hidden" name="sale_id" value="{{ $sale->id ?? '' }}">
                        <input type="text" name="phone" placeholder="Member Phone Number" required class="form-input mr-2 dark:bg-gray-900 dark:text-gray-300">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Check and Apply Discount
                        </button>
                    </form>
                </div>

                @if(session('member_info'))
                <div class="mb-4 flex justify-between">
                    <div>
                        <h4 class="text-md font-semibold dark:text-gray-200">Member Information:</h4>
                        <p class="text-gray-700 dark:text-gray-300">Name: {{ session('member_info')['name'] }}</p>
                        <p class="text-gray-700 dark:text-gray-300">Phone: {{ session('member_info')['phone'] }}</p>
                    </div>
            
                    <!-- Remove Member Button -->
                    <form action="{{ route('transactions.removeMember') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                            Remove Member
                        </button>
                    </form>
                </div>
                @endif
                <!-- Display line items -->
                @if($sale && $sale->lineItems->isNotEmpty())
                    <div class="mb-6">
                        @foreach($sale->lineItems as $lineItem)
                            <div class="flex justify-between items-center py-4 px-2 border rounded-lg mb-2 bg-gray-100 dark:bg-gray-600">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-white">{{ $lineItem->item->name ?? 'Item name not available' }}</p>
                                    <p class="text-gray-700 dark:text-gray-300">Quantity: {{ $lineItem->quantity }}</p>
                                    <p class="text-gray-700 dark:text-gray-300">Price: ฿{{ $lineItem->item->price ?? 'Price not set' }}</p>
                                    <p class="text-gray-700 dark:text-gray-300">Subtotal: ฿{{ $lineItem->quantity * ($lineItem->item->price ?? 0) }}</p>
                                </div>

                                <!-- Remove line item button -->
                                <form action="{{ route('sales.removeLineItem', $lineItem->id) }}" method="POST" class="ml-4">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Container for adding line items -->
                <div id="lineItemsContainer" class="mb-4">
                    <h4 class="text-md font-semibold mb-2 dark:text-gray-300">Add Line Item</h4>
                    <div class="line-item-form flex items-center mb-2">
                        <form action="{{ route('sales.addLineItem') }}" method="POST" class="w-full flex">
                            @csrf
                            <select name="item_id" required class="form-select flex-1 mr-2 dark:bg-gray-900 dark:text-gray-300">
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <input type="number" name="quantity" min="1" placeholder="Quantity" required class="form-input flex-1 mr-2 dark:bg-gray-900 dark:text-gray-300">
                            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex-none">
                                Add
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Process Payment Button -->
                @if($sale && $sale->lineItems->isNotEmpty())
                    <form action="{{ route('transactions.processPayment', ['sale' => $sale->id]) }}" method="POST" class="flex">
                        @csrf
                        <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Process Payment
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('addMoreLineItems').addEventListener('click', function() {
    const container = document.getElementById('lineItemsContainer');
    const formDiv = document.createElement('div');
    formDiv.classList.add('line-item-form', 'flex', 'items-center', 'mb-2');
    formDiv.innerHTML = `
        <form action="{{ route('sales.addLineItem') }}" method="POST" class="w-full flex">
            @csrf
            <select name="item_id" required class="form-select flex-1 mr-2">
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
            <input type="number" name="quantity" min="1" placeholder="Quantity" required class="form-input flex-1 mr-2">
            <input type="hidden" name="sale_id" value="{{ $sale->id }}">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex-none">
                Add
            </button>
        </form>
    `;
    container.appendChild(formDiv);
});
</script>
@endsection
