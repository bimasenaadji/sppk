<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'transaction_id',
        'customer_id',
        'tax_categories_id',
        'total_amount',
        'ppn_amount',
        'pph_amount',
        'net_amount',
    ];
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function taxCategory()
    {
        return $this->belongsTo(TaxCategory::class, 'tax_categories_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class, 'id', 'order_id', 'order_id', 'id');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
