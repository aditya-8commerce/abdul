<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleLog extends Model
{

    protected $table = 'schedule_log';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'id_user','id_product','subject','customer_by','running_hours','serial_number','date','file','year',
        'dryer_1_heating_up','dryer_1_heating','dryer_1_heating_16s3','dryer_1_regeneration_time',
        'dryer_1_heater_current_1','dryer_1_heater_current_2','dryer_1_heater_current_3',
        'dryer_1_fan_blower_1','dryer_1_fan_blower_2','dryer_1_fan_blower_3',
        'dryer_2_heating_up','dryer_2_heating','dryer_2_heating_16s3','dryer_2_regeneration_time',
        'dryer_2_heater_current_1','dryer_2_heater_current_2','dryer_2_heater_current_3',
        'maximum_absolut_humidity_2','air_flow_3',
        'regeneration_blower_4','dryer_1_heating_time_4','dryer_2_heating_time_4', 	
        'air_too_hot_4','mixing_4','water_inrush_4','ozone_generation_cooling_water_4',

        'dew_point_between_adsorber_and_generators_5','dew_point_at_unit_output_5','ozone_level_5',

        'check_supply_main_6','check_operating_6','check_the_function_6','dryer_1_input_6','dryer_1_output_6',
        'dryer_2_input_6','dryer_2_output_6','gas_temperatur_monitoring_input_6','gas_temperatur_monitoring_output_6',
        'cooling_water_monitoring_input_6','cooling_water_monitoring_output_6',
        
        'voltage_1_7','voltage_2_7','voltage_3_7','voltage_4_7','current_consumption_1_7','current_consumption_2_7',
        'current_consumption_3_7','current_consumption_4_7','gas_flow_1_7','gas_flow_2_7','gas_flow_3_7','gas_flow_4_7',
        'ozone_level_1_7','ozone_level_2_7','ozone_level_3_7','ozone_level_4_7',
        'injection_pressure_in_1_7','injection_pressure_in_2_7','injection_pressure_in_3_7','injection_pressure_in_4_7',
        'injection_pressure_out_1_7','injection_pressure_out_2_7','injection_pressure_out_3_7','injection_pressure_out_4_7',
        'cooling_water_flow_1_7','cooling_water_flow_2_7','cooling_water_flow_3_7','cooling_water_flow_4_7',
        'water_flow_rate_1_7','water_flow_rate_2_7','water_flow_rate_3_7','water_flow_rate_4_7',
        'excess_ozone_in_water_1_7','excess_ozone_in_water_2_7','excess_ozone_in_water_3_7','excess_ozone_in_water_4_7',
        'running_time_1_7','running_time_2_7','running_time_3_7','running_time_4_7',
        'noted'
    );
    public $timestamps = true; 
	
	public function user()
    {
        return $this->hasOne('App\Models\User','id','id_user');
    }

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule','id','id_log');
    }
    public function produk()
    {
        return $this->hasOne('App\Models\Produk','id','id_product');
    }

    public function vSchedule()
    {
        return $this->belongsTo('App\Models\VSchedule','id','id_log');
    }
    
}
