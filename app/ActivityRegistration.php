<?php

namespace App;

use App\TicketRegistration;
use App\ActivityRegistration;
use Illuminate\Database\Eloquent\Model;

class ActivityRegistration extends Model
{
    protected $fillable = [
        'date', 'present', 'registration_number', 'user_id', 'activity_schedule_id', 'activity_id', 'ticket_registration_id', 'cancelled'
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

    public function ticket_registration()
    {
        return $this->belongsTo('App\TicketRegistration');
    }

    public function available_registration()
    {
        $ticket_registrations = ActivityRegistration::where('id', $this->id)
                                ->whereHas('ticket_registration', function ($query) {
                                    $current_date = \Carbon\Carbon::now();
                                    return $query->whereRaw('"'.$current_date.'" between registration_start_date and registration_end_date');
                                })
                                ->where('cancelled', false)
                                ->first();

        return $ticket_registrations ? true : false;
        
    }
}
