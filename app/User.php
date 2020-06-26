<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\UserDetail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_detail()
    {
        return $this->hasOne('App\UserDetail', 'user_id', 'id');
    }

    public function phone_number() 
    {
        $user_detail = UserDetail::where('user_id', $this->id)->first();
        $phone_number = $user_detail ? $user_detail->phone_number ? : "-" : "-";
        return $phone_number;
    }

    public function family_member()
    {
        return UserDetail::where('ref_user_id', $this->id)->get();

    }
}
