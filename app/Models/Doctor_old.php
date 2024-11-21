<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Doctor_old extends Model
{
    use HasFactory, HasRoles;
     // Define the table if necessary
     protected $table = 'doctors';

    protected $fillable = [
        'name',
        'contact',
        'email',
        'address',
        'specialty',
        'qualification',
        'status',
        'avatar',
        'role',
        'user_id',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function roles_old()
    {
        return $this->belongsToMany(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles');
    }
}
