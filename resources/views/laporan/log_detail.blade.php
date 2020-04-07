@extends('layouts.dashboard')
@section('content_dashboard')
<!--  jQuery -->
<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('/miminium/js/plugins/select2.full.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>



<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/select2.min.css') }}"/>



<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>LAPORAN TEST LOG ON START UP</h4>
</div>
 
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    {{$data->log->subject}}
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    {{$data->log->user->name}}<br>({{$data->log->user->indentity_number}})</td>

    
    <td colspan="2" style="text-align: left;">Customer by : <br>
    {{$data->log->customer_by}}
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6">
                Model : <br>
       {{$data->log->produk->model}}
                </select>
            </div>
            <div class="col-md-6">
            SN : <br>
    {{ $data->log->serial_number }}
            </div>
        </div>
    </td>
    <td colspan="4" style="text-align: left;">  
        <div class="col-md-12">
            <div class="col-md-6">
            Running Hours : <br> 
    {{$data->log->running_hours}}
            </div>
            <div class="col-md-6">
            Year : <br>  
    {{$data->log->year}} 
            </div>
        </div>
    </td>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6"> Date     : <br> 
    {{$data->log->date}}  

            </div>
            <div class="col-md-6"> 
            Working hours : <br>  {{$data->date_start.' ~ '.$data->date_finish}}
            </div>
        </div>
            </td>
</tr>
 

<tr>
    <td colspan="10" style="text-align: left;">
        1. Regeneration data
    </td>
</tr>

  
<tr>
    <td colspan="10" style="text-align: left;">
        Dryer 1
    </td>
</tr>


  
<tr>
    <td colspan="4" style="text-align: left;">
    1.1.1 Heating Up (16S1)
    </td>
    <td colspan="2" style="text-align: left;">
    min 
    </td>
    <td colspan="4" style="text-align: left;">

    {{$data->log->dryer_1_heating_up}}  
 

    </td>
</tr>


  
<tr>
    <td colspan="4" style="text-align: left;">
    1.1.2 ON/OFF Heating
    </td>
    <td colspan="2" style="text-align: left;">
    times 
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_1_heating}}  
  
    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">
1.1.3 Heating (16S3)
    </td>
    <td colspan="2" style="text-align: left;">
    min  
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_1_heating_16s3}}  
   
    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">
    1.1.4 Regeneration time
    </td>
    <td colspan="2" style="text-align: left;">
    min  
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_1_regeneration_time}}  
    
    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    Heater  Current
    </td>
    <td colspan="2" style="text-align: left;">
    A  
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_1_heater_current_1}}  
     
    /

    {{$data->log->dryer_1_heater_current_2}}  
      
    /
    {{$data->log->dryer_1_heater_current_3}}   
    

    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    Fan Blower
    </td>
    <td colspan="2" style="text-align: left;">
    A  
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_1_fan_blower_1}}    
    /
    {{$data->log->dryer_1_fan_blower_2}}      
    /
    {{$data->log->dryer_1_fan_blower_3}}     

    </td>
</tr>

  
<tr>
    <td colspan="10" style="text-align: left;">
        Dryer 2
    </td>
</tr>


  
<tr>
    <td colspan="4" style="text-align: left;">
    1.1.1 Heating Up (16S1)
    </td>
    <td colspan="2" style="text-align: left;">
    min 
    </td>
    <td colspan="4" style="text-align: left;"> 
    {{$data->log->dryer_2_heating_up}}  
    </td>
</tr>



  
<tr>
    <td colspan="4" style="text-align: left;">
    1.1.2 ON/OFF Heating
    </td>
    <td colspan="2" style="text-align: left;">
    times 
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_2_heating}}   

    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">
1.1.3 Heating (16S3)
    </td>
    <td colspan="2" style="text-align: left;">
    min  
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_2_heating_16s3}}    

    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">
    1.1.4 Regeneration time
    </td>
    <td colspan="2" style="text-align: left;">
    min  
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_2_regeneration_time}}     
    </td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;">
    Heater  Current
    </td>
    <td colspan="2" style="text-align: left;">
    A  
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->dryer_2_heater_current_1}}      
    /

    {{$data->log->dryer_2_heater_current_2}}     
    /
    {{$data->log->dryer_2_heater_current_3}}      

    </td>
</tr>


  
<tr>
    <td colspan="10" style="text-align: left;">
    2. Dryer Settings
    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    Maximum absolut humidity
    </td>
    <td colspan="2" style="text-align: left;">
    5-60 g/m3  
    </td>
    <td colspan="4" style="text-align: left;">
    {{$data->log->maximum_absolut_humidity_2}}       
    </td>
</tr>



  
<tr>
    <td colspan="10" style="text-align: left;">
    3. Setting Ozone
    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    Air flow 
    </td>
    <td colspan="2" style="text-align: left;">
    50-150 % 
    </td>
    <td colspan="4" style="text-align: left;">
    
    {{$data->log->air_flow_3}}        
    </td>
</tr>

  
<tr>
    <td colspan="10" style="text-align: left;">
    4. Fault message meter
    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    4.1  Regeneration blower 
    </td>
    <td colspan="6" style="text-align: left;">
    
    {{$data->log->regeneration_blower_4}}       

    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    4.2 Dryer 1 heating time
    </td>
    <td colspan="6" style="text-align: left;">
    
    {{$data->log->dryer_1_heating_time_4}}     

    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    4.3 Dryer 2 heating time
    </td>
    <td colspan="6" style="text-align: left;">
    
    {{$data->log->dryer_2_heating_time_4}}      

    </td>
</tr>




<tr>
    <td colspan="4" style="text-align: left;">
    4.4 Air too hot
    </td>
    <td colspan="6" style="text-align: left;">
    
    {{$data->log->air_too_hot_4}}       

    </td>
</tr>




<tr>
    <td colspan="4" style="text-align: left;">
    4.5 Mixing
    </td>
    <td colspan="6" style="text-align: left;">
    
    {{$data->log->mixing_4}}        

    </td>
</tr>





<tr>
    <td colspan="4" style="text-align: left;">
    4.6 Water inrush
    </td>
    <td colspan="6" style="text-align: left;">
    
    {{$data->log->water_inrush_4}}   
    </td>
</tr>




<tr>
    <td colspan="4" style="text-align: left;">
    4.7 Ozone generation Cooling water 
    </td>
    <td colspan="6" style="text-align: left;">
    
    {{$data->log->ozone_generation_cooling_water_4}}   
    
    </td>
</tr>


  
<tr>
    <td colspan="8" style="text-align: left;">
    5. Measurements
    </td>
    <td colspan="1" style="text-align: left;">
    correct
    </td>
    <td colspan="1" style="text-align: left;">
    faulty
    </td>
</tr>


  
<tr>
    <td colspan="8" style="text-align: left;">
    5.1 Dew point between adsorber and generators
    </td>
    <td colspan="1" style="text-align: left;">
    @if($data->log->dew_point_between_adsorber_and_generators_5 == 'correct') √ @endif
    </td>
    <td colspan="1" style="text-align: left;">
    
    @if($data->log->dew_point_between_adsorber_and_generators_5 == 'faulty') √ @endif
    
    </td>
</tr>


  
<tr>
    <td colspan="8" style="text-align: left;">
    5.2 Dew point at unit output <br>  (dew point must be at least -40 °C, if dew point <br>
        < -40 °C, check pipe leak , etc)

    </td>
    <td colspan="1" style="text-align: left;">
    @if($data->log->dew_point_at_unit_output_5 == 'correct') √ @endif
    </td>
    <td colspan="1" style="text-align: left;">
    @if($data->log->dew_point_at_unit_output_5 == 'faulty') √ @endif 
    
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    5.3 Ozone level current consumption according to test log <br>
       (see unit)

    </td>
    <td colspan="1" style="text-align: left;">
    @if($data->log->ozone_level_5 == 'correct') √ @endif
    
    </td>
    <td colspan="1" style="text-align: left;">
    @if($data->log->ozone_level_5 == 'faulty') √ @endif
    
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    6. Setting and function test
    </td>
    <td colspan="1" style="text-align: left;">
     
    </td>
    <td colspan="1" style="text-align: left;">
     
    </td>
</tr>


  
<tr>
    <td colspan="8" style="text-align: left;">
    6.1 Check supply main and over current protection
    </td>
    <td colspan="1" style="text-align: left;">

    @if($data->log->check_supply_main_6 == 'correct') √ @endif  

    </td>
    <td colspan="1" style="text-align: left;">


    @if($data->log->check_supply_main_6 == 'faulty') √ @endif
    
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    6.2 Check operating/error signal lamps
    </td>
    <td colspan="1" style="text-align: left;">
    
    @if($data->log->check_operating_6 == 'correct') √ @endif
 
    </td>
    <td colspan="1" style="text-align: left;">

    @if($data->log->check_operating_6 == 'faulty') √ @endif 
    
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    6.3 Check the function and setting of dryer thermostats
    </td>
    <td colspan="1" style="text-align: left;">

    @if($data->log->check_the_function_6 == 'correct') √ @endif  

    </td>
    <td colspan="1" style="text-align: left;">

    @if($data->log->check_the_function_6 == 'faulty') √ @endif  
     
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    Setting
    </td>
    <td colspan="1" style="text-align: left;">
    Input (°C)
    </td>
    <td colspan="1" style="text-align: left;">
    Output (°C)
    </td>
</tr>


  
<tr>
    <td colspan="8" style="text-align: left;">
    Dryer 1
    </td>
    <td colspan="1" style="text-align: left;">
    
  
    {{$data->log->dryer_1_input_6}}
 
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->dryer_1_output_6}}
  
    </td>
</tr>


   
<tr>
    <td colspan="8" style="text-align: left;">
    Dryer 2
    </td>
    <td colspan="1" style="text-align: left;">
    
    {{$data->log->dryer_2_input_6}}
   

    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->dryer_2_output_6}}
    
    
    </td>
</tr>



<tr>
    <td colspan="8" style="text-align: left;">
    Gas Temperatur Monitoring
    </td>
    <td colspan="1" style="text-align: left;">
    

    {{$data->log->gas_temperatur_monitoring_input_6}} 
    </td> 
    <td colspan="1" style="text-align: left;">

    {{$data->log->gas_temperatur_monitoring_output_6}} 

    </td>
</tr>

<tr>
    <td colspan="8" style="text-align: left;">
    Cooling Water Monitoring
    </td>
    <td colspan="1" style="text-align: left;">
    
    {{$data->log->cooling_water_monitoring_input_6}} 
 
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->cooling_water_monitoring_output_6}} 
  
    </td>
</tr>



<tr>
    <td colspan="10" style="text-align: left;">7. Operation Data
    </td>
</tr>



<tr>
    <td colspan="5" style="text-align: left;">Voltage    </td>
    <td colspan="1" style="text-align: left;">(V)   </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->voltage_1_7}} 
   

</td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->voltage_2_7}} 
    
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->voltage_3_7}} 
    
 

    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->voltage_4_7}}  

    </td>
</tr>






<tr>
    <td colspan="5" style="text-align: left;"> Current Consumption    </td>
    <td colspan="1" style="text-align: left;">(A)   </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->current_consumption_1_7}}   

</td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->current_consumption_2_7}}   
    
 
    </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->current_consumption_3_7}}   
    
  

    </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->current_consumption_4_7}}   
    
   

    </td>
</tr>




<tr>
    <td colspan="5" style="text-align: left;"> Gas flow ( Vaccum )  </td>
    <td colspan="1" style="text-align: left;"> Nm3/h </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->gas_flow_1_7}}   
    
    
</td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->gas_flow_2_7}}   
    
     

    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->gas_flow_3_7}}   
     

    </td>
    <td colspan="1" style="text-align: left;">



    {{$data->log->gas_flow_4_7}}   
      

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Ozone  level  </td>
    <td colspan="1" style="text-align: left;"> step </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->ozone_level_1_7}}   
       
</td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->ozone_level_2_7}}   
        

    </td>
    <td colspan="1" style="text-align: left;">



    {{$data->log->ozone_level_3_7}}   
         
    </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->ozone_level_4_7}}   
         
 

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Injection Pressure  ( IN )  </td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;">
    {{$data->log->injection_pressure_in_1_7}}    
</td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->injection_pressure_in_2_7}}     
    </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->injection_pressure_in_3_7}}     
  
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->injection_pressure_in_4_7}}    

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Injection Pressure  ( OUT )  </td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->injection_pressure_out_1_7}}     

</td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->injection_pressure_out_2_7}}    
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->injection_pressure_out_3_7}}    

    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->injection_pressure_out_4_7}}    
    
 
    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Cooling Water  flow </td>
    <td colspan="1" style="text-align: left;"> l/h </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->cooling_water_flow_1_7}}    
     
</td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->cooling_water_flow_2_7}}    
      

    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->cooling_water_flow_3_7}}    
      
  
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->cooling_water_flow_4_7}}    
      
   
    </td>
</tr>






<tr>
    <td colspan="5" style="text-align: left;"> Water Flow Rate </td>
    <td colspan="1" style="text-align: left;"> m3/h </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->water_flow_rate_1_7}}    
    
</td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->water_flow_rate_2_7}}    
    
 
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->water_flow_rate_3_7}}    
     
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->water_flow_rate_4_7}}    
      
    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Excess Ozone in water </td>
    <td colspan="1" style="text-align: left;"> mg/l </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->excess_ozone_in_water_1_7}}    
       
</td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->excess_ozone_in_water_2_7}}    
        
    </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->excess_ozone_in_water_3_7}}    
        
 
    </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->excess_ozone_in_water_4_7}}    
        
  
    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Running time </td>
    <td colspan="1" style="text-align: left;"> hour </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->running_time_1_7}}    
        
   
</td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->running_time_2_7}}    
        
    
    </td>
    <td colspan="1" style="text-align: left;">

    {{$data->log->running_time_3_7}}    
        
     
    </td>
    <td colspan="1" style="text-align: left;">


    {{$data->log->running_time_4_7}}    
        
      
    </td>
</tr>



<tr>
    <td colspan="10" style="text-align: left;"> 
    Note : <br>


    {{$data->log->noted}}    
        
       
    </td>
</tr>



<tr>
    <td colspan="10" style="text-align: left;">file : <br> 
     @if($data->log->file)
        <a href="/public/laporan/{{ $data->log->file }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a>
        @else
        -
        @endif
    </td>
</tr>
  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> 
    {{$data->reminder_service}}  Bulan
    </td>
</tr>


<tr>
    <td colspan="10" style="text-align: left;"> 
    <a href="/jadwal/{{ Crypt::encrypt($data->id) }}"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <a href="/laporan-log/{{ Crypt::encrypt($data->id) }}/{{ Crypt::encrypt($data->log->id) }}/destroy"><input class="submit btn btn-danger" type="button" value="Hapus"></a>
    <a href="/laporan-log/{{ Crypt::encrypt($data->id) }}/update"><input class="submit btn btn-warning" type="button" value="Edit"></a>
    @endif
</td>
</tr>


</table>
 

</div>




<script type="text/javascript">
    "use strict"; 
     
	$('.date').datepicker({format:'yyyy-mm-dd'});
	$('.year').datepicker({format:'mm/yyyy'});

   $(".select2-A").select2({
      placeholder: "pilih model",
      allowClear: true
    });

var radios = document.getElementsByTagName('input');
for(i=0; i<radios.length; i++ ) {
    radios[i].onclick = function(e) {
        if(e.ctrlKey) {
            this.checked = false;
        }
    }
}
</script>


@endsection