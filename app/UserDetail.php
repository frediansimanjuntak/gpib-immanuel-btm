<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'full_address', 'phone_number', 'birth_date', 'birth_place', 'family_status', 'confirmed', 'ref_user_id', 'identity_type', 'identity_number', 'family_card_number', 'gender', 'user_type_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ref_user()
    {
        return $this->belongsTo('App\User');
    }

    public function user_type()
    {
        return $this->belongsTo('App\UserType');
    }
}
