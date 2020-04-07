<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $table = 'schedule';
    protected $primaryKey = 'id';
    protected $fillable = array('id_customer','date_start',
        'date_finish','report_type','id_ozon','id_uv','id_emergency','id_log',
        'reminder_service','status','type','service_type','remarks');
    public $timestamps = true; 
	
    
	public function customer()
    {
        return $this->hasOne('App\Models\Customer','id','id_customer');
    }

	public function log()
    {
        return $this->hasOne('App\Models\ScheduleLog','id','id_log');
    }
    
	public function emergency()
    {
        return $this->hasOne('App\Models\ScheduleEmergency','id','id_emergency');
    }
    
	public function ozon()
    {
        return $this->hasOne('App\Models\ScheduleOzon','id','id_ozon');
    }
    
	public function uv()
    {
        return $this->hasOne('App\Models\ScheduleUV','id','id_uv');
    }
    
	public function users()
    {
        return $this->hasMany('App\Models\ScheduleUser','id_schedule','id');
    }
}
