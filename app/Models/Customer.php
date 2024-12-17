<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $fillable = ['name', 'email', 'no_telp', 'alamat', 'tax_id'];
    use HasFactory;

    public function taxCategory()
    {
        return $this->belongsTo(TaxCategory::class, 'tax_id');
    }
}
