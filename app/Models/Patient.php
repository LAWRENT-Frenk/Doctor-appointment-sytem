<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'patients';

    protected $fillable = [
        'name', 'contact', 'email', 'address', 'contact_person', 'status', 'avatar', 'role', 'user_id'
    ];

    /**
     * Get the appointments for the patient.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the pharmacy involvements for the patient.
     */
    public function pharmacyInvolvements()
    {
        return $this->hasMany(Pharmacy::class);
    }

    /**
     * Get the count of appointments for the patient.
     */
    public function getAppointmentsCountAttribute()
    {
        return $this->appointments()->count();
    }

    /**
     * Get the count of pharmacy involvements for the patient.
     */
    public function getPharmacyInvolvementCountAttribute()
    {
        return $this->pharmacyInvolvements()->count();
    }

    /**
     * Get the pharmacies related to the patient.
     */
    public function pharmacies()
    {
        return $this->hasMany(Pharmacy::class);
    }

    /**
     * Calculate the total amount spent on pharmacies.
     */
    public function totalPharmacyAmount()
    {
        return $this->pharmacies()->sum('amount');
    }

    /**
     * Scope a query to include the total pharmacy amount.
     */
    public static function withTotalPharmacyAmount()
    {
        return self::select('*')
            ->selectSub(function ($query) {
                $query->from('pharmacies')
                    ->whereColumn('pharmacies.patient_id', 'patients.id')
                    ->selectRaw('SUM(amount)');
            }, 'total_pharmacy_amount');
    }

    /**
     * Get the user that owns the patient.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
