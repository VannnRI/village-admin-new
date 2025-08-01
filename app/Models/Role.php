<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'village_users')
                    ->withPivot('village_id', 'is_active')
                    ->withTimestamps();
    }
} 