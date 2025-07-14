<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageOfficial extends Model
{
    protected $fillable = [
        'village_id',
        'position',
        'name',
        'nip',
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
