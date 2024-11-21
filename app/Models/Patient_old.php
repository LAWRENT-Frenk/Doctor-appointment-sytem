<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Patient extends Model
{
    use HasFactory, HasRoles;

    // Define the table if necessary
    protected $table = 'patients';

    protected $fillable = [
        'name', 'contact', 'email', 'address', 'contact_person', 'status', 'avatar','role','user_id'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function pharmacyInvolvements()
    {
        return $this->hasMany(Pharmacy::class);
    }

    public function getAppointmentsCountAttribute()
    {
        return $this->appointments()->count();
    }

    public function getPharmacyInvolvementCountAttribute()
    {
        return $this->pharmacyInvolvements()->count();
    }

    public function pharmacies()
{
    return $this->hasMany(Pharmacy::class);
}

public function totalPharmacyAmount()
{
    return $this->pharmacies()->sum('amount');
}

public static function withTotalPharmacyAmount()
    {
        return self::select('*')
            ->selectSub(function ($query) {
                $query->from('pharmacies')
                    ->whereColumn('pharmacies.patient_id', 'patients.id')
                    ->selectRaw('SUM(amount)');
            }, 'total_pharmacy_amount');
    }

 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    
}
