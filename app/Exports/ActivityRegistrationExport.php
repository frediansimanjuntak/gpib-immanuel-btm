<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActivityRegistrationExport implements FromView
{
    private $data;

    public function __construct($activity_registrations)
    {
        $this->activity_registrations = $activity_registrations;
    }

    public function view(): View
    {
        return view('exports.registration-excel', [
            'activity_registrations' => $this->activity_registrations,
            'i' => 0
        ]);
    }
}
