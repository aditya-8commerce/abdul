<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleUser extends Model
{
    protected $table = 'schedule_user';
    protected $primaryKey = 'id';
    protected $fillable = array('id_schedule','id_user');
    public $timestamps = true; 
	
	public function user()
    {
        return $this->hasOne('App\Models\User','id','id_user');
    }
    
	public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule','id_schedule','id');
    }
    
	public function vSchedule()
    {
        return $this->belongsTo('App\Models\VSchedule','id','id_schedule');
    }
}
