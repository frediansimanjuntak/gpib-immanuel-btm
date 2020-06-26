<?php

namespace App;

use App\ActivityRegistration;
use Illuminate\Database\Eloquent\Model;

class TicketRegistration extends Model
{
    protected $fillable = [
        'status', 'date', 'max_participants', 'registration_start_date', 'registration_end_date', 'created_by', 'activity_id', 'activity_schedule_id', 
    ];

    public function activity()
    {
        return $this->belongsTo('App\Activity');
    }

    public function activity_schedule()
    {
        return $this->belongsTo('App\ActivitySchedule');
    }

    public function activity_registrations()
    {
        return $this->hasMany('App\ActivityRegistration');
    }

    public function count_registered()
    {
        $users_registered = ActivityRegistration::where('ticket_registration_id', $this->id)->where('cancelled', false)->get();
        return count($users_registered);
    }

    public function remaining_slot()
    {
        $remain = $this->max_participants - $this->count_registered();
        return $remain;
    }

    public function active_activity_registration()
    {
        $ticket_registrations = ActivityRegistration::where('ticket_registration_id', $this->id)->where('cancelled', false)->get();
        return $ticket_registrations;
    }
}
