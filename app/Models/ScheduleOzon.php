<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleOzon extends Model
{

    protected $table = 'schedule_ozon';
    protected $primaryKey = 'id';
    protected $fillable = array(
        'id_user','subject','customer_by','id_product','serial_number','running_hours','year','date',
        'lock','step_1_dryer_1_remaining_capacity_before','step_1_dryer_1_remaining_capacity_after','step_1_dryer_1_remaining_capacity_noted',
        'step_1_dryer_2_remaining_capacity_before','step_1_dryer_2_remaining_capacity_after','step_1_dryer_2_remaining_capacity_noted',
        'step_1_dryer_1_dew_point_before','step_1_dryer_1_dew_point_after','step_1_dryer_1_dew_point_noted',
        'step_1_dryer_2_dew_point_before','step_1_dryer_2_dew_point_after','step_1_dryer_2_dew_point_noted',
        'step_1_dryer_1_gas_temperature_before','step_1_dryer_1_gas_temperature_after','step_1_dryer_1_gas_temperature_noted',
        'step_1_dryer_2_gas_temperature_before','step_1_dryer_2_gas_temperature_after','step_1_dryer_2_gas_temperature_noted',
        'step_1_dryer_1_description','step_1_dryer_2_description',
		'step_2_dryer_1_remaining_capacity_before','step_2_dryer_1_remaining_capacity_after','step_2_dryer_1_remaining_capacity_noted',
        'step_2_dryer_2_remaining_capacity_before','step_2_dryer_2_remaining_capacity_after','step_2_dryer_2_remaining_capacity_noted',
        'step_2_dryer_1_dew_point_before','step_2_dryer_1_dew_point_after','step_2_dryer_1_dew_point_noted',
        'step_2_dryer_2_dew_point_before','step_2_dryer_2_dew_point_after','step_2_dryer_2_dew_point_noted',
        'step_2_dryer_1_gas_temperature_before','step_2_dryer_1_gas_temperature_after','step_2_dryer_1_gas_temperature_noted',
        'step_2_dryer_2_gas_temperature_before','step_2_dryer_2_gas_temperature_after','step_2_dryer_2_gas_temperature_noted',
        'step_2_dryer_1_description','step_2_dryer_2_description','step_3_flow_blower_1','step_3_flow_blower_2',
        'step_3_regeneration_blower_phase_r','step_3_regeneration_blower_phase_s','step_3_regeneration_blower_phase_t',
        'step_3_dryer_heating_1_1','step_3_dryer_heating_1_2','step_3_dryer_heating_1_phase_r','step_3_dryer_heating_1_phase_s',
        'step_3_dryer_heating_1_phase_t','step_3_dryer_heating_2_1','step_3_dryer_heating_2_2','step_3_heater_dryer_2_phase_r',
        'step_3_heater_dryer_2_phase_s','step_3_heater_dryer_2_phase_t','step_3_dryer_regeneration_1_1','step_3_dryer_regeneration_1_2',
        'step_3_dryer_regeneration_2_1','step_3_dryer_regeneration_2_2','step_3_dryer_1_heating_up_time_before',
        'step_3_dryer_1_heating_up_time_after','step_3_dryer_1_heating_up_time_noted',
        'step_3_dryer_2_heating_up_time_before','step_3_dryer_2_heating_up_time_after','step_3_dryer_2_heating_up_time_noted',
        'step_3_dryer_1_heating_on_off_before','step_3_dryer_1_heating_on_off_after','step_3_dryer_1_heating_on_off_noted',
        'step_3_dryer_2_heating_on_off_before','step_3_dryer_2_heating_on_off_after','step_3_dryer_2_heating_on_off_noted',
        'step_3_dryer_1_heating_time_before','step_3_dryer_1_heating_time_after','step_3_dryer_1_heating_time_noted',
        'step_3_dryer_2_heating_time_before','step_3_dryer_2_heating_time_after','step_3_dryer_2_heating_time_noted',
        'step_3_dryer_1_total_time_before','step_3_dryer_1_total_time_after','step_3_dryer_1_total_time_noted',
        'step_3_dryer_2_total_time_before','step_3_dryer_2_total_time_after','step_3_dryer_2_total_time_noted',
        'step_3_dryer_1_description','step_3_dryer_2_description','step_4_voltage_1','step_4_voltage_1','step_4_current_consumption_1',
        'step_4_current_consumption_2','step_4_booster_pump_phase_r','step_4_booster_pump_phase_s','step_4_booster_pump_phase_t',
        'step_4_ozone_level_1','step_4_ozone_level_2','step_4_excess_ozone_1','step_4_excess_ozone_2','step_4_glass_breakage_relay',
        'step_4_glass_breakage_relay_desc','step_4_water_flow_1','step_4_water_flow_2','step_4_high_voltage_cable','step_4_high_voltage_cable_desc',
        'step_4_flow_cooling_1','step_4_flow_cooling_2','step_4_relay','step_4_relay_desc','step_4_flow_vaccum_1','step_4_flow_vaccum_2',
        'step_4_noise_filter','step_4_noise_filter_desc',
        'step_4_injection_pressure_in_1','step_4_injection_pressure_in_2','step_4_solenoid_valve','step_4_solenoid_valve_desc',
        'step_4_injection_pressure_out_1','step_4_injection_pressure_out_2','step_4_solenoid_valve_operation','step_4_solenoid_valve_operation_desc',
        'step_4_vaccu_in_plc_1','step_4_vaccu_in_plc_2','step_4_thermostat','step_4_thermostat_desc',
        'step_4_absolute_humidity_1','step_4_absolute_humidity_2','step_4_thermostat_26S2','step_4_thermostat_26S2_desc',
        'step_4_total_operation_time_1','step_4_total_operation_time_2','step_4_ozone_fault','step_4_ozone_fault_desc',
        'step_4_software_plc_1','step_4_software_plc_2','step_4_noted_all','step_4_noted_all_desc',
        'step_4_regeneration_blower_failure','step_4_open','step_4_open_desc',
        'step_4_heating_time_in_dryer_1_dan_dryer_2','step_4_close','step_4_close_desc',
        'step_4_thermostat_dryer_1_dan_dryer_2','step_4_seal_check_valve_injection','step_4_seal_check_valve_injection_desc',
        'step_4_ozone_mixing','step_4_cooling_water','step_4_ozone_cabinet_door','step_5_water_inrush_in_ozone_generation',
        'step_4_air_too_hot','step_5_ozone_mixing','step_4_mains_power_supply_phase_failure','step_5_cooling_water_temp',
        'step_4_water_inrush_in_ozone_generation','step_4_booster_pump_failure','step_5_trafo_high_voltage','step_4_ozone_generation',
        'step_5_tube_generator','step_4_ozone_gas_warning','step_5_filter_cabinet_fan','step_5_filter_cooling_water',
        'step_5_seal_check_valve','step_6_recommendation','file'

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
        return $this->belongsTo('App\Models\Schedule','id','id_ozon');
    }

    public function vSchedule()
    {
        return $this->belongsTo('App\Models\VSchedule','id','id_ozon');
    }
}
