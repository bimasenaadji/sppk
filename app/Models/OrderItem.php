<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'service_id', 'qty', 'amount', 'total_amount'];
    use HasFactory;

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
