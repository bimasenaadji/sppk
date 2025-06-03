<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'inspected_by',
        'severity_level',
        'responsible_person_id',
        'corrective_action',
        'preventive_action',
        'inspected_at',
    ];

    public function report()
{
    return $this->belongsTo(Report::class);
}

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspected_by');
    }

    public function responsiblePerson()
    {
        return $this->belongsTo(User::class, 'responsible_person_id');
    }

    public function documentation()
{
    return $this->report->documentation();
}

}
