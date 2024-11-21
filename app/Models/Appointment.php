<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['patient_id', 'doctor_id', 'date', 'time', 'reason', 'custom_id', 'status'];

    /**
     * Get the doctor associated with the appointment.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }



    /**
     * Get the patient associated with the appointment.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->custom_id)) {
                $model->custom_id = self::generateCustomId();
            }
        });
    }

    private static function generateCustomId()
    {
        $latest = self::latest()->first();
        $number = $latest ? intval(substr($latest->custom_id, 3)) + 1 : 1;
        return 'APP' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
