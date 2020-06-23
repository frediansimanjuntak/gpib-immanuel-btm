<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityRegistration extends Model
{
    protected $fillable = [
        'date', 'present', 'registration_number', 'user_id', 'activity_schedule_id', 'activity_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    public function activity_schedule()
    {
        return $this->belongsTo('App\ActivitySchedule');
    }
}
