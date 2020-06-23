<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'name', 'description', 'confirmed'
    ];

    public function activity_schedules()
    {
        return $this->hasMany('App\ActivitySchedule');
    }

    public function activity_registrations()
    {
        return $this->hasMany('App\ActivityRegistration');
    }
}