<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;


    protected $fillable = [
        'event_name',
        'event_type',
        'event_gender_group',
        'event_age_group',
        'cancelled_at',
        'event_capacity',
        'event_description',
        'event_address',
        'creatorID',
        'latitude',
        'longitude',
        'event_status',
        'isApproved',
        'isCancelled',
        'event_picture',
        //... etc.
    ];


        // The creator of the event
    public function creator()
    {
        return $this->belongsTo(User::class, 'creatorID');
    }

    // Participants of the event
    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants', 'eventID', 'userID');
    }

    // Event dates
    public function eventDate()
    {
        return $this->hasOne(EventDate::class, 'eventID');
    }
}
