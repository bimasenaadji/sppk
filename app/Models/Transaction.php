<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [''];
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
}
