<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        // Define the fillable properties based on your requirements
        'meeting_date',
        'meeting_time',
        'meeting_location',
        'notes',
        // Add other relevant fields as necessary
    ];

    // Define any relationships, methods, or additional logic as needed
}
