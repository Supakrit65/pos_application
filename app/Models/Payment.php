<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'amount', 'member_id'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class)->withDefault();
    }
}
