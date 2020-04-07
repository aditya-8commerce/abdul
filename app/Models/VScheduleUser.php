<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VScheduleUser extends Model
{

    protected $table = 'v_schedule_user';
    protected $primaryKey = 'id';
    protected $fillable = array('id_customer','date_start',
        'date_finish','report_type','id_ozon','id_uv','id_emergency','id_log',
        'reminder_service','status','type','service_type','remarks','id_user','customer_code','customer_name' , 'user_name','indentity_number');
    public $timestamps = true; 
	 
}
