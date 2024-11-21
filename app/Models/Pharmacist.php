<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacist extends Authenticatable
{
    use HasFactory, HasRoles;

    // Define the table name if necessary
    protected $table = 'pharmacists';

    // Fillable fields
    protected $fillable = [
        'name',
        'contact',
        'email',
        'address',
        'specialty',
        'qualification',
        'status',
        'avatar',
        'password', // Added password for authentication
        'user_id',
        'role'

    ];

    // Relationships
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Custom role checking
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
