<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterField extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'letter_type_id',
        'field_name',
        'field_label',
        'field_type',
        'field_options',
        'is_required',
        'order',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function letterType()
    {
        return $this->belongsTo(LetterType::class);
    }
} 