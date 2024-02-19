@extends('layouts.app')

@section('content')
<div class="py-12 dark:bg-gray-900"> <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-lg font-semibold mb-4 dark:text-white">Payments List</h2>
            <table class="min-w-full table-auto dark:text-gray-300"> 
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Payment ID</th>
                            <th class="px-4 py-2">Sale ID</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Member ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td class="border px-4 py-2">{{ $payment->id }}</td>
                                <td class="border px-4 py-2">{{ $payment->sale_id }}</td>
                                <td class="border px-4 py-2">฿{{ number_format($payment->amount, 2) }}</td>
                                <td class="border px-4 py-2">{{ $payment->member_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection