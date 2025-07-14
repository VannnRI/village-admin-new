<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'nik',
        'kk_number',
        'name',
        'birth_date',
        'address',
        'phone',
        'email',
        'gender',
        'religion',
        'marital_status',
        'education',
        'job',
        'birth_place',
        'nationality',
        'is_active'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function letterRequests()
    {
        return $this->hasMany(LetterRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 