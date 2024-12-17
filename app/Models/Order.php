<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id', 'date', 'total', 'status'];
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
    public function taxCategory()
    {
        return $this->belongsTo(TaxCategory::class, 'tax_categories_id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
