<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'citizen_id',
        'letter_type_id',
        'request_number',
        'letter_name',
        'applicant_name',
        'applicant_nik',
        'applicant_kk',
        'purpose',
        'phone',
        'address',
        'status',
        'notes',
        'approved_by',
        'approved_at',
        'letter_file',
        'data',
        'nomor_urut',
    ];

    protected $casts = [
        'approved_at' => 'datetime'
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function citizen()
    {
        return $this->belongsTo(Citizen::class);
    }

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }
} 