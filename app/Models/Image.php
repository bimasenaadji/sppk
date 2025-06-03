<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

      protected $fillable = [
        'report_id',
        'uploaded_by',
        'context',
        'image_path',
        'only_for_print',
    ];

      public function report()
        {
            return $this->belongsTo(Report::class);
        }

    public function uploader()
        {
            return $this->belongsTo(User::class, 'uploaded_by');
        }
}
