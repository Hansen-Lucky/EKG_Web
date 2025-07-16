<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkgResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'result_file_path',
        'examination_date'
    ];

    protected $casts = [
        'examination_date' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}