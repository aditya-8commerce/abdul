<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VScheduleCustomer extends Model
{

    protected $table = 'vw_schedule_customer';
    protected $primaryKey = 'id';
    protected $fillable = array('status','type','date_start','date_finish',
        'service_type','reminder_service','remarks','code','name','address','color');
    public $timestamps = false; 
	
    
    
	public function users()
    {
        return $this->hasMany('App\Models\VScheduleuserUser','id_schedule','id');
    }
}
