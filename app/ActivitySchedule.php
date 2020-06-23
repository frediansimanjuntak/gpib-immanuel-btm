<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivitySchedule extends Model
{
    protected $fillable = [
        'name', 'description', 'confirmed', 'start_time', 'end_time', 'activity_id'
    ];

    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }
}
