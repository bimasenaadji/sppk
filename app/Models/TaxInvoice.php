<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxInvoice extends Model
{
    protected $fillable = ['tax_invoice_number', 'ppn_amount', 'pph_amount'];
    use HasFactory;
}
