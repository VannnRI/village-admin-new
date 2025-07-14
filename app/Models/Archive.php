<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'village_id',
        'title',
        'type', // general, population, letters
        'category', // peraturan, keuangan, laporan, surat, lainnya
        'description',
        'file',
        'size',
        'date',
        'uploaded_by'
    ];

    protected $casts = [
        'date' => 'date',
        'size' => 'integer',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
