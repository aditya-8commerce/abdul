<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'indentity_number','paid_leave','name', 'email', 'password','id_division','id_position','phone','address','photo'
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
	
    public function divisi()
    {
        return $this->hasOne('App\Models\Divisi','id','id_division');
    }
	
    public function posisi()
    {
        return $this->hasOne('App\Models\Posisi','id','id_position');
    }
	
    public function absents()
    {
        return $this->hasMany('App\Models\TidakMasuk','id','id_user');
    }
	
    public function absent()
    {
        return $this->belongsTo('App\Models\TidakMasuk','id','id_user');
    }
	
    public function overtimes()
    {
        return $this->hasMany('App\Models\Lembur','id','id_user');
    }
	
    public function overtime()
    {
        return $this->belongsTo('App\Models\Lembur','id','id_user');
    }
	
    public function permintaanBarangs()
    {
        return $this->hasMany('App\Models\PermintaanBarang','id','id_user');
    }
	
    public function permintaanBarang()
    {
        return $this->belongsTo('App\Models\PermintaanBarang','id','id_user');
    }
	
    public function listDivisi()
    {
        return $this->belongsTo('App\Models\Divisi','id','id_division');
    }
    
    public function scheduleUser()
    {
        return $this->belongsTo('App\Models\ScheduleUser','id','id_user');
    }

    public function scheduleUV()
    {
        return $this->belongsTo('App\Models\ScheduleUV','id','id_user');
    }

    public function scheduleOzon()
    {
        return $this->belongsTo('App\Models\ScheduleOzon','id','id_user');
    }

    public function scheduleLog()
    {
        return $this->belongsTo('App\Models\ScheduleLog','id','id_user');
    }


    public function scheduleEmergency()
    {
        return $this->belongsTo('App\Models\ScheduleEmergency','id','id_user');
    }

}
