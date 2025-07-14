<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'nik',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function villages()
    {
        return $this->belongsToMany(Village::class, 'village_users')
                    ->withPivot('role_id', 'is_active')
                    ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'village_users')
                    ->withPivot('village_id', 'is_active')
                    ->withTimestamps();
    }

    public function citizen()
    {
        return $this->hasOne(Citizen::class);
    }

    public function letterRequests()
    {
        return $this->hasMany(LetterRequest::class, 'approved_by');
    }

    public function hasRole($roleName, $villageId = null)
    {
        $query = $this->roles()->where('name', $roleName);
        
        if ($villageId) {
            $query->wherePivot('village_id', $villageId);
        }
        
        return $query->exists();
    }

    public function getVillageRole($villageId)
    {
        return $this->roles()
                    ->wherePivot('village_id', $villageId)
                    ->wherePivot('is_active', true)
                    ->first();
    }

    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    public function isAdminDesa($villageId = null)
    {
        return $this->hasRole('admin_desa', $villageId);
    }

    public function isPerangkatDesa($villageId = null)
    {
        return $this->hasRole('perangkat_desa', $villageId);
    }

    public function isMasyarakat($villageId = null)
    {
        return $this->hasRole('masyarakat', $villageId);
    }
}
