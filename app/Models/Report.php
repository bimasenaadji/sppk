<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_number',
        'incident_date',
        'incident_type',
        'incident_area', 
        'reporter_id',
        'victim',
        'status',
        'severity_level',
        'responsible_person',
        'corrective_action',
        'preventive_action',
        'documentation',
    ];



    // Pelapor sebagai relasi user
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // Gambar terkait laporan
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // Jika relasi 1 report memiliki 1 inspection
    public function inspection(): HasOne
    {
        return $this->hasOne(Inspection::class);
    }

    public function documentation()
{
    return $this->hasOne(Documentation::class);
}

public function preInspectionImages()
{
    return $this->hasMany(Image::class)->where('context', 'report');
}

public function postInspectionImages()
{
    return $this->hasMany(Image::class)->where('context', 'inspection');
}



    
}
