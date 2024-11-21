<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Doctor extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name', 'contact', 'email', 'address', 
        'specialty', 'qualification', 'status', 'avatar'
    ];


    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
