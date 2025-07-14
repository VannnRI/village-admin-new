<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'name',
        'processing_days',
        'template_html',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function letterRequests()
    {
        return $this->hasMany(LetterRequest::class);
    }

    public function fields()
    {
        return $this->hasMany(LetterField::class);
    }
} 