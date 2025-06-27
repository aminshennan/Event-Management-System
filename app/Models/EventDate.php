<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'eventID',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];

    // The event associated with the event date
    public function event()
    {
        return $this->belongsTo(Event::class, 'eventID');
    }

}


