<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['order_id', 'invoice_number', 'invoice_date', 'due_date', 'total_amount', 'status'];
    use HasFactory;
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
