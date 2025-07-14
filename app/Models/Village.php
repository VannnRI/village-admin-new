<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'head_name',
        'district',
        'regency',
        'code',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'vision',
        'mission',
        'logo',
        'is_active',
        'postal_code',
        'village_code',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'village_users')
                    ->withPivot('role_id', 'is_active')
                    ->withTimestamps();
    }

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }

    public function letterRequests()
    {
        return $this->hasMany(LetterRequest::class);
    }

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function officials()
    {
        return $this->hasMany(VillageOfficial::class);
    }
} 