<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'activity_description',
        // Add other fillable attributes here as needed
    ];

    // Define any relationships here if needed
}
