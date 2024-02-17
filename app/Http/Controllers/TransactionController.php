<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Item;
use App\Models\LineItem;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{

    public function openSale(Request $request)
    {
        $sale = null;
    
        // Check if there's an open sale in the session
        if ($request->session()->has('sale_id')) {
            $saleId = $request->session()->get('sale_id');
            $sale = Sale::find($saleId);
        }
    
        // If no sale in session, create a new sale
        if (!$sale) {
            $sale = new Sale();
            $sale->sale_status = 'open';
            $sale->save();
            // Store the new sale ID in the session
            $request->session()->put('sale_id', $sale->id);
        }
    
        $items = Item::all(); // Fetch all items from the database
    
        return view('transactions.index', compact('items', 'sale'));
    }

    public function removeMember(Request $request)
    {
        $request->session()->forget(['member_info', 'discount_applied']);
        return back()->with('success', 'Member removed successfully.');
    }

    public function addLineItemToSale(Request $request)
    {
        $validatedData = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'sale_id' => 'required|exists:sales,id',
        ]);
    
        $item = Item::findOrFail($validatedData['item_id']);
    
        if ($validatedData['quantity'] > $item->stock) {
            return back()->with('error', 'Cannot add more items than available in stock.');
        }
    
        // Check if the sale already has a line item for this item_id
        $existingLineItem = LineItem::where('sale_id', $validatedData['sale_id'])
                                    ->where('item_id', $validatedData['item_id'])
                                    ->first();
    
        if ($existingLineItem) {
            // If exists, update the quantity
            if ($existingLineItem->quantity + $validatedData['quantity'] > $item->stock) {
                return back()->with('error', 'Cannot add more items than available in stock.');
            }
            $existingLineItem->quantity += $validatedData['quantity'];
            $existingLineItem->save();
            $item->stock -= $validatedData['quantity'];
            $item->save();
            $message = 'Line item quantity updated successfully.';
        } else {
            // If not exists, create a new line item
            $item->stock -= $validatedData['quantity'];
            $item->save();
            $lineItem = new LineItem([
                'sale_id' => $validatedData['sale_id'],
                'item_id' => $validatedData['item_id'],
                'quantity' => $validatedData['quantity'],
            ]);
            $lineItem->save();
            $message = 'Line item added to sale.';
        }
    
        return back()->with('success', $message);
    }    
    
    public function removeLineItemFromSale($lineItemId)
    {
        $lineItem = LineItem::findOrFail($lineItemId);
        $item = Item::findOrFail($lineItem->item_id);

        // Restore item stock
        $item->stock += $lineItem->quantity;
        $item->save();

        // Remove line item
        $lineItem->delete();

        return back()->with('success', 'Line item successfully removed.');
    }

    public function processPayment(Request $request, Sale $sale)
    {
        DB::beginTransaction();

        try {
            $totalAmount = $sale->getTotal(); // Get the total sale amount
            $discountRate = session('member_info') ? 0.1 : 0; // Apply discount if member_info exists in session
            $discountAmount = $totalAmount * $discountRate;
            $finalAmount = $totalAmount - $discountAmount;

            // Determine member ID from session if available
            $memberId = session('member_info')['id'] ?? null;

            // Create payment through the Sale model
            $sale->createPayment($finalAmount, $memberId);
            // Update the sale status to indicate payment was processed
            $sale->update(['sale_status' => 'closed']);

            // Clear the transaction-related session data
            session()->forget(['sale_id', 'discount_applied', 'member_info']);

            DB::commit();
            return back()->with('success', 'Payment processed successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', "Error processing payment: " . $e->getMessage());
        }
    }

    public function checkMember(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'sale_id' => 'required|exists:sales,id',
        ]);
    
        $member = Member::where('phone', $request->phone)->first();
    
        if ($member) {
            // Set a session flag for discount and store member info
            session([
                'discount_applied' => true,
                'member_info' => $member->toArray(), // Store member info in session as an array
            ]);
    
            return back()->with('success', 'Member found. Discount will be applied.');
        }
    
        return back()->with('error', 'Member not found.');
    }

    public function viewPayments()
    {
        $payments = Payment::with(['sale', 'member'])->get(); // Eager load related sale and member

        return view('transactions.allpayment', compact('payments'));
    }
}
