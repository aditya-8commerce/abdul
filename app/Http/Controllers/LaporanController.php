<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Response,View,Input,Auth,Session,Validator,File,Hash,DB,Mail;
use Illuminate\Support\Facades\Crypt;
Use Alert;

use PHPExcel; 
use PHPExcel_IOFactory;

use App\Models\User;
use App\Models\Posisi;
use App\Models\Produk;
use App\Models\VSchedule;
use App\Models\Schedule;
use App\Models\VScheduleUser;
use App\Models\Customer;
use App\Models\ScheduleUV;
use App\Models\ScheduleOzon;
use App\Models\ScheduleEmergency;
use App\Models\ScheduleLog;


class LaporanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	/**
     * Display a listing of the resource.
     *
     * @return Response
     */
	public function createUV($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);

		$produk = Produk::orderBy('id','DESC')->get();


		if($data){
			return view('laporan.uv_create', ['data' => $data , 'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}

    }

    
	public function storeUV(Request $request,$id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = new ScheduleUV;

        $valid = $this->validate($request, [
            'subject'            => 'required|max:255',
            'customer_by'        => 'required|max:255',
            'model'              => 'required|max:255', // id_product
            'serial_number'      => 'required|max:255',
            'date'               => 'required|date_format:Y-m-d',
            'mfg'                => 'required|date_format:Y-m-d',
            'running_hours'      => 'required|numeric|min:1',
            'reminder'           => 'required|numeric',
            'line'               => 'max:255',
            'voltage_input'      => 'max:255',
            'output_ballast_1'   => 'max:255',
            'output_ballast_2'   => 'max:255',
            'output_ballast_3'   => 'max:255',
            'output_ballast_4'   => 'max:255',
            'frequency'          => 'max:255',
            'monitoring_station' => 'max:255',
            'tempreature'        => 'max:255',
            'cable_sensor'       => 'max:255',
            'sensor_uv'          => 'max:255',
            'socket_lamp_uv'     => 'max:255',
            'lamp_uv'            => 'max:255',
            'indicator_lamp'     => 'max:255',
            'noise_filter'       => 'max:255',
            'compression_nut'    => 'max:255',
            'o_ring'             => 'max:255',
            'supply_voltage_to_detector'    => 'max:255',
            'voltage_uv_output'  => 'max:255',
            'voltage_temperature'=> 'max:255',
            'main_switch'        => 'max:255',
            'fan_uv'             => 'max:255',
            'file'               => 'required|mimes:jpg,jpeg,png,pdf'
        ]);

        $file = $request->file('file');
        $extension  = $request->file('file')->getClientOriginalExtension();

		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = str_replace(' ', '-', 'laporan-uv-'.$request->subject).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }


				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
                $model->line                      = $request->line;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->date	                  = $request->date;
				$model->mfg 	                  = $request->mfg;
				$model->voltage_input             = $request->voltage_input;
				$model->output_ballast_1	      = $request->output_ballast_1;
				$model->output_ballast_2          = $request->output_ballast_2;
				$model->output_ballast_3          = $request->output_ballast_3;
				$model->output_ballast_4          = $request->output_ballast_4;
				$model->frequency                 = $request->frequency;
				$model->monitoring_station        = $request->monitoring_station;
				$model->tempreature               = $request->tempreature;
				$model->cable_sensor              = $request->cable_sensor;
				$model->sensor_uv                 = $request->sensor_uv;
				$model->socket_lamp_uv            = $request->socket_lamp_uv;
				$model->lamp_uv                   = $request->lamp_uv;
				$model->indicator_lamp            = $request->indicator_lamp;
				$model->noise_filter              = $request->noise_filter;
				$model->compression_nut           = $request->compression_nut;
				$model->o_ring                    = $request->o_ring;
				$model->supply_voltage_to_detector= $request->supply_voltage_to_detector;
				$model->voltage_uv_output         = $request->voltage_uv_output;
				$model->voltage_temperature       = $request->voltage_temperature;
				$model->main_switch               = $request->main_switch;
				$model->fan_uv                    = $request->fan_uv;
				$model->reccomendation            = $request->reccomendation;
				$model->remarks                   = $request->remarks;
                $model->file	                  = $fileName;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->status               = 'selesai';
                $data->report_type          = 'uv';
                $data->id_uv                = $model->id;
                $data->save();

                return redirect('/jadwal-proses')->with('success', 'data berhasil dimasukan');
            }
            
		}else{
			return redirect()->back()->with('info', 'file lebih dari 2 MB');
		}

    }

    
	public function detailUV($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','uv')->find($code);
		if($data){
			return view('laporan.uv_detail', ['data' => $data]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }

    
	public function destroyUV($id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::find($code);
		if($data){
            $model = ScheduleUV::find($codeUv);
            $destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = $model->file;
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
            $model->delete();

            $data->id_uv           = 0;
            $data->report_type     = "";
            $data->reminder_service= 0;
            $data->status          = "proses";
            $data->save();

			return redirect('/jadwal')->with('success', 'laporan berhasil di hapus');
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }

    
	public function editUV($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','uv')->find($code);
		if($data){
            $produk = Produk::orderBy('id','DESC')->get();    
			return view('laporan.uv_update', ['data' => $data ,'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }


	public function updateUV(Request $request,$id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = ScheduleUV::find($codeUv);


        
        $file = $request->file('file');
        if($file){
            $valid = $this->validate($request, [
                'subject'            => 'required|max:255',
                'customer_by'        => 'required|max:255',
                'model'              => 'required|max:255', // id_product
                'serial_number'      => 'required|max:255',
                'date'               => 'required|date_format:Y-m-d',
                'mfg'                => 'required|date_format:Y-m-d',
                'running_hours'      => 'required|numeric|min:1',
                'reminder'           => 'required|numeric',
                'line'               => 'max:255',
                'voltage_input'      => 'max:255',
                'output_ballast_1'   => 'max:255',
                'output_ballast_2'   => 'max:255',
                'output_ballast_3'   => 'max:255',
                'output_ballast_4'   => 'max:255',
                'frequency'          => 'max:255',
                'monitoring_station' => 'max:255',
                'tempreature'        => 'max:255',
                'cable_sensor'       => 'max:255',
                'sensor_uv'          => 'max:255',
                'socket_lamp_uv'     => 'max:255',
                'lamp_uv'            => 'max:255',
                'indicator_lamp'     => 'max:255',
                'noise_filter'       => 'max:255',
                'compression_nut'    => 'max:255',
                'o_ring'             => 'max:255',
                'supply_voltage_to_detector'    => 'max:255',
                'voltage_uv_output'  => 'max:255',
                'voltage_temperature'=> 'max:255',
                'main_switch'        => 'max:255',
                'fan_uv'             => 'max:255',
                'file'               => 'required|mimes:jpg,jpeg,png,pdf'
            ]);

            $extension  = $request->file('file')->getClientOriginalExtension();

		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = str_replace(' ', '-', 'laporan-uv-'.$request->subject).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                File::delete($destinationPath .$model->file);

                $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }


				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
                $model->line                      = $request->line;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->date	                  = $request->date;
				$model->mfg 	                  = $request->mfg;
				$model->voltage_input             = $request->voltage_input;
				$model->output_ballast_1	      = $request->output_ballast_1;
				$model->output_ballast_2          = $request->output_ballast_2;
				$model->output_ballast_3          = $request->output_ballast_3;
				$model->output_ballast_4          = $request->output_ballast_4;
				$model->frequency                 = $request->frequency;
				$model->monitoring_station        = $request->monitoring_station;
				$model->tempreature               = $request->tempreature;
				$model->cable_sensor              = $request->cable_sensor;
				$model->sensor_uv                 = $request->sensor_uv;
				$model->socket_lamp_uv            = $request->socket_lamp_uv;
				$model->lamp_uv                   = $request->lamp_uv;
				$model->indicator_lamp            = $request->indicator_lamp;
				$model->noise_filter              = $request->noise_filter;
				$model->compression_nut           = $request->compression_nut;
				$model->o_ring                    = $request->o_ring;
				$model->supply_voltage_to_detector= $request->supply_voltage_to_detector;
				$model->voltage_uv_output         = $request->voltage_uv_output;
				$model->voltage_temperature       = $request->voltage_temperature;
				$model->main_switch               = $request->main_switch;
				$model->fan_uv                    = $request->fan_uv;
				$model->reccomendation            = $request->reccomendation;
				$model->remarks                   = $request->remarks;
                $model->file	                  = $fileName;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->save();

                return redirect()->back()->with('success', 'data berhasil dirubah');
            }
            
		}else{
			return redirect()->back()->with('info', 'file lebih dari 2 MB');
		}
        }else{
            $valid = $this->validate($request, [
                'subject'            => 'required|max:255',
                'customer_by'        => 'required|max:255',
                'model'              => 'required|max:255', // id_product
                'serial_number'      => 'required|max:255',
                'date'               => 'required|date_format:Y-m-d',
                'mfg'                => 'required|date_format:Y-m-d',
                'running_hours'      => 'required|numeric|min:1',
                'reminder'           => 'required|numeric',
                'line'               => 'max:255',
                'voltage_input'      => 'max:255',
                'output_ballast_1'   => 'max:255',
                'output_ballast_2'   => 'max:255',
                'output_ballast_3'   => 'max:255',
                'output_ballast_4'   => 'max:255',
                'frequency'          => 'max:255',
                'monitoring_station' => 'max:255',
                'tempreature'        => 'max:255',
                'cable_sensor'       => 'max:255',
                'sensor_uv'          => 'max:255',
                'socket_lamp_uv'     => 'max:255',
                'lamp_uv'            => 'max:255',
                'indicator_lamp'     => 'max:255',
                'noise_filter'       => 'max:255',
                'compression_nut'    => 'max:255',
                'o_ring'             => 'max:255',
                'supply_voltage_to_detector'    => 'max:255',
                'voltage_uv_output'  => 'max:255',
                'voltage_temperature'=> 'max:255',
                'main_switch'        => 'max:255',
                'fan_uv'             => 'max:255'
            ]);

            $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }


				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
                $model->line                      = $request->line;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->date	                  = $request->date;
				$model->mfg 	                  = $request->mfg;
				$model->voltage_input             = $request->voltage_input;
				$model->output_ballast_1	      = $request->output_ballast_1;
				$model->output_ballast_2          = $request->output_ballast_2;
				$model->output_ballast_3          = $request->output_ballast_3;
				$model->output_ballast_4          = $request->output_ballast_4;
				$model->frequency                 = $request->frequency;
				$model->monitoring_station        = $request->monitoring_station;
				$model->tempreature               = $request->tempreature;
				$model->cable_sensor              = $request->cable_sensor;
				$model->sensor_uv                 = $request->sensor_uv;
				$model->socket_lamp_uv            = $request->socket_lamp_uv;
				$model->lamp_uv                   = $request->lamp_uv;
				$model->indicator_lamp            = $request->indicator_lamp;
				$model->noise_filter              = $request->noise_filter;
				$model->compression_nut           = $request->compression_nut;
				$model->o_ring                    = $request->o_ring;
				$model->supply_voltage_to_detector= $request->supply_voltage_to_detector;
				$model->voltage_uv_output         = $request->voltage_uv_output;
				$model->voltage_temperature       = $request->voltage_temperature;
				$model->main_switch               = $request->main_switch;
				$model->fan_uv                    = $request->fan_uv;
				$model->reccomendation            = $request->reccomendation;
				$model->remarks                   = $request->remarks;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->save();

                return redirect()->back()->with('success', 'data berhasil dirubah');
        } 

    }




    
	public function createOzon($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);

		$produk = Produk::orderBy('id','DESC')->get();


		if($data){
			return view('laporan.ozon_create', ['data' => $data , 'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}

    }


    
    
	public function storeOzon(Request $request,$id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = new ScheduleOzon;

        $valid = $this->validate($request, [
            'subject'                                       => 'required|max:255',
            'customer_by'                                   => 'required|max:255',
            'model'                                         => 'required|max:255', // id_product
            'serial_number'                                 => 'required|max:255',
            'date'                                          => 'required|date_format:Y-m-d',
            'year'                                          => 'required|date_format:m/Y',
            'running_hours'                                 => 'required|numeric|min:1',
            'lock'                                          => 'required|max:2',
            'step_1_dryer_1_remaining_capacity_noted'       => 'max:255',
            'step_1_dryer_2_remaining_capacity_noted'       => 'max:255',
            'step_1_dryer_1_dew_point_noted'                => 'max:255',
            'step_1_dryer_2_dew_point_noted'                => 'max:255',
            'step_1_dryer_1_gas_temperature_noted'          => 'max:255',
            'step_1_dryer_2_gas_temperature_noted'          => 'max:255',
            'step_1_dryer_1_description'                    => 'max:255',
            'step_1_dryer_2_description'                    => 'max:255',
            'step_2_dryer_1_remaining_capacity_noted'       => 'max:255',
            'step_2_dryer_2_remaining_capacity_noted'       => 'max:255',
            'step_2_dryer_1_dew_point_noted'                => 'max:255',
            'step_2_dryer_2_dew_point_noted'                => 'max:255',
            'step_2_dryer_1_gas_temperature_noted'          => 'max:255',
            'step_2_dryer_2_gas_temperature_noted'          => 'max:255',
            'step_2_dryer_1_description'                    => 'max:255',
            'step_2_dryer_2_description'                    => 'max:255',
            'step_3_dryer_1_heating_up_time_noted'          => 'max:255',
            'step_3_dryer_2_heating_up_time_noted'          => 'max:255',
            'step_3_dryer_1_heating_on_off_noted'           => 'max:255',
            'step_3_dryer_2_heating_on_off_noted'           => 'max:255',
            'step_3_dryer_1_heating_time_noted'             => 'max:255',
            'step_3_dryer_2_heating_time_noted'             => 'max:255',
            'step_3_dryer_1_total_time_noted'               => 'max:255',
            'step_3_dryer_2_total_time_noted'               => 'max:255',
            'step_3_dryer_1_description'                    => 'max:255',
            'step_3_dryer_2_description'                    => 'max:255',
            'step_4_glass_breakage_relay'                   => 'max:1',
            'step_4_glass_breakage_relay_desc'              => 'max:255',
            'step_4_high_voltage_cable'                     => 'max:1',
            'step_4_high_voltage_cable_desc'                => 'max:255',
            'step_4_relay'                                  => 'max:1',
            'step_4_relay_desc'                             => 'max:255',
            'step_4_noise_filter'                           => 'max:1',
            'step_4_noise_filter_desc'                      => 'max:255',
            'step_4_solenoid_valve'                         => 'max:1',
            'step_4_solenoid_valve_desc'                    => 'max:255',
            'step_4_solenoid_valve_operation'               => 'max:1',
            'step_4_solenoid_valve_operation_desc'          => 'max:255',
            'step_4_thermostat'                             => 'max:1',
            'step_4_thermostat_desc'                        => 'max:255',
            'step_4_thermostat_26S2'                        => 'max:1',
            'step_4_thermostat_26S2_desc'                   => 'max:255',
            'step_4_ozone_fault'                            => 'max:1',
            'step_4_ozone_fault_desc'                       => 'max:255',
            'step_4_noted_all'                              => 'max:1',
            'step_4_noted_all_desc'                         => 'max:255',
            'step_4_regeneration_blower_failure'            => 'max:255',
            'step_4_open'                                   => 'max:1',
            'step_4_open_desc'                              => 'max:255',
            'step_4_heating_time_in_dryer_1_dan_dryer_2'    => 'max:255',
            'step_4_close'                                  => 'max:1',
            'step_4_close_desc'                             => 'max:255',
            'step_4_thermostat_dryer_1_dan_dryer_2'         => 'max:255',
            'step_4_seal_check_valve_injection'             => 'max:1',
            'step_4_seal_check_valve_injection_desc'        => 'max:255',
            'step_4_ozone_mixing'                           => 'max:255',
            'step_4_cooling_water'                          => 'max:255',
            'step_4_ozone_cabinet_door'                     => 'max:255',
            'step_5_water_inrush_in_ozone_generation'       => 'max:255',
            'step_4_air_too_hot'       => 'max:255',
            'step_5_ozone_mixing'       => 'max:255',
            'step_4_mains_power_supply_phase_failure'       => 'max:255',
            'step_5_cooling_water_temp'       => 'max:255',
            'step_4_water_inrush_in_ozone_generation'       => 'max:255',
            'step_4_booster_pump_failure'       => 'max:255',
            'step_5_trafo_high_voltage'       => 'max:255',
            'step_4_ozone_generation'       => 'max:255',
            'step_5_tube_generator'       => 'max:255',
            'step_4_ozone_gas_warning'       => 'max:255',
            'step_5_filter_cabinet_fan'       => 'max:255',
            'step_5_filter_cooling_water'       => 'max:255',
            'step_5_seal_check_valve'       => 'max:255',
            'file'                                          => 'required|mimes:jpg,jpeg,png,pdf'
        ]);

        $file = $request->file('file');
        $extension  = $request->file('file')->getClientOriginalExtension();

		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = str_replace(' ', '-', 'laporan-ozon-'.$request->subject).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }


				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->year                      = $request->year;
				$model->date	                  = $request->date;
				$model->lock	                  = $request->lock;
				$model->step_1_dryer_1_remaining_capacity_before	                  = $request->step_1_dryer_1_remaining_capacity_before;
				$model->step_1_dryer_1_remaining_capacity_after	                  = $request->step_1_dryer_1_remaining_capacity_after;
				$model->step_1_dryer_1_remaining_capacity_noted	                  = $request->step_1_dryer_1_remaining_capacity_noted;
				$model->step_1_dryer_2_remaining_capacity_before	                  = $request->step_1_dryer_2_remaining_capacity_before;
				$model->step_1_dryer_2_remaining_capacity_after	                  = $request->step_1_dryer_2_remaining_capacity_after;
				$model->step_1_dryer_2_remaining_capacity_noted	                  = $request->step_1_dryer_2_remaining_capacity_noted;
				$model->step_1_dryer_1_dew_point_before	                  = $request->step_1_dryer_1_dew_point_before;
				$model->step_1_dryer_1_dew_point_after	                  = $request->step_1_dryer_1_dew_point_after;
				$model->step_1_dryer_1_dew_point_noted	                  = $request->step_1_dryer_1_dew_point_noted;
				$model->step_1_dryer_2_dew_point_before	                  = $request->step_1_dryer_2_dew_point_before;
				$model->step_1_dryer_2_dew_point_after	                  = $request->step_1_dryer_2_dew_point_after;
				$model->step_1_dryer_2_dew_point_noted	                  = $request->step_1_dryer_2_dew_point_noted;
				$model->step_1_dryer_1_gas_temperature_before	                  = $request->step_1_dryer_1_gas_temperature_before;
				$model->step_1_dryer_1_gas_temperature_after	                  = $request->step_1_dryer_1_gas_temperature_after;
				$model->step_1_dryer_1_gas_temperature_noted	                  = $request->step_1_dryer_1_gas_temperature_noted;
				$model->step_1_dryer_2_gas_temperature_before	                  = $request->step_1_dryer_2_gas_temperature_before;
				$model->step_1_dryer_2_gas_temperature_after	                  = $request->step_1_dryer_2_gas_temperature_after;
				$model->step_1_dryer_2_gas_temperature_noted	                  = $request->step_1_dryer_2_gas_temperature_noted;
				$model->step_1_dryer_1_description	                  = $request->step_1_dryer_1_description;
				$model->step_1_dryer_2_description	                  = $request->step_1_dryer_2_description;
				$model->step_2_dryer_1_remaining_capacity_before	                  = $request->step_2_dryer_1_remaining_capacity_before;
				$model->step_2_dryer_1_remaining_capacity_after	                  = $request->step_2_dryer_1_remaining_capacity_after;
				$model->step_2_dryer_1_remaining_capacity_noted	                  = $request->step_2_dryer_1_remaining_capacity_noted;
				$model->step_2_dryer_2_remaining_capacity_before	                  = $request->step_2_dryer_2_remaining_capacity_before;
				$model->step_2_dryer_2_remaining_capacity_after	                  = $request->step_2_dryer_2_remaining_capacity_after;
				$model->step_2_dryer_2_remaining_capacity_noted	                  = $request->step_2_dryer_2_remaining_capacity_noted;
				$model->step_2_dryer_1_dew_point_before	                  = $request->step_2_dryer_1_dew_point_before;
				$model->step_2_dryer_1_dew_point_after	                  = $request->step_2_dryer_1_dew_point_after;
				$model->step_2_dryer_1_dew_point_noted	                  = $request->step_2_dryer_1_dew_point_noted;
				$model->step_2_dryer_2_dew_point_before	                  = $request->step_2_dryer_2_dew_point_before;
				$model->step_2_dryer_2_dew_point_after	                  = $request->step_2_dryer_2_dew_point_after;
				$model->step_2_dryer_2_dew_point_noted	                  = $request->step_2_dryer_2_dew_point_noted;
				$model->step_2_dryer_1_gas_temperature_before	                  = $request->step_2_dryer_1_gas_temperature_before;
				$model->step_2_dryer_2_gas_temperature_after	                  = $request->step_2_dryer_2_gas_temperature_after;
				$model->step_2_dryer_2_gas_temperature_noted	                  = $request->step_2_dryer_2_gas_temperature_noted;
				$model->step_2_dryer_1_description	                  = $request->step_2_dryer_1_description;
				$model->step_2_dryer_2_description	                  = $request->step_2_dryer_2_description;
				$model->step_3_flow_blower_1	                  = $request->step_3_flow_blower_1;
				$model->step_3_flow_blower_2	                  = $request->step_3_flow_blower_2;
				$model->step_3_regeneration_blower_phase_r	                  = $request->step_3_regeneration_blower_phase_r;
				$model->step_3_regeneration_blower_phase_s	                  = $request->step_3_regeneration_blower_phase_s;
				$model->step_3_regeneration_blower_phase_t	                  = $request->step_3_regeneration_blower_phase_t;
				$model->step_3_dryer_heating_1_1	                  = $request->step_3_dryer_heating_1_1;
				$model->step_3_dryer_heating_1_2	                  = $request->step_3_dryer_heating_1_2;
				$model->step_3_dryer_heating_1_phase_r	                  = $request->step_3_dryer_heating_1_phase_r;
				$model->step_3_dryer_heating_1_phase_s	                  = $request->step_3_dryer_heating_1_phase_s;
				$model->step_3_dryer_heating_1_phase_t	                  = $request->step_3_dryer_heating_1_phase_t;
				$model->step_3_dryer_heating_2_1	                  = $request->step_3_dryer_heating_2_1;
				$model->step_3_dryer_heating_2_2	                  = $request->step_3_dryer_heating_2_2;
				$model->step_3_heater_dryer_2_phase_r	                  = $request->step_3_heater_dryer_2_phase_r;
				$model->step_3_heater_dryer_2_phase_s	                  = $request->step_3_heater_dryer_2_phase_s;
				$model->step_3_heater_dryer_2_phase_t	                  = $request->step_3_heater_dryer_2_phase_t;
				$model->step_3_dryer_regeneration_1_1	                  = $request->step_3_dryer_regeneration_1_1;
				$model->step_3_dryer_regeneration_1_2	                  = $request->step_3_dryer_regeneration_1_2;
				$model->step_3_dryer_regeneration_2_1	                  = $request->step_3_dryer_regeneration_2_1;
				$model->step_3_dryer_regeneration_2_2	                  = $request->step_3_dryer_regeneration_2_2;
				$model->step_3_dryer_1_heating_up_time_before	                  = $request->step_3_dryer_1_heating_up_time_before;
				$model->step_3_dryer_1_heating_up_time_after	                  = $request->step_3_dryer_1_heating_up_time_after;
				$model->step_3_dryer_1_heating_up_time_noted	                  = $request->step_3_dryer_1_heating_up_time_noted;
				$model->step_3_dryer_2_heating_up_time_before	                  = $request->step_3_dryer_2_heating_up_time_before;
				$model->step_3_dryer_2_heating_up_time_after	                  = $request->step_3_dryer_2_heating_up_time_after;
				$model->step_3_dryer_2_heating_up_time_noted	                  = $request->step_3_dryer_2_heating_up_time_noted;
				$model->step_3_dryer_1_heating_on_off_before	                  = $request->step_3_dryer_1_heating_on_off_before;
				$model->step_3_dryer_1_heating_on_off_after	                  = $request->step_3_dryer_1_heating_on_off_after;
				$model->step_3_dryer_1_heating_on_off_noted	                  = $request->step_3_dryer_1_heating_on_off_noted;
				$model->step_3_dryer_2_heating_on_off_before	                  = $request->step_3_dryer_2_heating_on_off_before;
				$model->step_3_dryer_2_heating_on_off_after	                  = $request->step_3_dryer_2_heating_on_off_after;
				$model->step_3_dryer_2_heating_on_off_noted	                  = $request->step_3_dryer_2_heating_on_off_noted;
				$model->step_3_dryer_1_heating_time_before	                  = $request->step_3_dryer_1_heating_time_before;
				$model->step_3_dryer_1_heating_time_after	                  = $request->step_3_dryer_1_heating_time_after;
				$model->step_3_dryer_1_heating_time_noted	                  = $request->step_3_dryer_1_heating_time_noted;
				$model->step_3_dryer_2_heating_time_before	                  = $request->step_3_dryer_2_heating_time_before;
				$model->step_3_dryer_2_heating_time_after	                  = $request->step_3_dryer_2_heating_time_after;
				$model->step_3_dryer_2_heating_time_noted	                  = $request->step_3_dryer_2_heating_time_noted;
				$model->step_3_dryer_1_description	                  = $request->step_3_dryer_1_description;
				$model->step_3_dryer_2_description	                  = $request->step_3_dryer_2_description;
				$model->step_4_voltage_1	                  = $request->step_4_voltage_1;
				$model->step_4_voltage_2	                  = $request->step_4_voltage_2;
				$model->step_4_current_consumption_1	                  = $request->step_4_current_consumption_1;
				$model->step_4_current_consumption_2	                  = $request->step_4_current_consumption_2;
				$model->step_4_booster_pump_phase_r	                  = $request->step_4_booster_pump_phase_r;
				$model->step_4_booster_pump_phase_s	                  = $request->step_4_booster_pump_phase_s;
				$model->step_4_booster_pump_phase_t	                  = $request->step_4_booster_pump_phase_t;
				$model->step_4_ozone_level_1	                  = $request->step_4_ozone_level_1;
				$model->step_4_ozone_level_2	                  = $request->step_4_ozone_level_2;
				$model->step_4_excess_ozone_1	                  = $request->step_4_excess_ozone_1;
				$model->step_4_excess_ozone_2	                  = $request->step_4_excess_ozone_2;
				$model->step_4_glass_breakage_relay	                  = $request->step_4_glass_breakage_relay;
				$model->step_4_glass_breakage_relay_desc	                  = $request->step_4_glass_breakage_relay_desc;
				$model->step_4_water_flow_1	                  = $request->step_4_water_flow_1;
				$model->step_4_water_flow_2	                  = $request->step_4_water_flow_2;
				$model->step_4_high_voltage_cable	                  = $request->step_4_high_voltage_cable;
				$model->step_4_high_voltage_cable_desc	                  = $request->step_4_high_voltage_cable_desc;
				$model->step_4_flow_cooling_1	                  = $request->step_4_flow_cooling_1;
				$model->step_4_flow_cooling_2	                  = $request->step_4_flow_cooling_2;
				$model->step_4_relay	                  = $request->step_4_relay;
				$model->step_4_relay_desc	                  = $request->step_4_relay_desc;
				$model->step_4_flow_vaccum_1	                  = $request->step_4_flow_vaccum_1;
				$model->step_4_flow_vaccum_2	                  = $request->step_4_flow_vaccum_2;
				$model->step_4_noise_filter	                  = $request->step_4_noise_filter;
				$model->step_4_noise_filter_desc	                  = $request->step_4_noise_filter_desc;
				$model->step_4_injection_pressure_in_1	                  = $request->step_4_injection_pressure_in_1;
				$model->step_4_injection_pressure_in_2	                  = $request->step_4_injection_pressure_in_2;
				$model->step_4_solenoid_valve	                  = $request->step_4_solenoid_valve;
				$model->step_4_solenoid_valve_desc	                  = $request->step_4_solenoid_valve_desc;
				$model->step_4_injection_pressure_out_1	                  = $request->step_4_injection_pressure_out_1;
				$model->step_4_injection_pressure_out_2	                  = $request->step_4_injection_pressure_out_2;
				$model->step_4_solenoid_valve_operation	                  = $request->step_4_solenoid_valve_operation;
				$model->step_4_solenoid_valve_operation_desc	                  = $request->step_4_solenoid_valve_operation_desc;
				$model->step_4_vaccu_in_plc_1	                  = $request->step_4_vaccu_in_plc_1;
				$model->step_4_vaccu_in_plc_2	                  = $request->step_4_vaccu_in_plc_2;
				$model->step_4_thermostat	                  = $request->step_4_thermostat;
				$model->step_4_thermostat_desc	                  = $request->step_4_thermostat_desc;
				$model->step_4_absolute_humidity_1	                  = $request->step_4_absolute_humidity_1;
				$model->step_4_absolute_humidity_2	                  = $request->step_4_absolute_humidity_2;
				$model->step_4_thermostat_26S2	                  = $request->step_4_thermostat_26S2;
				$model->step_4_thermostat_26S2_desc	                  = $request->step_4_thermostat_26S2_desc;
				$model->step_4_total_operation_time_1	                  = $request->step_4_total_operation_time_1;
				$model->step_4_total_operation_time_2	                  = $request->step_4_total_operation_time_2;
				$model->step_4_ozone_fault	                  = $request->step_4_ozone_fault;
				$model->step_4_ozone_fault_desc	                  = $request->step_4_ozone_fault_desc;
				$model->step_4_software_plc_1	                  = $request->step_4_software_plc_1;
				$model->step_4_software_plc_2	                  = $request->step_4_software_plc_2;
				$model->step_4_noted_all	                  = $request->step_4_noted_all;
				$model->step_4_noted_all_desc	                  = $request->step_4_noted_all_desc;
				$model->step_4_regeneration_blower_failure	                  = $request->step_4_regeneration_blower_failure;
				$model->step_4_open	                  = $request->step_4_open;
				$model->step_4_open_desc	                  = $request->step_4_open_desc;
				$model->step_4_heating_time_in_dryer_1_dan_dryer_2	                  = $request->step_4_heating_time_in_dryer_1_dan_dryer_2;
				$model->step_4_close	                  = $request->step_4_close;
				$model->step_4_close_desc	                  = $request->step_4_close_desc;
				$model->step_4_thermostat_dryer_1_dan_dryer_2	                  = $request->step_4_thermostat_dryer_1_dan_dryer_2;
				$model->step_4_seal_check_valve_injection	                  = $request->step_4_seal_check_valve_injection;
				$model->step_4_seal_check_valve_injection_desc	                  = $request->step_4_seal_check_valve_injection_desc;
				$model->step_4_ozone_mixing	                  = $request->step_4_ozone_mixing;
				$model->step_4_cooling_water	                  = $request->step_4_cooling_water;
				$model->step_4_ozone_cabinet_door	                  = $request->step_4_ozone_cabinet_door;
				$model->step_5_water_inrush_in_ozone_generation	                  = $request->step_5_water_inrush_in_ozone_generation;
				$model->step_4_air_too_hot	                  = $request->step_4_air_too_hot;
				$model->step_5_ozone_mixing	                  = $request->step_5_ozone_mixing;
				$model->step_4_mains_power_supply_phase_failure	                  = $request->step_4_mains_power_supply_phase_failure;
				$model->step_5_cooling_water_temp	                  = $request->step_5_cooling_water_temp;
				$model->step_4_water_inrush_in_ozone_generation	                  = $request->step_4_water_inrush_in_ozone_generation;
				$model->step_4_booster_pump_failure	                  = $request->step_4_booster_pump_failure;
				$model->step_5_trafo_high_voltage	                  = $request->step_5_trafo_high_voltage;
				$model->step_4_ozone_generation	                  = $request->step_4_ozone_generation;
				$model->step_5_tube_generator	                  = $request->step_5_tube_generator;
				$model->step_4_ozone_gas_warning	                  = $request->step_4_ozone_gas_warning;
				$model->step_5_filter_cabinet_fan	                  = $request->step_5_filter_cabinet_fan;
				$model->step_5_filter_cooling_water	                  = $request->step_5_filter_cooling_water;
				$model->step_5_seal_check_valve	                  = $request->step_5_seal_check_valve;
				$model->step_6_recommendation	                  = $request->step_6_recommendation;
                $model->file	                  = $fileName;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->status               = 'selesai';
                $data->report_type          = 'ozon';
                $data->id_ozon                = $model->id;
                $data->save();

                return redirect('/jadwal-proses')->with('success', 'data berhasil dimasukan');
            }
            
		}else{
			return redirect()->back()->with('info', 'file lebih dari 2 MB');
		}

    }

    
	public function detailOzon($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','ozon')->find($code);
		if($data){
			return view('laporan.ozon_detail', ['data' => $data]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }

    
	public function editOzon($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','ozon')->find($code);
		if($data){
            $produk = Produk::orderBy('id','DESC')->get();    
			return view('laporan.ozon_update', ['data' => $data ,'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }
    
	public function destroyOzon($id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::find($code);
		if($data){
            $model = ScheduleOzon::find($codeUv);
            $destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = $model->file;
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
            $model->delete();

            $data->id_ozon           = 0;
            $data->report_type     = "";
            $data->reminder_service= 0;
            $data->status          = "proses";
            $data->save();

			return redirect('/jadwal')->with('success', 'laporan berhasil di hapus');
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }


    

	public function updateOzon(Request $request,$id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = ScheduleOzon::find($codeUv);


        
        $file = $request->file('file');
        if($file){
            $valid = $this->validate($request, [
                'subject'                                       => 'required|max:255',
                'customer_by'                                   => 'required|max:255',
                'model'                                         => 'required|max:255', // id_product
                'serial_number'                                 => 'required|max:255',
                'date'                                          => 'required|date_format:Y-m-d',
                'year'                                          => 'required|date_format:m/Y',
                'running_hours'                                 => 'required|numeric|min:1',
                'lock'                                          => 'required|max:2',
                'step_1_dryer_1_remaining_capacity_noted'       => 'max:255',
                'step_1_dryer_2_remaining_capacity_noted'       => 'max:255',
                'step_1_dryer_1_dew_point_noted'                => 'max:255',
                'step_1_dryer_2_dew_point_noted'                => 'max:255',
                'step_1_dryer_1_gas_temperature_noted'          => 'max:255',
                'step_1_dryer_2_gas_temperature_noted'          => 'max:255',
                'step_1_dryer_1_description'                    => 'max:255',
                'step_1_dryer_2_description'                    => 'max:255',
                'step_2_dryer_1_remaining_capacity_noted'       => 'max:255',
                'step_2_dryer_2_remaining_capacity_noted'       => 'max:255',
                'step_2_dryer_1_dew_point_noted'                => 'max:255',
                'step_2_dryer_2_dew_point_noted'                => 'max:255',
                'step_2_dryer_1_gas_temperature_noted'          => 'max:255',
                'step_2_dryer_2_gas_temperature_noted'          => 'max:255',
                'step_2_dryer_1_description'                    => 'max:255',
                'step_2_dryer_2_description'                    => 'max:255',
                'step_3_dryer_1_heating_up_time_noted'          => 'max:255',
                'step_3_dryer_2_heating_up_time_noted'          => 'max:255',
                'step_3_dryer_1_heating_on_off_noted'           => 'max:255',
                'step_3_dryer_2_heating_on_off_noted'           => 'max:255',
                'step_3_dryer_1_heating_time_noted'             => 'max:255',
                'step_3_dryer_2_heating_time_noted'             => 'max:255',
                'step_3_dryer_1_total_time_noted'               => 'max:255',
                'step_3_dryer_2_total_time_noted'               => 'max:255',
                'step_3_dryer_1_description'                    => 'max:255',
                'step_3_dryer_2_description'                    => 'max:255',
                'step_4_glass_breakage_relay'                   => 'max:1',
                'step_4_glass_breakage_relay_desc'              => 'max:255',
                'step_4_high_voltage_cable'                     => 'max:1',
                'step_4_high_voltage_cable_desc'                => 'max:255',
                'step_4_relay'                                  => 'max:1',
                'step_4_relay_desc'                             => 'max:255',
                'step_4_noise_filter'                           => 'max:1',
                'step_4_noise_filter_desc'                      => 'max:255',
                'step_4_solenoid_valve'                         => 'max:1',
                'step_4_solenoid_valve_desc'                    => 'max:255',
                'step_4_solenoid_valve_operation'               => 'max:1',
                'step_4_solenoid_valve_operation_desc'          => 'max:255',
                'step_4_thermostat'                             => 'max:1',
                'step_4_thermostat_desc'                        => 'max:255',
                'step_4_thermostat_26S2'                        => 'max:1',
                'step_4_thermostat_26S2_desc'                   => 'max:255',
                'step_4_ozone_fault'                            => 'max:1',
                'step_4_ozone_fault_desc'                       => 'max:255',
                'step_4_noted_all'                              => 'max:1',
                'step_4_noted_all_desc'                         => 'max:255',
                'step_4_regeneration_blower_failure'            => 'max:255',
                'step_4_open'                                   => 'max:1',
                'step_4_open_desc'                              => 'max:255',
                'step_4_heating_time_in_dryer_1_dan_dryer_2'    => 'max:255',
                'step_4_close'                                  => 'max:1',
                'step_4_close_desc'                             => 'max:255',
                'step_4_thermostat_dryer_1_dan_dryer_2'         => 'max:255',
                'step_4_seal_check_valve_injection'             => 'max:1',
                'step_4_seal_check_valve_injection_desc'        => 'max:255',
                'step_4_ozone_mixing'                           => 'max:255',
                'step_4_cooling_water'                          => 'max:255',
                'step_4_ozone_cabinet_door'                     => 'max:255',
                'step_5_water_inrush_in_ozone_generation'       => 'max:255',
                'step_4_air_too_hot'       => 'max:255',
                'step_5_ozone_mixing'       => 'max:255',
                'step_4_mains_power_supply_phase_failure'       => 'max:255',
                'step_5_cooling_water_temp'       => 'max:255',
                'step_4_water_inrush_in_ozone_generation'       => 'max:255',
                'step_4_booster_pump_failure'       => 'max:255',
                'step_5_trafo_high_voltage'       => 'max:255',
                'step_4_ozone_generation'       => 'max:255',
                'step_5_tube_generator'       => 'max:255',
                'step_4_ozone_gas_warning'       => 'max:255',
                'step_5_filter_cabinet_fan'       => 'max:255',
                'step_5_filter_cooling_water'       => 'max:255',
                'step_5_seal_check_valve'       => 'max:255',
                'file'                                          => 'required|mimes:jpg,jpeg,png,pdf'
            ]);

            $extension  = $request->file('file')->getClientOriginalExtension();

		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = str_replace(' ', '-', 'laporan-ozon-'.$request->subject).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                File::delete($destinationPath .$model->file);

                $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }



				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->year                      = $request->year;
				$model->date	                  = $request->date;
				$model->lock	                  = $request->lock;
				$model->step_1_dryer_1_remaining_capacity_before	                  = $request->step_1_dryer_1_remaining_capacity_before;
				$model->step_1_dryer_1_remaining_capacity_after	                  = $request->step_1_dryer_1_remaining_capacity_after;
				$model->step_1_dryer_1_remaining_capacity_noted	                  = $request->step_1_dryer_1_remaining_capacity_noted;
				$model->step_1_dryer_2_remaining_capacity_before	                  = $request->step_1_dryer_2_remaining_capacity_before;
				$model->step_1_dryer_2_remaining_capacity_after	                  = $request->step_1_dryer_2_remaining_capacity_after;
				$model->step_1_dryer_2_remaining_capacity_noted	                  = $request->step_1_dryer_2_remaining_capacity_noted;
				$model->step_1_dryer_1_dew_point_before	                  = $request->step_1_dryer_1_dew_point_before;
				$model->step_1_dryer_1_dew_point_after	                  = $request->step_1_dryer_1_dew_point_after;
				$model->step_1_dryer_1_dew_point_noted	                  = $request->step_1_dryer_1_dew_point_noted;
				$model->step_1_dryer_2_dew_point_before	                  = $request->step_1_dryer_2_dew_point_before;
				$model->step_1_dryer_2_dew_point_after	                  = $request->step_1_dryer_2_dew_point_after;
				$model->step_1_dryer_2_dew_point_noted	                  = $request->step_1_dryer_2_dew_point_noted;
				$model->step_1_dryer_1_gas_temperature_before	                  = $request->step_1_dryer_1_gas_temperature_before;
				$model->step_1_dryer_1_gas_temperature_after	                  = $request->step_1_dryer_1_gas_temperature_after;
				$model->step_1_dryer_1_gas_temperature_noted	                  = $request->step_1_dryer_1_gas_temperature_noted;
				$model->step_1_dryer_2_gas_temperature_before	                  = $request->step_1_dryer_2_gas_temperature_before;
				$model->step_1_dryer_2_gas_temperature_after	                  = $request->step_1_dryer_2_gas_temperature_after;
				$model->step_1_dryer_2_gas_temperature_noted	                  = $request->step_1_dryer_2_gas_temperature_noted;
				$model->step_1_dryer_1_description	                  = $request->step_1_dryer_1_description;
				$model->step_1_dryer_2_description	                  = $request->step_1_dryer_2_description;
				$model->step_2_dryer_1_remaining_capacity_before	                  = $request->step_2_dryer_1_remaining_capacity_before;
				$model->step_2_dryer_1_remaining_capacity_after	                  = $request->step_2_dryer_1_remaining_capacity_after;
				$model->step_2_dryer_1_remaining_capacity_noted	                  = $request->step_2_dryer_1_remaining_capacity_noted;
				$model->step_2_dryer_2_remaining_capacity_before	                  = $request->step_2_dryer_2_remaining_capacity_before;
				$model->step_2_dryer_2_remaining_capacity_after	                  = $request->step_2_dryer_2_remaining_capacity_after;
				$model->step_2_dryer_2_remaining_capacity_noted	                  = $request->step_2_dryer_2_remaining_capacity_noted;
				$model->step_2_dryer_1_dew_point_before	                  = $request->step_2_dryer_1_dew_point_before;
				$model->step_2_dryer_1_dew_point_after	                  = $request->step_2_dryer_1_dew_point_after;
				$model->step_2_dryer_1_dew_point_noted	                  = $request->step_2_dryer_1_dew_point_noted;
				$model->step_2_dryer_2_dew_point_before	                  = $request->step_2_dryer_2_dew_point_before;
				$model->step_2_dryer_2_dew_point_after	                  = $request->step_2_dryer_2_dew_point_after;
				$model->step_2_dryer_2_dew_point_noted	                  = $request->step_2_dryer_2_dew_point_noted;
				$model->step_2_dryer_1_gas_temperature_before	                  = $request->step_2_dryer_1_gas_temperature_before;
				$model->step_2_dryer_2_gas_temperature_after	                  = $request->step_2_dryer_2_gas_temperature_after;
				$model->step_2_dryer_2_gas_temperature_noted	                  = $request->step_2_dryer_2_gas_temperature_noted;
				$model->step_2_dryer_1_description	                  = $request->step_2_dryer_1_description;
				$model->step_2_dryer_2_description	                  = $request->step_2_dryer_2_description;
				$model->step_3_flow_blower_1	                  = $request->step_3_flow_blower_1;
				$model->step_3_flow_blower_2	                  = $request->step_3_flow_blower_2;
				$model->step_3_regeneration_blower_phase_r	                  = $request->step_3_regeneration_blower_phase_r;
				$model->step_3_regeneration_blower_phase_s	                  = $request->step_3_regeneration_blower_phase_s;
				$model->step_3_regeneration_blower_phase_t	                  = $request->step_3_regeneration_blower_phase_t;
				$model->step_3_dryer_heating_1_1	                  = $request->step_3_dryer_heating_1_1;
				$model->step_3_dryer_heating_1_2	                  = $request->step_3_dryer_heating_1_2;
				$model->step_3_dryer_heating_1_phase_r	                  = $request->step_3_dryer_heating_1_phase_r;
				$model->step_3_dryer_heating_1_phase_s	                  = $request->step_3_dryer_heating_1_phase_s;
				$model->step_3_dryer_heating_1_phase_t	                  = $request->step_3_dryer_heating_1_phase_t;
				$model->step_3_dryer_heating_2_1	                  = $request->step_3_dryer_heating_2_1;
				$model->step_3_dryer_heating_2_2	                  = $request->step_3_dryer_heating_2_2;
				$model->step_3_heater_dryer_2_phase_r	                  = $request->step_3_heater_dryer_2_phase_r;
				$model->step_3_heater_dryer_2_phase_s	                  = $request->step_3_heater_dryer_2_phase_s;
				$model->step_3_heater_dryer_2_phase_t	                  = $request->step_3_heater_dryer_2_phase_t;
				$model->step_3_dryer_regeneration_1_1	                  = $request->step_3_dryer_regeneration_1_1;
				$model->step_3_dryer_regeneration_1_2	                  = $request->step_3_dryer_regeneration_1_2;
				$model->step_3_dryer_regeneration_2_1	                  = $request->step_3_dryer_regeneration_2_1;
				$model->step_3_dryer_regeneration_2_2	                  = $request->step_3_dryer_regeneration_2_2;
				$model->step_3_dryer_1_heating_up_time_before	                  = $request->step_3_dryer_1_heating_up_time_before;
				$model->step_3_dryer_1_heating_up_time_after	                  = $request->step_3_dryer_1_heating_up_time_after;
				$model->step_3_dryer_1_heating_up_time_noted	                  = $request->step_3_dryer_1_heating_up_time_noted;
				$model->step_3_dryer_2_heating_up_time_before	                  = $request->step_3_dryer_2_heating_up_time_before;
				$model->step_3_dryer_2_heating_up_time_after	                  = $request->step_3_dryer_2_heating_up_time_after;
				$model->step_3_dryer_2_heating_up_time_noted	                  = $request->step_3_dryer_2_heating_up_time_noted;
				$model->step_3_dryer_1_heating_on_off_before	                  = $request->step_3_dryer_1_heating_on_off_before;
				$model->step_3_dryer_1_heating_on_off_after	                  = $request->step_3_dryer_1_heating_on_off_after;
				$model->step_3_dryer_1_heating_on_off_noted	                  = $request->step_3_dryer_1_heating_on_off_noted;
				$model->step_3_dryer_2_heating_on_off_before	                  = $request->step_3_dryer_2_heating_on_off_before;
				$model->step_3_dryer_2_heating_on_off_after	                  = $request->step_3_dryer_2_heating_on_off_after;
				$model->step_3_dryer_2_heating_on_off_noted	                  = $request->step_3_dryer_2_heating_on_off_noted;
				$model->step_3_dryer_1_heating_time_before	                  = $request->step_3_dryer_1_heating_time_before;
				$model->step_3_dryer_1_heating_time_after	                  = $request->step_3_dryer_1_heating_time_after;
				$model->step_3_dryer_1_heating_time_noted	                  = $request->step_3_dryer_1_heating_time_noted;
				$model->step_3_dryer_2_heating_time_before	                  = $request->step_3_dryer_2_heating_time_before;
				$model->step_3_dryer_2_heating_time_after	                  = $request->step_3_dryer_2_heating_time_after;
				$model->step_3_dryer_2_heating_time_noted	                  = $request->step_3_dryer_2_heating_time_noted;
				$model->step_3_dryer_1_description	                  = $request->step_3_dryer_1_description;
				$model->step_3_dryer_2_description	                  = $request->step_3_dryer_2_description;
				$model->step_4_voltage_1	                  = $request->step_4_voltage_1;
				$model->step_4_voltage_2	                  = $request->step_4_voltage_2;
				$model->step_4_current_consumption_1	                  = $request->step_4_current_consumption_1;
				$model->step_4_current_consumption_2	                  = $request->step_4_current_consumption_2;
				$model->step_4_booster_pump_phase_r	                  = $request->step_4_booster_pump_phase_r;
				$model->step_4_booster_pump_phase_s	                  = $request->step_4_booster_pump_phase_s;
				$model->step_4_booster_pump_phase_t	                  = $request->step_4_booster_pump_phase_t;
				$model->step_4_ozone_level_1	                  = $request->step_4_ozone_level_1;
				$model->step_4_ozone_level_2	                  = $request->step_4_ozone_level_2;
				$model->step_4_excess_ozone_1	                  = $request->step_4_excess_ozone_1;
				$model->step_4_excess_ozone_2	                  = $request->step_4_excess_ozone_2;
				$model->step_4_glass_breakage_relay	                  = $request->step_4_glass_breakage_relay;
				$model->step_4_glass_breakage_relay_desc	                  = $request->step_4_glass_breakage_relay_desc;
				$model->step_4_water_flow_1	                  = $request->step_4_water_flow_1;
				$model->step_4_water_flow_2	                  = $request->step_4_water_flow_2;
				$model->step_4_high_voltage_cable	                  = $request->step_4_high_voltage_cable;
				$model->step_4_high_voltage_cable_desc	                  = $request->step_4_high_voltage_cable_desc;
				$model->step_4_flow_cooling_1	                  = $request->step_4_flow_cooling_1;
				$model->step_4_flow_cooling_2	                  = $request->step_4_flow_cooling_2;
				$model->step_4_relay	                  = $request->step_4_relay;
				$model->step_4_relay_desc	                  = $request->step_4_relay_desc;
				$model->step_4_flow_vaccum_1	                  = $request->step_4_flow_vaccum_1;
				$model->step_4_flow_vaccum_2	                  = $request->step_4_flow_vaccum_2;
				$model->step_4_noise_filter	                  = $request->step_4_noise_filter;
				$model->step_4_noise_filter_desc	                  = $request->step_4_noise_filter_desc;
				$model->step_4_injection_pressure_in_1	                  = $request->step_4_injection_pressure_in_1;
				$model->step_4_injection_pressure_in_2	                  = $request->step_4_injection_pressure_in_2;
				$model->step_4_solenoid_valve	                  = $request->step_4_solenoid_valve;
				$model->step_4_solenoid_valve_desc	                  = $request->step_4_solenoid_valve_desc;
				$model->step_4_injection_pressure_out_1	                  = $request->step_4_injection_pressure_out_1;
				$model->step_4_injection_pressure_out_2	                  = $request->step_4_injection_pressure_out_2;
				$model->step_4_solenoid_valve_operation	                  = $request->step_4_solenoid_valve_operation;
				$model->step_4_solenoid_valve_operation_desc	                  = $request->step_4_solenoid_valve_operation_desc;
				$model->step_4_vaccu_in_plc_1	                  = $request->step_4_vaccu_in_plc_1;
				$model->step_4_vaccu_in_plc_2	                  = $request->step_4_vaccu_in_plc_2;
				$model->step_4_thermostat	                  = $request->step_4_thermostat;
				$model->step_4_thermostat_desc	                  = $request->step_4_thermostat_desc;
				$model->step_4_absolute_humidity_1	                  = $request->step_4_absolute_humidity_1;
				$model->step_4_absolute_humidity_2	                  = $request->step_4_absolute_humidity_2;
				$model->step_4_thermostat_26S2	                  = $request->step_4_thermostat_26S2;
				$model->step_4_thermostat_26S2_desc	                  = $request->step_4_thermostat_26S2_desc;
				$model->step_4_total_operation_time_1	                  = $request->step_4_total_operation_time_1;
				$model->step_4_total_operation_time_2	                  = $request->step_4_total_operation_time_2;
				$model->step_4_ozone_fault	                  = $request->step_4_ozone_fault;
				$model->step_4_ozone_fault_desc	                  = $request->step_4_ozone_fault_desc;
				$model->step_4_software_plc_1	                  = $request->step_4_software_plc_1;
				$model->step_4_software_plc_2	                  = $request->step_4_software_plc_2;
				$model->step_4_noted_all	                  = $request->step_4_noted_all;
				$model->step_4_noted_all_desc	                  = $request->step_4_noted_all_desc;
				$model->step_4_regeneration_blower_failure	                  = $request->step_4_regeneration_blower_failure;
				$model->step_4_open	                  = $request->step_4_open;
				$model->step_4_open_desc	                  = $request->step_4_open_desc;
				$model->step_4_heating_time_in_dryer_1_dan_dryer_2	                  = $request->step_4_heating_time_in_dryer_1_dan_dryer_2;
				$model->step_4_close	                  = $request->step_4_close;
				$model->step_4_close_desc	                  = $request->step_4_close_desc;
				$model->step_4_thermostat_dryer_1_dan_dryer_2	                  = $request->step_4_thermostat_dryer_1_dan_dryer_2;
				$model->step_4_seal_check_valve_injection	                  = $request->step_4_seal_check_valve_injection;
				$model->step_4_seal_check_valve_injection_desc	                  = $request->step_4_seal_check_valve_injection_desc;
				$model->step_4_ozone_mixing	                  = $request->step_4_ozone_mixing;
				$model->step_4_cooling_water	                  = $request->step_4_cooling_water;
				$model->step_4_ozone_cabinet_door	                  = $request->step_4_ozone_cabinet_door;
				$model->step_5_water_inrush_in_ozone_generation	                  = $request->step_5_water_inrush_in_ozone_generation;
				$model->step_4_air_too_hot	                  = $request->step_4_air_too_hot;
				$model->step_5_ozone_mixing	                  = $request->step_5_ozone_mixing;
				$model->step_4_mains_power_supply_phase_failure	                  = $request->step_4_mains_power_supply_phase_failure;
				$model->step_5_cooling_water_temp	                  = $request->step_5_cooling_water_temp;
				$model->step_4_water_inrush_in_ozone_generation	                  = $request->step_4_water_inrush_in_ozone_generation;
				$model->step_4_booster_pump_failure	                  = $request->step_4_booster_pump_failure;
				$model->step_5_trafo_high_voltage	                  = $request->step_5_trafo_high_voltage;
				$model->step_4_ozone_generation	                  = $request->step_4_ozone_generation;
				$model->step_5_tube_generator	                  = $request->step_5_tube_generator;
				$model->step_4_ozone_gas_warning	                  = $request->step_4_ozone_gas_warning;
				$model->step_5_filter_cabinet_fan	                  = $request->step_5_filter_cabinet_fan;
				$model->step_5_filter_cooling_water	                  = $request->step_5_filter_cooling_water;
				$model->step_5_seal_check_valve	                  = $request->step_5_seal_check_valve;
				$model->step_6_recommendation	                  = $request->step_6_recommendation;
                $model->file	                  = $fileName;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->save();

                return redirect()->back()->with('success', 'data berhasil dirubah');
            }
            
		}else{
			return redirect()->back()->with('info', 'file lebih dari 2 MB');
		}
        }else{
            $valid = $this->validate($request, [
                'subject'                                       => 'required|max:255',
                'customer_by'                                   => 'required|max:255',
                'model'                                         => 'required|max:255', // id_product
                'serial_number'                                 => 'required|max:255',
                'date'                                          => 'required|date_format:Y-m-d',
                'year'                                          => 'required|date_format:m/Y',
                'running_hours'                                 => 'required|numeric|min:1',
                'lock'                                          => 'required|max:2',
                'step_1_dryer_1_remaining_capacity_noted'       => 'max:255',
                'step_1_dryer_2_remaining_capacity_noted'       => 'max:255',
                'step_1_dryer_1_dew_point_noted'                => 'max:255',
                'step_1_dryer_2_dew_point_noted'                => 'max:255',
                'step_1_dryer_1_gas_temperature_noted'          => 'max:255',
                'step_1_dryer_2_gas_temperature_noted'          => 'max:255',
                'step_1_dryer_1_description'                    => 'max:255',
                'step_1_dryer_2_description'                    => 'max:255',
                'step_2_dryer_1_remaining_capacity_noted'       => 'max:255',
                'step_2_dryer_2_remaining_capacity_noted'       => 'max:255',
                'step_2_dryer_1_dew_point_noted'                => 'max:255',
                'step_2_dryer_2_dew_point_noted'                => 'max:255',
                'step_2_dryer_1_gas_temperature_noted'          => 'max:255',
                'step_2_dryer_2_gas_temperature_noted'          => 'max:255',
                'step_2_dryer_1_description'                    => 'max:255',
                'step_2_dryer_2_description'                    => 'max:255',
                'step_3_dryer_1_heating_up_time_noted'          => 'max:255',
                'step_3_dryer_2_heating_up_time_noted'          => 'max:255',
                'step_3_dryer_1_heating_on_off_noted'           => 'max:255',
                'step_3_dryer_2_heating_on_off_noted'           => 'max:255',
                'step_3_dryer_1_heating_time_noted'             => 'max:255',
                'step_3_dryer_2_heating_time_noted'             => 'max:255',
                'step_3_dryer_1_total_time_noted'               => 'max:255',
                'step_3_dryer_2_total_time_noted'               => 'max:255',
                'step_3_dryer_1_description'                    => 'max:255',
                'step_3_dryer_2_description'                    => 'max:255',
                'step_4_glass_breakage_relay'                   => 'max:1',
                'step_4_glass_breakage_relay_desc'              => 'max:255',
                'step_4_high_voltage_cable'                     => 'max:1',
                'step_4_high_voltage_cable_desc'                => 'max:255',
                'step_4_relay'                                  => 'max:1',
                'step_4_relay_desc'                             => 'max:255',
                'step_4_noise_filter'                           => 'max:1',
                'step_4_noise_filter_desc'                      => 'max:255',
                'step_4_solenoid_valve'                         => 'max:1',
                'step_4_solenoid_valve_desc'                    => 'max:255',
                'step_4_solenoid_valve_operation'               => 'max:1',
                'step_4_solenoid_valve_operation_desc'          => 'max:255',
                'step_4_thermostat'                             => 'max:1',
                'step_4_thermostat_desc'                        => 'max:255',
                'step_4_thermostat_26S2'                        => 'max:1',
                'step_4_thermostat_26S2_desc'                   => 'max:255',
                'step_4_ozone_fault'                            => 'max:1',
                'step_4_ozone_fault_desc'                       => 'max:255',
                'step_4_noted_all'                              => 'max:1',
                'step_4_noted_all_desc'                         => 'max:255',
                'step_4_regeneration_blower_failure'            => 'max:255',
                'step_4_open'                                   => 'max:1',
                'step_4_open_desc'                              => 'max:255',
                'step_4_heating_time_in_dryer_1_dan_dryer_2'    => 'max:255',
                'step_4_close'                                  => 'max:1',
                'step_4_close_desc'                             => 'max:255',
                'step_4_thermostat_dryer_1_dan_dryer_2'         => 'max:255',
                'step_4_seal_check_valve_injection'             => 'max:1',
                'step_4_seal_check_valve_injection_desc'        => 'max:255',
                'step_4_ozone_mixing'                           => 'max:255',
                'step_4_cooling_water'                          => 'max:255',
                'step_4_ozone_cabinet_door'                     => 'max:255',
                'step_5_water_inrush_in_ozone_generation'       => 'max:255',
                'step_4_air_too_hot'       => 'max:255',
                'step_5_ozone_mixing'       => 'max:255',
                'step_4_mains_power_supply_phase_failure'       => 'max:255',
                'step_5_cooling_water_temp'       => 'max:255',
                'step_4_water_inrush_in_ozone_generation'       => 'max:255',
                'step_4_booster_pump_failure'       => 'max:255',
                'step_5_trafo_high_voltage'       => 'max:255',
                'step_4_ozone_generation'       => 'max:255',
                'step_5_tube_generator'       => 'max:255',
                'step_4_ozone_gas_warning'       => 'max:255',
                'step_5_filter_cabinet_fan'       => 'max:255',
                'step_5_filter_cooling_water'       => 'max:255',
                'step_5_seal_check_valve'       => 'max:255'
            ]);

            $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }



				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->year                      = $request->year;
				$model->date	                  = $request->date;
				$model->lock	                  = $request->lock;
				$model->step_1_dryer_1_remaining_capacity_before	                  = $request->step_1_dryer_1_remaining_capacity_before;
				$model->step_1_dryer_1_remaining_capacity_after	                  = $request->step_1_dryer_1_remaining_capacity_after;
				$model->step_1_dryer_1_remaining_capacity_noted	                  = $request->step_1_dryer_1_remaining_capacity_noted;
				$model->step_1_dryer_2_remaining_capacity_before	                  = $request->step_1_dryer_2_remaining_capacity_before;
				$model->step_1_dryer_2_remaining_capacity_after	                  = $request->step_1_dryer_2_remaining_capacity_after;
				$model->step_1_dryer_2_remaining_capacity_noted	                  = $request->step_1_dryer_2_remaining_capacity_noted;
				$model->step_1_dryer_1_dew_point_before	                  = $request->step_1_dryer_1_dew_point_before;
				$model->step_1_dryer_1_dew_point_after	                  = $request->step_1_dryer_1_dew_point_after;
				$model->step_1_dryer_1_dew_point_noted	                  = $request->step_1_dryer_1_dew_point_noted;
				$model->step_1_dryer_2_dew_point_before	                  = $request->step_1_dryer_2_dew_point_before;
				$model->step_1_dryer_2_dew_point_after	                  = $request->step_1_dryer_2_dew_point_after;
				$model->step_1_dryer_2_dew_point_noted	                  = $request->step_1_dryer_2_dew_point_noted;
				$model->step_1_dryer_1_gas_temperature_before	                  = $request->step_1_dryer_1_gas_temperature_before;
				$model->step_1_dryer_1_gas_temperature_after	                  = $request->step_1_dryer_1_gas_temperature_after;
				$model->step_1_dryer_1_gas_temperature_noted	                  = $request->step_1_dryer_1_gas_temperature_noted;
				$model->step_1_dryer_2_gas_temperature_before	                  = $request->step_1_dryer_2_gas_temperature_before;
				$model->step_1_dryer_2_gas_temperature_after	                  = $request->step_1_dryer_2_gas_temperature_after;
				$model->step_1_dryer_2_gas_temperature_noted	                  = $request->step_1_dryer_2_gas_temperature_noted;
				$model->step_1_dryer_1_description	                  = $request->step_1_dryer_1_description;
				$model->step_1_dryer_2_description	                  = $request->step_1_dryer_2_description;
				$model->step_2_dryer_1_remaining_capacity_before	                  = $request->step_2_dryer_1_remaining_capacity_before;
				$model->step_2_dryer_1_remaining_capacity_after	                  = $request->step_2_dryer_1_remaining_capacity_after;
				$model->step_2_dryer_1_remaining_capacity_noted	                  = $request->step_2_dryer_1_remaining_capacity_noted;
				$model->step_2_dryer_2_remaining_capacity_before	                  = $request->step_2_dryer_2_remaining_capacity_before;
				$model->step_2_dryer_2_remaining_capacity_after	                  = $request->step_2_dryer_2_remaining_capacity_after;
				$model->step_2_dryer_2_remaining_capacity_noted	                  = $request->step_2_dryer_2_remaining_capacity_noted;
				$model->step_2_dryer_1_dew_point_before	                  = $request->step_2_dryer_1_dew_point_before;
				$model->step_2_dryer_1_dew_point_after	                  = $request->step_2_dryer_1_dew_point_after;
				$model->step_2_dryer_1_dew_point_noted	                  = $request->step_2_dryer_1_dew_point_noted;
				$model->step_2_dryer_2_dew_point_before	                  = $request->step_2_dryer_2_dew_point_before;
				$model->step_2_dryer_2_dew_point_after	                  = $request->step_2_dryer_2_dew_point_after;
				$model->step_2_dryer_2_dew_point_noted	                  = $request->step_2_dryer_2_dew_point_noted;
				$model->step_2_dryer_1_gas_temperature_before	                  = $request->step_2_dryer_1_gas_temperature_before;
				$model->step_2_dryer_2_gas_temperature_after	                  = $request->step_2_dryer_2_gas_temperature_after;
				$model->step_2_dryer_2_gas_temperature_noted	                  = $request->step_2_dryer_2_gas_temperature_noted;
				$model->step_2_dryer_1_description	                  = $request->step_2_dryer_1_description;
				$model->step_2_dryer_2_description	                  = $request->step_2_dryer_2_description;
				$model->step_3_flow_blower_1	                  = $request->step_3_flow_blower_1;
				$model->step_3_flow_blower_2	                  = $request->step_3_flow_blower_2;
				$model->step_3_regeneration_blower_phase_r	                  = $request->step_3_regeneration_blower_phase_r;
				$model->step_3_regeneration_blower_phase_s	                  = $request->step_3_regeneration_blower_phase_s;
				$model->step_3_regeneration_blower_phase_t	                  = $request->step_3_regeneration_blower_phase_t;
				$model->step_3_dryer_heating_1_1	                  = $request->step_3_dryer_heating_1_1;
				$model->step_3_dryer_heating_1_2	                  = $request->step_3_dryer_heating_1_2;
				$model->step_3_dryer_heating_1_phase_r	                  = $request->step_3_dryer_heating_1_phase_r;
				$model->step_3_dryer_heating_1_phase_s	                  = $request->step_3_dryer_heating_1_phase_s;
				$model->step_3_dryer_heating_1_phase_t	                  = $request->step_3_dryer_heating_1_phase_t;
				$model->step_3_dryer_heating_2_1	                  = $request->step_3_dryer_heating_2_1;
				$model->step_3_dryer_heating_2_2	                  = $request->step_3_dryer_heating_2_2;
				$model->step_3_heater_dryer_2_phase_r	                  = $request->step_3_heater_dryer_2_phase_r;
				$model->step_3_heater_dryer_2_phase_s	                  = $request->step_3_heater_dryer_2_phase_s;
				$model->step_3_heater_dryer_2_phase_t	                  = $request->step_3_heater_dryer_2_phase_t;
				$model->step_3_dryer_regeneration_1_1	                  = $request->step_3_dryer_regeneration_1_1;
				$model->step_3_dryer_regeneration_1_2	                  = $request->step_3_dryer_regeneration_1_2;
				$model->step_3_dryer_regeneration_2_1	                  = $request->step_3_dryer_regeneration_2_1;
				$model->step_3_dryer_regeneration_2_2	                  = $request->step_3_dryer_regeneration_2_2;
				$model->step_3_dryer_1_heating_up_time_before	                  = $request->step_3_dryer_1_heating_up_time_before;
				$model->step_3_dryer_1_heating_up_time_after	                  = $request->step_3_dryer_1_heating_up_time_after;
				$model->step_3_dryer_1_heating_up_time_noted	                  = $request->step_3_dryer_1_heating_up_time_noted;
				$model->step_3_dryer_2_heating_up_time_before	                  = $request->step_3_dryer_2_heating_up_time_before;
				$model->step_3_dryer_2_heating_up_time_after	                  = $request->step_3_dryer_2_heating_up_time_after;
				$model->step_3_dryer_2_heating_up_time_noted	                  = $request->step_3_dryer_2_heating_up_time_noted;
				$model->step_3_dryer_1_heating_on_off_before	                  = $request->step_3_dryer_1_heating_on_off_before;
				$model->step_3_dryer_1_heating_on_off_after	                  = $request->step_3_dryer_1_heating_on_off_after;
				$model->step_3_dryer_1_heating_on_off_noted	                  = $request->step_3_dryer_1_heating_on_off_noted;
				$model->step_3_dryer_2_heating_on_off_before	                  = $request->step_3_dryer_2_heating_on_off_before;
				$model->step_3_dryer_2_heating_on_off_after	                  = $request->step_3_dryer_2_heating_on_off_after;
				$model->step_3_dryer_2_heating_on_off_noted	                  = $request->step_3_dryer_2_heating_on_off_noted;
				$model->step_3_dryer_1_heating_time_before	                  = $request->step_3_dryer_1_heating_time_before;
				$model->step_3_dryer_1_heating_time_after	                  = $request->step_3_dryer_1_heating_time_after;
				$model->step_3_dryer_1_heating_time_noted	                  = $request->step_3_dryer_1_heating_time_noted;
				$model->step_3_dryer_2_heating_time_before	                  = $request->step_3_dryer_2_heating_time_before;
				$model->step_3_dryer_2_heating_time_after	                  = $request->step_3_dryer_2_heating_time_after;
				$model->step_3_dryer_2_heating_time_noted	                  = $request->step_3_dryer_2_heating_time_noted;
				$model->step_3_dryer_1_description	                  = $request->step_3_dryer_1_description;
				$model->step_3_dryer_2_description	                  = $request->step_3_dryer_2_description;
				$model->step_4_voltage_1	                  = $request->step_4_voltage_1;
				$model->step_4_voltage_2	                  = $request->step_4_voltage_2;
				$model->step_4_current_consumption_1	                  = $request->step_4_current_consumption_1;
				$model->step_4_current_consumption_2	                  = $request->step_4_current_consumption_2;
				$model->step_4_booster_pump_phase_r	                  = $request->step_4_booster_pump_phase_r;
				$model->step_4_booster_pump_phase_s	                  = $request->step_4_booster_pump_phase_s;
				$model->step_4_booster_pump_phase_t	                  = $request->step_4_booster_pump_phase_t;
				$model->step_4_ozone_level_1	                  = $request->step_4_ozone_level_1;
				$model->step_4_ozone_level_2	                  = $request->step_4_ozone_level_2;
				$model->step_4_excess_ozone_1	                  = $request->step_4_excess_ozone_1;
				$model->step_4_excess_ozone_2	                  = $request->step_4_excess_ozone_2;
				$model->step_4_glass_breakage_relay	                  = $request->step_4_glass_breakage_relay;
				$model->step_4_glass_breakage_relay_desc	                  = $request->step_4_glass_breakage_relay_desc;
				$model->step_4_water_flow_1	                  = $request->step_4_water_flow_1;
				$model->step_4_water_flow_2	                  = $request->step_4_water_flow_2;
				$model->step_4_high_voltage_cable	                  = $request->step_4_high_voltage_cable;
				$model->step_4_high_voltage_cable_desc	                  = $request->step_4_high_voltage_cable_desc;
				$model->step_4_flow_cooling_1	                  = $request->step_4_flow_cooling_1;
				$model->step_4_flow_cooling_2	                  = $request->step_4_flow_cooling_2;
				$model->step_4_relay	                  = $request->step_4_relay;
				$model->step_4_relay_desc	                  = $request->step_4_relay_desc;
				$model->step_4_flow_vaccum_1	                  = $request->step_4_flow_vaccum_1;
				$model->step_4_flow_vaccum_2	                  = $request->step_4_flow_vaccum_2;
				$model->step_4_noise_filter	                  = $request->step_4_noise_filter;
				$model->step_4_noise_filter_desc	                  = $request->step_4_noise_filter_desc;
				$model->step_4_injection_pressure_in_1	                  = $request->step_4_injection_pressure_in_1;
				$model->step_4_injection_pressure_in_2	                  = $request->step_4_injection_pressure_in_2;
				$model->step_4_solenoid_valve	                  = $request->step_4_solenoid_valve;
				$model->step_4_solenoid_valve_desc	                  = $request->step_4_solenoid_valve_desc;
				$model->step_4_injection_pressure_out_1	                  = $request->step_4_injection_pressure_out_1;
				$model->step_4_injection_pressure_out_2	                  = $request->step_4_injection_pressure_out_2;
				$model->step_4_solenoid_valve_operation	                  = $request->step_4_solenoid_valve_operation;
				$model->step_4_solenoid_valve_operation_desc	                  = $request->step_4_solenoid_valve_operation_desc;
				$model->step_4_vaccu_in_plc_1	                  = $request->step_4_vaccu_in_plc_1;
				$model->step_4_vaccu_in_plc_2	                  = $request->step_4_vaccu_in_plc_2;
				$model->step_4_thermostat	                  = $request->step_4_thermostat;
				$model->step_4_thermostat_desc	                  = $request->step_4_thermostat_desc;
				$model->step_4_absolute_humidity_1	                  = $request->step_4_absolute_humidity_1;
				$model->step_4_absolute_humidity_2	                  = $request->step_4_absolute_humidity_2;
				$model->step_4_thermostat_26S2	                  = $request->step_4_thermostat_26S2;
				$model->step_4_thermostat_26S2_desc	                  = $request->step_4_thermostat_26S2_desc;
				$model->step_4_total_operation_time_1	                  = $request->step_4_total_operation_time_1;
				$model->step_4_total_operation_time_2	                  = $request->step_4_total_operation_time_2;
				$model->step_4_ozone_fault	                  = $request->step_4_ozone_fault;
				$model->step_4_ozone_fault_desc	                  = $request->step_4_ozone_fault_desc;
				$model->step_4_software_plc_1	                  = $request->step_4_software_plc_1;
				$model->step_4_software_plc_2	                  = $request->step_4_software_plc_2;
				$model->step_4_noted_all	                  = $request->step_4_noted_all;
				$model->step_4_noted_all_desc	                  = $request->step_4_noted_all_desc;
				$model->step_4_regeneration_blower_failure	                  = $request->step_4_regeneration_blower_failure;
				$model->step_4_open	                  = $request->step_4_open;
				$model->step_4_open_desc	                  = $request->step_4_open_desc;
				$model->step_4_heating_time_in_dryer_1_dan_dryer_2	                  = $request->step_4_heating_time_in_dryer_1_dan_dryer_2;
				$model->step_4_close	                  = $request->step_4_close;
				$model->step_4_close_desc	                  = $request->step_4_close_desc;
				$model->step_4_thermostat_dryer_1_dan_dryer_2	                  = $request->step_4_thermostat_dryer_1_dan_dryer_2;
				$model->step_4_seal_check_valve_injection	                  = $request->step_4_seal_check_valve_injection;
				$model->step_4_seal_check_valve_injection_desc	                  = $request->step_4_seal_check_valve_injection_desc;
				$model->step_4_ozone_mixing	                  = $request->step_4_ozone_mixing;
				$model->step_4_cooling_water	                  = $request->step_4_cooling_water;
				$model->step_4_ozone_cabinet_door	                  = $request->step_4_ozone_cabinet_door;
				$model->step_5_water_inrush_in_ozone_generation	                  = $request->step_5_water_inrush_in_ozone_generation;
				$model->step_4_air_too_hot	                  = $request->step_4_air_too_hot;
				$model->step_5_ozone_mixing	                  = $request->step_5_ozone_mixing;
				$model->step_4_mains_power_supply_phase_failure	                  = $request->step_4_mains_power_supply_phase_failure;
				$model->step_5_cooling_water_temp	                  = $request->step_5_cooling_water_temp;
				$model->step_4_water_inrush_in_ozone_generation	                  = $request->step_4_water_inrush_in_ozone_generation;
				$model->step_4_booster_pump_failure	                  = $request->step_4_booster_pump_failure;
				$model->step_5_trafo_high_voltage	                  = $request->step_5_trafo_high_voltage;
				$model->step_4_ozone_generation	                  = $request->step_4_ozone_generation;
				$model->step_5_tube_generator	                  = $request->step_5_tube_generator;
				$model->step_4_ozone_gas_warning	                  = $request->step_4_ozone_gas_warning;
				$model->step_5_filter_cabinet_fan	                  = $request->step_5_filter_cabinet_fan;
				$model->step_5_filter_cooling_water	                  = $request->step_5_filter_cooling_water;
				$model->step_5_seal_check_valve	                  = $request->step_5_seal_check_valve;
				$model->step_6_recommendation	                  = $request->step_6_recommendation;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->save();

                return redirect()->back()->with('success', 'data berhasil dirubah');
        }
    } 

    


    
	public function createEmergency($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);

		$produk = Produk::orderBy('id','DESC')->get();


		if($data){
			return view('laporan.emergency_create', ['data' => $data , 'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}

    }



    
	public function storeEmergency(Request $request,$id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = new ScheduleEmergency;

        $valid = $this->validate($request, [
            'subject'                                       => 'required|max:255',
            'customer_by'                                   => 'required|max:255',
            'model'                                         => 'required|max:255', // id_product
            'serial_number'                                 => 'required|max:255',
            'date'                                          => 'required|date_format:Y-m-d',
            'year'                                          => 'required|date_format:m/Y',
            'running_hours'                                 => 'required|numeric|min:1',
            
            'file'                                          => 'required|mimes:jpg,jpeg,png,pdf'
        ]);

        $file = $request->file('file');
        $extension  = $request->file('file')->getClientOriginalExtension();

		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = str_replace(' ', '-', 'laporan-emergency-'.$request->subject).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }


				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->year                      = $request->year;
				$model->date	                  = $request->date;
				$model->line	                  = $request->line;
				$model->issue	                  = $request->issue;
				$model->action	                  = $request->action;
				$model->recommendation            = $request->recommendation;
			   
                $model->file	                  = $fileName;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->status               = 'selesai';
                $data->report_type          = 'emergency';
                $data->id_emergency         = $model->id;
                $data->save();

                return redirect('/jadwal-proses')->with('success', 'data berhasil dimasukan');
            }
            
		}else{
			return redirect()->back()->with('info', 'file lebih dari 2 MB');
		}

    }

    
    
	public function detailEmergency($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','emergency')->find($code);
		if($data){
			return view('laporan.emergency_detail', ['data' => $data]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }



	public function editEmergency($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','emergency')->find($code);
		if($data){
            $produk = Produk::orderBy('id','DESC')->get();    
			return view('laporan.emergency_update', ['data' => $data ,'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }
    
	public function destroyEmergency($id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::find($code);
		if($data){
            $model = ScheduleEmergency::find($codeUv);
            $destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = $model->file;
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
            $model->delete();

            $data->id_emergency           = 0;
            $data->report_type     = "";
            $data->reminder_service= 0;
            $data->status          = "proses";
            $data->save();

			return redirect('/jadwal')->with('success', 'laporan berhasil di hapus');
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }


	public function updateEmergency(Request $request,$id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = ScheduleEmergency::find($codeUv);


        
        $file = $request->file('file');
        if($file){
            $valid = $this->validate($request, [
                'subject'                                       => 'required|max:255',
                'customer_by'                                   => 'required|max:255',
                'model'                                         => 'required|max:255', // id_product
                'serial_number'                                 => 'required|max:255',
                'date'                                          => 'required|date_format:Y-m-d',
                'year'                                          => 'required|date_format:m/Y',
                'running_hours'                                 => 'required|numeric|min:1',
                
                'file'                                          => 'required|mimes:jpg,jpeg,png,pdf'
            ]);

            $extension  = $request->file('file')->getClientOriginalExtension();

		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = str_replace(' ', '-', 'laporan-emergency-'.$request->subject).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                File::delete($destinationPath .$model->file);

                $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }

				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->year                      = $request->year;
				$model->date	                  = $request->date;
				$model->line	                  = $request->line;
				$model->issue	                  = $request->issue;
				$model->action	                  = $request->action;
				$model->recommendation            = $request->recommendation; 
                $model->file	                  = $fileName;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->save();

                return redirect()->back()->with('success', 'data berhasil dirubah');
            }
            
		}else{
			return redirect()->back()->with('info', 'file lebih dari 2 MB');
		}
        }else{
            $valid = $this->validate($request, [
                'subject'                                       => 'required|max:255',
                'customer_by'                                   => 'required|max:255',
                'model'                                         => 'required|max:255', // id_product
                'serial_number'                                 => 'required|max:255',
                'date'                                          => 'required|date_format:Y-m-d',
                'year'                                          => 'required|date_format:m/Y',
                'running_hours'                                 => 'required|numeric|min:1',
            ]);

            $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }

				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->year                      = $request->year;
				$model->date	                  = $request->date;
				$model->line	                  = $request->line;
				$model->issue	                  = $request->issue;
				$model->action	                  = $request->action;
				$model->recommendation            = $request->recommendation; 
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->save();

                return redirect()->back()->with('success', 'data berhasil dirubah');
        } 

    }



    
	public function createLog($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);

		$produk = Produk::orderBy('id','DESC')->get();


		if($data){
			return view('laporan.log_create', ['data' => $data , 'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}

    }

    
	public function storeLog(Request $request,$id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = new ScheduleLog;

        $valid = $this->validate($request, [
            'subject'                                       => 'required|max:255',
            'customer_by'                                   => 'required|max:255',
            'model'                                         => 'required|max:255', // id_product
            'serial_number'                                 => 'required|max:255',
            'date'                                          => 'required|date_format:Y-m-d',
            'year'                                          => 'required|date_format:m/Y',
            'running_hours'                                 => 'required|numeric|min:1',
            '5_dew_point_between_adsorber_and_generators'   => 'max:255',
            '5_dew_point_at_unit_output'                    => 'max:255',
            '5_ozone_level'                                 => 'max:255',
            '6_dryer_2_input'   => 'max:255',
            '6_dryer_2_output'                    => 'max:255',
            '6_gas_temperatur_monitoring_input'                                 => 'max:255',
            '6_gas_temperatur_monitoring_output'                                 => 'max:255',
            
            'file'                                          => 'required|mimes:jpg,jpeg,png,pdf'
        ]);

        $file = $request->file('file');
        $extension  = $request->file('file')->getClientOriginalExtension();

		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = str_replace(' ', '-', 'laporan-log-'.$request->subject).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                $id_user          = Auth::user()->id;
                if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                    $id_user      = $request->id_user;
                }


				$model->id_user                   = $id_user;
				$model->subject	                  = $request->subject;
				$model->customer_by	              = $request->customer_by;
                $model->id_product	              = $request->model;
				$model->serial_number             = $request->serial_number;
				$model->running_hours             = $request->running_hours;
				$model->year                      = $request->year;
				$model->date	                  = $request->date;
                $model->dryer_1_heating_up        = $request->dryer_1_heating_up;
                
                
				$model->dryer_1_heating        = $request->dryer_1_heating;
				$model->dryer_1_heating_16s3        = $request->dryer_1_heating_16s3;
				$model->dryer_1_regeneration_time        = $request->dryer_1_regeneration_time;
				$model->dryer_1_heater_current_1        = $request->dryer_1_heater_current_1;
				$model->dryer_1_heater_current_2        = $request->dryer_1_heater_current_2;
				$model->dryer_1_heater_current_3        = $request->dryer_1_heater_current_3;
				$model->dryer_1_fan_blower_1        = $request->dryer_1_fan_blower_1;
				$model->dryer_1_fan_blower_2        = $request->dryer_1_fan_blower_2;
				$model->dryer_1_fan_blower_3        = $request->dryer_1_fan_blower_3;
				$model->dryer_2_heating_up        = $request->dryer_2_heating_up;
				$model->dryer_2_heating        = $request->dryer_2_heating;
				$model->dryer_2_heating_16s3        = $request->dryer_2_heating_16s3;
				$model->dryer_2_regeneration_time        = $request->dryer_2_regeneration_time;
				$model->dryer_2_heater_current_1        = $request->dryer_2_heater_current_1;
				$model->dryer_2_heater_current_2        = $request->dryer_2_heater_current_2;
				$model->dryer_2_heater_current_3        = $request->dryer_2_heater_current_3;
				$model->maximum_absolut_humidity_2        = $request->maximum_absolut_humidity_2;
				$model->air_flow_3                      = $request->air_flow_3;
				$model->regeneration_blower_4         = $request->regeneration_blower_4;
				$model->dryer_1_heating_time_4        = $request->dryer_1_heating_time_4;
				$model->dryer_2_heating_time_4        = $request->dryer_2_heating_time_4;
				$model->air_too_hot_4        = $request->air_too_hot_4;
				$model->mixing_4        = $request->mixing_4;
				$model->water_inrush_4        = $request->water_inrush_4;
				$model->ozone_generation_cooling_water_4        = $request->ozone_generation_cooling_water_4;
				$model->dew_point_between_adsorber_and_generators_5        = $request->dew_point_between_adsorber_and_generators_5;
				$model->dew_point_at_unit_output_5        = $request->dew_point_at_unit_output_5;
				$model->ozone_level_5        = $request->ozone_level_5;
				$model->check_supply_main_6        = $request->check_supply_main_6;
				$model->check_operating_6        = $request->check_operating_6;
				$model->check_the_function_6        = $request->check_the_function_6;
				$model->dryer_1_input_6         = $request->dryer_1_input_6;
				$model->dryer_1_output_6         = $request->dryer_1_output_6;
				$model->dryer_2_input_6         = $request->dryer_2_input_6;
				$model->dryer_2_output_6         = $request->dryer_2_output_6;
				$model->gas_temperatur_monitoring_input_6         = $request->gas_temperatur_monitoring_input_6;
				$model->gas_temperatur_monitoring_output_6         = $request->gas_temperatur_monitoring_output_6;
				$model->cooling_water_monitoring_input_6         = $request->cooling_water_monitoring_input_6;
				$model->cooling_water_monitoring_output_6         = $request->cooling_water_monitoring_output_6;
				$model->voltage_1_7         = $request->voltage_1_7;
				$model->voltage_2_7         = $request->voltage_2_7;
				$model->voltage_3_7         = $request->voltage_3_7;
				$model->voltage_4_7         = $request->voltage_4_7;
                $model->cooling_water_flow_1_7         = $request->cooling_water_flow_1_7;
                $model->cooling_water_flow_2_7         = $request->cooling_water_flow_2_7;
                $model->cooling_water_flow_3_7         = $request->cooling_water_flow_3_7;
                $model->cooling_water_flow_4_7         = $request->cooling_water_flow_4_7;
				$model->current_consumption_1_7         = $request->current_consumption_1_7;
				$model->current_consumption_2_7         = $request->current_consumption_2_7;
				$model->current_consumption_3_7         = $request->current_consumption_3_7;
				$model->current_consumption_4_7         = $request->current_consumption_4_7;
				$model->gas_flow_1_7         = $request->gas_flow_1_7;
				$model->gas_flow_2_7         = $request->gas_flow_2_7;
				$model->gas_flow_3_7         = $request->gas_flow_3_7;
				$model->gas_flow_4_7         = $request->gas_flow_4_7;
				$model->ozone_level_1_7         = $request->ozone_level_1_7;
				$model->ozone_level_2_7         = $request->ozone_level_2_7;
				$model->ozone_level_3_7         = $request->ozone_level_3_7;
				$model->ozone_level_4_7         = $request->ozone_level_4_7;
			   
				$model->injection_pressure_in_1_7         = $request->injection_pressure_in_1_7;
				$model->injection_pressure_in_2_7         = $request->injection_pressure_in_2_7;
				$model->injection_pressure_in_3_7         = $request->injection_pressure_in_3_7;
                $model->injection_pressure_in_4_7         = $request->injection_pressure_in_4_7;
                
                $model->injection_pressure_out_1_7         = $request->injection_pressure_out_1_7;
                $model->injection_pressure_out_2_7         = $request->injection_pressure_out_2_7;
                $model->injection_pressure_out_3_7         = $request->injection_pressure_out_3_7;
                $model->injection_pressure_out_4_7         = $request->injection_pressure_out_4_7;
                
                $model->water_flow_rate_1_7         = $request->water_flow_rate_1_7;
                $model->water_flow_rate_2_7         = $request->water_flow_rate_2_7;
                $model->water_flow_rate_3_7         = $request->water_flow_rate_3_7;
                $model->water_flow_rate_4_7         = $request->water_flow_rate_4_7;

                $model->excess_ozone_in_water_1_7         = $request->excess_ozone_in_water_1_7;
                $model->excess_ozone_in_water_2_7         = $request->excess_ozone_in_water_2_7;
                $model->excess_ozone_in_water_3_7         = $request->excess_ozone_in_water_3_7;
                $model->excess_ozone_in_water_4_7         = $request->excess_ozone_in_water_4_7;

                $model->running_time_1_7         = $request->running_time_1_7;
                $model->running_time_2_7         = $request->running_time_2_7;
                $model->running_time_3_7         = $request->running_time_3_7;
                $model->running_time_4_7         = $request->running_time_4_7;

                
                $model->noted         = $request->noted;

                $model->file	                  = $fileName;
                $model->save();

                if($request->reminder > 0){
                    $data->reminder_service = $request->reminder;
                }
                $data->status               = 'selesai';
                $data->report_type          = 'log';
                $data->id_log         = $model->id;
                $data->save();

                return redirect('/jadwal-proses')->with('success', 'data berhasil dimasukan');
            }
            
		}else{
			return redirect()->back()->with('info', 'file lebih dari 2 MB');
		}

    }


    
	public function detailLog($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log')->find($code);
		if($data){
			return view('laporan.log_detail', ['data' => $data]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }

    
    
	public function editLog($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log')->find($code);
		if($data){
            $produk = Produk::orderBy('id','DESC')->get();    
			return view('laporan.log_update', ['data' => $data ,'produk' => $produk]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }
     

    public function updateLog(Request $request,$id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		
        $model = ScheduleLog::find($codeUv);
        $file = $request->file('file');
        if($file){

            $valid = $this->validate($request, [
                'subject'                                       => 'required|max:255',
                'customer_by'                                   => 'required|max:255',
                'model'                                         => 'required|max:255', // id_product
                'serial_number'                                 => 'required|max:255',
                'date'                                          => 'required|date_format:Y-m-d',
                'year'                                          => 'required|date_format:m/Y',
                'running_hours'                                 => 'required|numeric|min:1',
                '5_dew_point_between_adsorber_and_generators'   => 'max:255',
                '5_dew_point_at_unit_output'                    => 'max:255',
                '5_ozone_level'                                 => 'max:255',
                '6_dryer_2_input'   => 'max:255',
                '6_dryer_2_output'                    => 'max:255',
                '6_gas_temperatur_monitoring_input'                                 => 'max:255',
                '6_gas_temperatur_monitoring_output'                                 => 'max:255',
                
                'file'                                          => 'required|mimes:jpg,jpeg,png,pdf'
            ]);
    
            $file = $request->file('file');
            $extension  = $request->file('file')->getClientOriginalExtension();
    
            if ($file->getSize() <= 2000000){
                $destinationPath = public_path().'/public/laporan/'; // upload path
                $fileName   = str_replace(' ', '-', 'laporan-log-'.$request->subject).'-'.time().'.'.$extension; // renameing image
                if(file_exists($destinationPath.$fileName)){
                    File::delete($destinationPath .$fileName);
                }
                 $upload_success     = $file->move($destinationPath, $fileName);
                if(!$upload_success){
                    return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
                }else{
                    $id_user          = Auth::user()->id;
                    if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                        $id_user      = $request->id_user;
                    }
    
                    File::delete($destinationPath .$model->file);
    
                    $model->id_user                   = $id_user;
                    $model->subject	                  = $request->subject;
                    $model->customer_by	              = $request->customer_by;
                    $model->id_product	              = $request->model;
                    $model->serial_number             = $request->serial_number;
                    $model->running_hours             = $request->running_hours;
                    $model->year                      = $request->year;
                    $model->date	                  = $request->date;
                    $model->dryer_1_heating_up        = $request->dryer_1_heating_up;
                    
                    
                    $model->dryer_1_heating        = $request->dryer_1_heating;
                    $model->dryer_1_heating_16s3        = $request->dryer_1_heating_16s3;
                    $model->dryer_1_regeneration_time        = $request->dryer_1_regeneration_time;
                    $model->dryer_1_heater_current_1        = $request->dryer_1_heater_current_1;
                    $model->dryer_1_heater_current_2        = $request->dryer_1_heater_current_2;
                    $model->dryer_1_heater_current_3        = $request->dryer_1_heater_current_3;
                    $model->dryer_1_fan_blower_1        = $request->dryer_1_fan_blower_1;
                    $model->dryer_1_fan_blower_2        = $request->dryer_1_fan_blower_2;
                    $model->dryer_1_fan_blower_3        = $request->dryer_1_fan_blower_3;
                    $model->dryer_2_heating_up        = $request->dryer_2_heating_up;
                    $model->dryer_2_heating        = $request->dryer_2_heating;
                    $model->dryer_2_heating_16s3        = $request->dryer_2_heating_16s3;
                    $model->dryer_2_regeneration_time        = $request->dryer_2_regeneration_time;
                    $model->dryer_2_heater_current_1        = $request->dryer_2_heater_current_1;
                    $model->dryer_2_heater_current_2        = $request->dryer_2_heater_current_2;
                    $model->dryer_2_heater_current_3        = $request->dryer_2_heater_current_3;
                    $model->maximum_absolut_humidity_2        = $request->maximum_absolut_humidity_2;
                    $model->air_flow_3                      = $request->air_flow_3;
                    $model->regeneration_blower_4         = $request->regeneration_blower_4;
                    $model->dryer_1_heating_time_4        = $request->dryer_1_heating_time_4;
                    $model->dryer_2_heating_time_4        = $request->dryer_2_heating_time_4;
                    $model->air_too_hot_4        = $request->air_too_hot_4;
                    $model->mixing_4        = $request->mixing_4;
                    $model->water_inrush_4        = $request->water_inrush_4;
                    $model->ozone_generation_cooling_water_4        = $request->ozone_generation_cooling_water_4;
                    $model->dew_point_between_adsorber_and_generators_5        = $request->dew_point_between_adsorber_and_generators_5;
                    $model->dew_point_at_unit_output_5        = $request->dew_point_at_unit_output_5;
                    $model->ozone_level_5        = $request->ozone_level_5;
                    $model->check_supply_main_6        = $request->check_supply_main_6;
                    $model->check_operating_6        = $request->check_operating_6;
                    $model->check_the_function_6        = $request->check_the_function_6;
                    $model->dryer_1_input_6         = $request->dryer_1_input_6;
                    $model->dryer_1_output_6         = $request->dryer_1_output_6;
                    $model->dryer_2_input_6         = $request->dryer_2_input_6;
                    $model->dryer_2_output_6         = $request->dryer_2_output_6;
                    $model->gas_temperatur_monitoring_input_6         = $request->gas_temperatur_monitoring_input_6;
                    $model->gas_temperatur_monitoring_output_6         = $request->gas_temperatur_monitoring_output_6;
                    $model->cooling_water_monitoring_input_6         = $request->cooling_water_monitoring_input_6;
                    $model->cooling_water_monitoring_output_6         = $request->cooling_water_monitoring_output_6;
                    $model->voltage_1_7         = $request->voltage_1_7;
                    $model->voltage_2_7         = $request->voltage_2_7;
                    $model->voltage_3_7         = $request->voltage_3_7;
                    $model->voltage_4_7         = $request->voltage_4_7;
                    $model->current_consumption_1_7         = $request->current_consumption_1_7;
                    $model->current_consumption_2_7         = $request->current_consumption_2_7;
                    $model->current_consumption_3_7         = $request->current_consumption_3_7;
                    $model->current_consumption_4_7         = $request->current_consumption_4_7;
                    $model->gas_flow_1_7         = $request->gas_flow_1_7;
                    $model->gas_flow_2_7         = $request->gas_flow_2_7;
                    $model->gas_flow_3_7         = $request->gas_flow_3_7;
                    $model->gas_flow_4_7         = $request->gas_flow_4_7;
                    $model->ozone_level_1_7         = $request->ozone_level_1_7;
                    $model->ozone_level_2_7         = $request->ozone_level_2_7;
                    $model->ozone_level_3_7         = $request->ozone_level_3_7;
                    $model->ozone_level_4_7         = $request->ozone_level_4_7;
                   
                    $model->injection_pressure_in_1_7         = $request->injection_pressure_in_1_7;
                    $model->injection_pressure_in_2_7         = $request->injection_pressure_in_2_7;
                    $model->injection_pressure_in_3_7         = $request->injection_pressure_in_3_7;
                    $model->injection_pressure_in_4_7         = $request->injection_pressure_in_4_7;
                    
                    $model->injection_pressure_out_1_7         = $request->injection_pressure_out_1_7;
                    $model->injection_pressure_out_2_7         = $request->injection_pressure_out_2_7;
                    $model->injection_pressure_out_3_7         = $request->injection_pressure_out_3_7;
                    $model->injection_pressure_out_4_7         = $request->injection_pressure_out_4_7;
                    
                    $model->water_flow_rate_1_7         = $request->water_flow_rate_1_7;
                    $model->water_flow_rate_2_7         = $request->water_flow_rate_2_7;
                    $model->water_flow_rate_3_7         = $request->water_flow_rate_3_7;
                    $model->water_flow_rate_4_7         = $request->water_flow_rate_4_7;
                    $model->cooling_water_flow_1_7         = $request->cooling_water_flow_1_7;
                    $model->cooling_water_flow_2_7         = $request->cooling_water_flow_2_7;
                    $model->cooling_water_flow_3_7         = $request->cooling_water_flow_3_7;
                    $model->cooling_water_flow_4_7         = $request->cooling_water_flow_4_7;
    
                    $model->excess_ozone_in_water_1_7         = $request->excess_ozone_in_water_1_7;
                    $model->excess_ozone_in_water_2_7         = $request->excess_ozone_in_water_2_7;
                    $model->excess_ozone_in_water_3_7         = $request->excess_ozone_in_water_3_7;
                    $model->excess_ozone_in_water_4_7         = $request->excess_ozone_in_water_4_7;
    
                    $model->running_time_1_7         = $request->running_time_1_7;
                    $model->running_time_2_7         = $request->running_time_2_7;
                    $model->running_time_3_7         = $request->running_time_3_7;
                    $model->running_time_4_7         = $request->running_time_4_7;
    
                    
                    $model->noted         = $request->noted;
    
                    $model->file	                  = $fileName;
                    $model->save();
    
                    $data->reminder_service = $request->reminder;
                    $data->save();
    
                    return redirect()->back()->with('success', 'data berhasil dirubah');
                }
                
            }else{
                return redirect()->back()->with('info', 'file lebih dari 2 MB');
            }
        }else{
            $valid = $this->validate($request, [
                'subject'                                       => 'required|max:255',
                'customer_by'                                   => 'required|max:255',
                'model'                                         => 'required|max:255', // id_product
                'serial_number'                                 => 'required|max:255',
                'date'                                          => 'required|date_format:Y-m-d',
                'year'                                          => 'required|date_format:m/Y',
                'running_hours'                                 => 'required|numeric|min:1',
                '5_dew_point_between_adsorber_and_generators'   => 'max:255',
                '5_dew_point_at_unit_output'                    => 'max:255',
                '5_ozone_level'                                 => 'max:255',
                '6_dryer_2_input'   => 'max:255',
                '6_dryer_2_output'                    => 'max:255',
                '6_gas_temperatur_monitoring_input'                                 => 'max:255',
                '6_gas_temperatur_monitoring_output'                                 => 'max:255',
            ]);

                    $id_user          = Auth::user()->id;
                    if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
                        $id_user      = $request->id_user;
                    }
     
                    $model->id_user                   = $id_user;
                    $model->subject	                  = $request->subject;
                    $model->customer_by	              = $request->customer_by;
                    $model->id_product	              = $request->model;
                    $model->serial_number             = $request->serial_number;
                    $model->running_hours             = $request->running_hours;
                    $model->year                      = $request->year;
                    $model->date	                  = $request->date;
                    $model->dryer_1_heating_up        = $request->dryer_1_heating_up;
                    
                    
                    $model->dryer_1_heating        = $request->dryer_1_heating;
                    $model->dryer_1_heating_16s3        = $request->dryer_1_heating_16s3;
                    $model->dryer_1_regeneration_time        = $request->dryer_1_regeneration_time;
                    $model->dryer_1_heater_current_1        = $request->dryer_1_heater_current_1;
                    $model->dryer_1_heater_current_2        = $request->dryer_1_heater_current_2;
                    $model->dryer_1_heater_current_3        = $request->dryer_1_heater_current_3;
                    $model->dryer_1_fan_blower_1        = $request->dryer_1_fan_blower_1;
                    $model->dryer_1_fan_blower_2        = $request->dryer_1_fan_blower_2;
                    $model->dryer_1_fan_blower_3        = $request->dryer_1_fan_blower_3;
                    $model->dryer_2_heating_up        = $request->dryer_2_heating_up;
                    $model->dryer_2_heating        = $request->dryer_2_heating;
                    $model->dryer_2_heating_16s3        = $request->dryer_2_heating_16s3;
                    $model->dryer_2_regeneration_time        = $request->dryer_2_regeneration_time;
                    $model->dryer_2_heater_current_1        = $request->dryer_2_heater_current_1;
                    $model->dryer_2_heater_current_2        = $request->dryer_2_heater_current_2;
                    $model->dryer_2_heater_current_3        = $request->dryer_2_heater_current_3;
                    $model->maximum_absolut_humidity_2        = $request->maximum_absolut_humidity_2;
                    $model->air_flow_3                      = $request->air_flow_3;
                    $model->regeneration_blower_4         = $request->regeneration_blower_4;
                    $model->dryer_1_heating_time_4        = $request->dryer_1_heating_time_4;
                    $model->dryer_2_heating_time_4        = $request->dryer_2_heating_time_4;
                    $model->air_too_hot_4        = $request->air_too_hot_4;
                    $model->mixing_4        = $request->mixing_4;
                    $model->water_inrush_4        = $request->water_inrush_4;
                    $model->ozone_generation_cooling_water_4        = $request->ozone_generation_cooling_water_4;
                    $model->dew_point_between_adsorber_and_generators_5        = $request->dew_point_between_adsorber_and_generators_5;
                    $model->dew_point_at_unit_output_5        = $request->dew_point_at_unit_output_5;
                    $model->ozone_level_5        = $request->ozone_level_5;
                    $model->check_supply_main_6        = $request->check_supply_main_6;
                    $model->check_operating_6        = $request->check_operating_6;
                    $model->check_the_function_6        = $request->check_the_function_6;
                    $model->dryer_1_input_6         = $request->dryer_1_input_6;
                    $model->dryer_1_output_6         = $request->dryer_1_output_6;
                    $model->dryer_2_input_6         = $request->dryer_2_input_6;
                    $model->dryer_2_output_6         = $request->dryer_2_output_6;
                    $model->gas_temperatur_monitoring_input_6         = $request->gas_temperatur_monitoring_input_6;
                    $model->gas_temperatur_monitoring_output_6         = $request->gas_temperatur_monitoring_output_6;
                    $model->cooling_water_monitoring_input_6         = $request->cooling_water_monitoring_input_6;
                    $model->cooling_water_monitoring_output_6         = $request->cooling_water_monitoring_output_6;
                    $model->voltage_1_7         = $request->voltage_1_7;
                    $model->voltage_2_7         = $request->voltage_2_7;
                    $model->voltage_3_7         = $request->voltage_3_7;
                    $model->voltage_4_7         = $request->voltage_4_7;
                    $model->current_consumption_1_7         = $request->current_consumption_1_7;
                    $model->current_consumption_2_7         = $request->current_consumption_2_7;
                    $model->current_consumption_3_7         = $request->current_consumption_3_7;
                    $model->current_consumption_4_7         = $request->current_consumption_4_7;
                    $model->gas_flow_1_7         = $request->gas_flow_1_7;
                    $model->gas_flow_2_7         = $request->gas_flow_2_7;
                    $model->gas_flow_3_7         = $request->gas_flow_3_7;
                    $model->gas_flow_4_7         = $request->gas_flow_4_7;
                    $model->cooling_water_flow_1_7         = $request->cooling_water_flow_1_7;
                    $model->cooling_water_flow_2_7         = $request->cooling_water_flow_2_7;
                    $model->cooling_water_flow_3_7         = $request->cooling_water_flow_3_7;
                    $model->cooling_water_flow_4_7         = $request->cooling_water_flow_4_7;
                    $model->ozone_level_1_7         = $request->ozone_level_1_7;
                    $model->ozone_level_2_7         = $request->ozone_level_2_7;
                    $model->ozone_level_3_7         = $request->ozone_level_3_7;
                    $model->ozone_level_4_7         = $request->ozone_level_4_7;
                   
                    $model->injection_pressure_in_1_7         = $request->injection_pressure_in_1_7;
                    $model->injection_pressure_in_2_7         = $request->injection_pressure_in_2_7;
                    $model->injection_pressure_in_3_7         = $request->injection_pressure_in_3_7;
                    $model->injection_pressure_in_4_7         = $request->injection_pressure_in_4_7;
                    
                    $model->injection_pressure_out_1_7         = $request->injection_pressure_out_1_7;
                    $model->injection_pressure_out_2_7         = $request->injection_pressure_out_2_7;
                    $model->injection_pressure_out_3_7         = $request->injection_pressure_out_3_7;
                    $model->injection_pressure_out_4_7         = $request->injection_pressure_out_4_7;
                    
                    $model->water_flow_rate_1_7         = $request->water_flow_rate_1_7;
                    $model->water_flow_rate_2_7         = $request->water_flow_rate_2_7;
                    $model->water_flow_rate_3_7         = $request->water_flow_rate_3_7;
                    $model->water_flow_rate_4_7         = $request->water_flow_rate_4_7;
    
                    $model->excess_ozone_in_water_1_7         = $request->excess_ozone_in_water_1_7;
                    $model->excess_ozone_in_water_2_7         = $request->excess_ozone_in_water_2_7;
                    $model->excess_ozone_in_water_3_7         = $request->excess_ozone_in_water_3_7;
                    $model->excess_ozone_in_water_4_7         = $request->excess_ozone_in_water_4_7;
    
                    $model->running_time_1_7         = $request->running_time_1_7;
                    $model->running_time_2_7         = $request->running_time_2_7;
                    $model->running_time_3_7         = $request->running_time_3_7;
                    $model->running_time_4_7         = $request->running_time_4_7;
    
                    
                    $model->noted         = $request->noted;
    
                    $model->save();
    
                    $data->reminder_service = $request->reminder;
                    $data->save();
    
                    return redirect()->back()->with('success', 'data berhasil dirubah');
        }
    }


    
	public function destroyLog($id,$idUv)
    {
        $code = Crypt::decrypt($id);
        $codeUv = Crypt::decrypt($idUv);
		$data = Schedule::find($code);
		if($data){
            $model = ScheduleLog::find($codeUv);
            $destinationPath = public_path().'/public/laporan/'; // upload path
			$fileName   = $model->file;
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
            $model->delete();

            $data->id_log           = 0;
            $data->report_type     = "";
            $data->reminder_service= 0;
            $data->status          = "proses";
            $data->save();

			return redirect('/jadwal')->with('success', 'laporan berhasil di hapus');
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }
}