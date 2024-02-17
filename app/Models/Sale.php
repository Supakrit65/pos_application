<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['sale_status'];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function lineItems()
    {
        return $this->hasMany(LineItem::class);
    }

    public function addLineItem(array $lineItemData)
    {
        return $this->lineItems()->create($lineItemData);
    }

    public function removeLineItem($lineItemId)
    {
        return $this->lineItems()->where('id', $lineItemId)->delete();
    }

    public function createPayment($amount, $memberId = null)
    {
        $payment = new Payment([
            'sale_id' => $this->id,
            'amount' => $amount,
            'member_id' => $memberId, 
        ]);

        // Save the payment record
        $this->payment()->save($payment);

        $this->update(['sale_status' => 'closed']);

        return $payment;
    }

    public function getTotal()
    {
        return $this->lineItems->sum(function ($lineItem) {
            return $lineItem->getSubTotal();
        });
    }
}
