<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleUV extends Model
{

    protected $table = 'schedule_uv';
    protected $primaryKey = 'id';
    protected $fillable = array('id_user','subject','customer_by','id_product','serial_number',
    'running_hours','date','mfg','voltage_input','output_ballast_1','output_ballast_2','output_ballast_3',
    'output_ballast_4','frequency','monitoring_station','tempreature','cable_sensor','sensor_uv','socket_lamp_uv',
    'lamp_uv','indicator_lamp','noise_filter','compression_nut','o_ring','supply_voltage_to_detector',
    'voltage_uv_output','voltage_temperature','main_switch','fan_uv','line',
    'reccomendation','remarks','file'   
    );
    public $timestamps = true; 


	public function user()
    {
        return $this->hasOne('App\Models\User','id','id_user');
    }

    public function produk()
    {
        return $this->hasOne('App\Models\Produk','id','id_product');
    }

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule','id','id_uv');
    }

    public function vSchedule()
    {
        return $this->belongsTo('App\Models\VSchedule','id','id_uv');
    }
}