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
	<h4>LAPORAN OZON</h4>
</div>

<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/laporan-ozon/{{ Crypt::encrypt($data->id) }}/store" autocomplete="off">
@csrf
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    {{$data->ozon->subject}}
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    {{$data->ozon->user->name}}<br>({{$data->ozon->user->indentity_number}})</td>
    <td colspan="2" style="text-align: left;">Customer by : <br>
    {{$data->ozon->customer_by}}
    </td>
</tr>

<tr>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6">
                Model : <br>
                {{$data->ozon->produk->model}}
            </div>
            <div class="col-md-6">
            SN : <br>
                {{$data->ozon->serial_number}}
            </div>
        </div>
    </td>
    <td colspan="4" style="text-align: left;">  
        <div class="col-md-12">
            <div class="col-md-6">
            Running Hours : <br> 
                {{$data->ozon->running_hours}} h
            </div>
            <div class="col-md-6">
            Year : <br>  
                {{$data->ozon->year}} 
            </div>
        </div>
    </td>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6"> Date     : <br> 
                {{$data->ozon->date}}  

            </div>
            <div class="col-md-6"> 
            Working hours : <br>  {{$data->date_start.' ~ '.$data->date_finish}}
            </div>
        </div>
            </td>
</tr>

 
<tr>
    <td colspan="5" style="text-align: center;"> >  >  >   Ozone cabinet door switch open/emergency stop    >  >  > </td>
    <td colspan="5" style="text-align: left;"> Lock : 
                {{$data->ozon->lock}}  

    </td>
</tr>


<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 1 - Dew Point after the tube generator</b> </td>
</tr>



<tr>
    <td colspan="5" style="text-align: center;"> Dryer 1 </td>
    <td colspan="5" style="text-align: center;"> Dryer 2 </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_remaining_capacity_before}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_remaining_capacity_after}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_remaining_capacity_noted}} </td>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_remaining_capacity_before}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_remaining_capacity_after}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_remaining_capacity_noted}} </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_dew_point_before}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_dew_point_after}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_dew_point_noted}}    </td>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_dew_point_before}}
    
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_dew_point_after}}
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_dew_point_noted}}
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_gas_temperature_before}}
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_gas_temperature_after}}
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_1_gas_temperature_noted}}
    </td>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_gas_temperature_before}}</td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_gas_temperature_after}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_1_dryer_2_gas_temperature_noted}} </td>
</tr>

<tr>
    <td colspan="5" style="text-align: left;">Description : <br> {{$data->ozon->step_1_dryer_1_description}} </td>

    <td colspan="5" style="text-align: left;">Description : <br> {{$data->ozon->step_1_dryer_2_description}}  </td>

</tr>


<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 2 - Dew Point after the Dryer</b> </td>
</tr>



<tr>
    <td colspan="5" style="text-align: center;"> Dryer 1 </td>
    <td colspan="5" style="text-align: center;"> Dryer 2 </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_remaining_capacity_before}} </td>
    <td colspan="1" style="text-align: left;">  {{$data->ozon->step_2_dryer_1_remaining_capacity_after}} </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_remaining_capacity_noted}} 
    </td>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_2_remaining_capacity_before}} 
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_2_remaining_capacity_after}} 
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_2_remaining_capacity_noted}} 
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_dew_point_before}} 
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_dew_point_after}}  
    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_dew_point_noted}}  
    </td>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_2_dew_point_before}}  
    </td>
    <td colspan="1" style="text-align: left;">  {{$data->ozon->step_2_dryer_2_dew_point_after}}      </td>
    <td colspan="1" style="text-align: left;">  {{$data->ozon->step_2_dryer_2_dew_point_noted}}      </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_gas_temperature_before}}      </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_gas_temperature_after}}  </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_1_gas_temperature_noted}}     </td>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_2_gas_temperature_before}}    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_2_gas_temperature_after}}    </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_2_dryer_2_gas_temperature_noted}}     </td>
</tr>

<tr>
    <td colspan="5" style="text-align: left;">Description : <br> 
    {{$data->ozon->step_2_dryer_1_description}}  
</td>

    <td colspan="5" style="text-align: left;">Description : <br> 
    {{$data->ozon->step_2_dryer_2_description}} 
</td>

</tr>



<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 3 - Regeneration the Dryer</b> </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;"> ******************** </td>
    <td colspan="1" style="text-align: left;"> Phase R </td>
    <td colspan="1" style="text-align: left;"> Phase S </td>
    <td colspan="1" style="text-align: left;"> Phase T </td>
    <td colspan="2" style="text-align: left;"> Flow Blower </td>
    <td colspan="1" style="text-align: left;"> m/s </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_3_flow_blower_1}} 
     </td>
    <td colspan="1" style="text-align: left;">  {{$data->ozon->step_3_flow_blower_2}} 
     </td>
</tr>

<tr>
    <td colspan="1" style="text-align: left;"> Regeneration Blower </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> {{$data->ozon->step_3_regeneration_blower_phase_r}} 
    </td>
    <td colspan="1" style="text-align: left;">  {{$data->ozon->step_3_regeneration_blower_phase_s}} 
    </td>
    <td colspan="1" style="text-align: left;"> 
    {{$data->ozon->step_3_regeneration_blower_phase_t}} 
    
    </td>
    
    <td colspan="2" style="text-align: left;"> Dryer Heating 1 16S1 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    {{$data->ozon->step_3_dryer_heating_1_1}} 
     
     </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_heating_1_2}} 
     
    
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heater Dryer 1 </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_3_dryer_heating_1_phase_r}} 
      
    </td>
    <td colspan="1" style="text-align: left;"> 


    {{$data->ozon->step_3_dryer_heating_1_phase_s}} 
       
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    

    {{$data->ozon->step_3_dryer_heating_1_phase_t}} 
        
    </td>
    
    <td colspan="2" style="text-align: left;"> Dryer Heating 2 16S2 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    {{$data->ozon->step_3_dryer_heating_2_1}} 
         
     </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_3_dryer_heating_2_2}} 
          
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heater Dryer 2 </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_3_heater_dryer_2_phase_r}} 
           
    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_3_heater_dryer_2_phase_s}} 
       
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_heater_dryer_2_phase_t}} 
        
    </td>
    
    <td colspan="2" style="text-align: left;"> Dryer regeneration 1 16S3 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    {{$data->ozon->step_3_dryer_regeneration_1_1}} 
         
     </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_regeneration_1_2}} 
          
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="2" style="text-align: left;"> Dryer regeneration 2 16S4 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    {{$data->ozon->step_3_dryer_regeneration_2_1}} 
           
     </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_regeneration_2_2}} 
            
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="1" style="text-align: left;"> </td>
    <td colspan="1" style="text-align: left;"> </td>
    <td colspan="1" style="text-align: left;">  </td>
</tr>

<tr>
    <td colspan="5" style="text-align: center;"> Dryer 1 </td>
    <td colspan="5" style="text-align: center;"> Dryer 2 </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
</tr>

<tr>
    <td colspan="1" style="text-align: left;">Heating Up Time  </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;">
    
    {{$data->ozon->step_3_dryer_1_heating_up_time_before}} 
              
    </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_heating_up_time_after}} 
                
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_heating_up_time_noted}} 
                  
    </td>
    
    <td colspan="1" style="text-align: left;">Heating Up Time  </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;">  
    
    {{$data->ozon->step_3_dryer_2_heating_up_time_before}} 
     
    </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_2_heating_up_time_after}} 
       
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_2_heating_up_time_noted}} 
         
    </td>
    
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heating On/Off </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    
    {{$data->ozon->step_3_dryer_1_heating_on_off_before}} 
           
    </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_heating_on_off_after}}  
     
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_heating_on_off_noted}}  
      
    </td>
    
    <td colspan="1" style="text-align: left;"> Heating On/Off </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    
    {{$data->ozon->step_3_dryer_2_heating_on_off_before}}    

    </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_2_heating_on_off_after}}  
     
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_2_heating_on_off_noted}}   

    </td>
    
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heating Time </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_3_dryer_1_heating_time_before}}   
       
    </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_heating_time_after}}   
         
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_heating_time_noted}}   
           
    </td>
    
    <td colspan="1" style="text-align: left;"> Heating Time </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    
    {{$data->ozon->step_3_dryer_2_heating_time_before}}  
    
    </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_2_heating_time_after}}   
     
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_2_heating_time_noted}} 
    
    </td>
    
</tr>



<tr>
    <td colspan="1" style="text-align: left;"> Total Reg. Time </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_total_time_before}} 
     
    </td>
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_total_time_after}} 
     
    
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    
    {{$data->ozon->step_3_dryer_1_total_time_noted}} 
     
    
    </td>
    
    <td colspan="1" style="text-align: left;"> Total Reg. Time </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    
    {{$data->ozon->step_3_dryer_2_total_time_before}} 
     
    
      
    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_3_dryer_2_total_time_after}} 
     
    
        
    </td>
    
    <td colspan="1" style="text-align: left;"> 

{{$data->ozon->step_3_dryer_2_total_time_noted}} 
 
  
    </td>
    
</tr>


<tr>
    <td colspan="5" style="text-align: left;">Description : <br>

{{$data->ozon->step_3_dryer_1_description}} 
 
  
   
    </td>
    <td colspan="5" style="text-align: left;">Description : <br>

{{$data->ozon->step_3_dryer_2_description}} 
 

    </td>
</tr>



<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 4 - Columns of Data & Action</b> </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;"> Voltage </td>
    <td colspan="1" style="text-align: left;"> V </td>
    <td colspan="1" style="text-align: left;"> 

{{$data->ozon->step_4_voltage_1}} 
 
    
    </td>
    <td colspan="1" style="text-align: left;"> 

{{$data->ozon->step_4_voltage_2}} 
 
     
    </td>
    <td colspan="2" style="text-align: left;"> **** </td>
    <td colspan="1" style="text-align: left;"> Phase R </td>
    <td colspan="1" style="text-align: left;"> Phase S </td>
    <td colspan="1" style="text-align: left;"> Phase T </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;"> Voltage </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 
{{$data->ozon->step_4_current_consumption_1}} 
  

    </td>
    <td colspan="1" style="text-align: left;"> 
{{$data->ozon->step_4_current_consumption_2}} 
   
    </td>
    <td colspan="1" style="text-align: left;"> Booster Pump </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_booster_pump_phase_r}} 
    
    </td>
    <td colspan="1" style="text-align: left;"> 

{{$data->ozon->step_4_booster_pump_phase_s}} 
 
     </td>
    <td colspan="1" style="text-align: left;">

{{$data->ozon->step_4_booster_pump_phase_t}}  

    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Ozone Level </td>
    <td colspan="1" style="text-align: left;"> step </td>
    <td colspan="1" style="text-align: left;"> 


    {{$data->ozon->step_4_ozone_level_1}}  
 
    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_ozone_level_2}}  
  
    </td>
    <td colspan="2" style="text-align: center;"> Check Original part & function </td>
    <td colspan="1" style="text-align: center;"> 
    √

    </td>
    <td colspan="1" style="text-align: center;"> 
    X

     </td>
    <td colspan="1" style="text-align: center;">
    Description
    </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;"> Excess Ozone in water </td>
    <td colspan="1" style="text-align: left;"> mg/l </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_excess_ozone_1}}  
   
    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_excess_ozone_2}}  
    
    </td>
    <td colspan="2" style="text-align: center;"> Glass Breakage Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_glass_breakage_relay == 'Y' )
    √
    @endif 
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_glass_breakage_relay == 'N' )
    X
    @endif 
     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_glass_breakage_relay_desc}}   
    
    </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;"> Water Flow Rate </td>
    <td colspan="1" style="text-align: left;"> m³/h </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_water_flow_1}}    

    </td>
    <td colspan="1" style="text-align: left;"> 
 
    {{$data->ozon->step_4_water_flow_2}}    

    </td>
    <td colspan="2" style="text-align: center;"> Glass Breakage Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_high_voltage_cable == 'Y' )
    √
    @endif 
    </td>
    <td colspan="1" style="text-align: center;"> 
    
   
    @if( $data->ozon->step_4_high_voltage_cable == 'N' )
    √
    @endif 

     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_high_voltage_cable_desc}}  
    
    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Flow Cooling Water </td>
    <td colspan="1" style="text-align: left;"> l/h </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_flow_cooling_1}}  
     

    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_flow_cooling_2}}  
      
    </td>
    <td colspan="2" style="text-align: center;"> Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_relay == 'Y' )
    √
    @endif  

    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_relay == 'N' )
    √
    @endif  
     
     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_relay_desc}}  
       
    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Flow Vaccum </td>
    <td colspan="1" style="text-align: left;"> Nm³/h </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_flow_vaccum_1}}  
 

    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_flow_vaccum_2}}   

    </td>
    <td colspan="2" style="text-align: center;"> Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_noise_filter == 'Y' )
    √
    @endif  
 
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_noise_filter == 'N' )
    √
    @endif   

     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_noise_filter_desc}}  

    </td>
</tr>




<tr>
    <td colspan="2" style="text-align: left;"> Injection Pressure In</td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_injection_pressure_in_1}}    

    </td>
    <td colspan="1" style="text-align: left;"> 

{{$data->ozon->step_4_injection_pressure_in_2}}    
 
    </td>
    <td colspan="2" style="text-align: center;"> Solenoid Valve Regeneration </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_solenoid_valve == 'Y' )
    √
    @endif  
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_solenoid_valve == 'N' )
    √
    @endif 
    
     </td>
    <td colspan="1" style="text-align: center;">
 
{{$data->ozon->step_4_solenoid_valve_desc}}    

    </td>
</tr>




<tr>
    <td colspan="2" style="text-align: left;"> Injection Pressure Out </td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;"> 

{{$data->ozon->step_4_injection_pressure_out_1}} 

    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_injection_pressure_out_2}} 

    
    </td>
    <td colspan="2" style="text-align: center;"> Solenoid Valve Operation </td>
    <td colspan="1" style="text-align: center;"> 
     
    @if( $data->ozon->step_4_solenoid_valve_operation == 'Y' )
    √
    @endif 
     
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_solenoid_valve_operation == 'N' )
    √
    @endif 
      
     </td>
    <td colspan="1" style="text-align: center;">


    {{$data->ozon->step_4_solenoid_valve_operation_desc}}
    
    </td>
</tr>





<tr>
    <td colspan="2" style="text-align: left;"> Vaccum in PLC </td>
    <td colspan="1" style="text-align: left;"> Nm³/h </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_vaccu_in_plc_1}}
    
    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_vaccu_in_plc_2}}
    
    </td>
    <td colspan="2" style="text-align: center;"> Thermostat       16S5 </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_thermostat == 'Y' )
    √
    @endif 
       
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_thermostat == 'N' )
    √
    @endif 
        
     </td>
    <td colspan="1" style="text-align: center;">
    {{$data->ozon->step_4_thermostat_desc}}
    
    </td>
</tr>





<tr>
    <td colspan="2" style="text-align: left;"> Max absolute humidity </td>
    <td colspan="1" style="text-align: left;"> g/m³ </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_absolute_humidity_1}}
    
    
    </td>
    <td colspan="1" style="text-align: left;"> 


    {{$data->ozon->step_4_absolute_humidity_2}}
    
    
    </td>
    <td colspan="2" style="text-align: center;"> Thermostat      26S2 </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_thermostat_26S2 == 'Y' )
    √
    @endif 
    
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    
    @if( $data->ozon->step_4_thermostat_26S2 == 'N' )
    √
    @endif 
    
    
     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_thermostat_26S2_desc}}
    
    
    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Total Operation Time </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_total_operation_time_1}}
    
    
    
    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_total_operation_time_2}}
    
    
    </td>
    <td colspan="2" style="text-align: center;"> Ozone Fault main pump cut off </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_ozone_fault == 'Y' )
    √
    @endif 
    
     
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_ozone_fault == 'N' )
    √
    @endif 
    
      
     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_ozone_fault_desc}}
     
    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Software PLC & OP 3 </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_software_plc_1}}
      
    </td>
    <td colspan="1" style="text-align: left;"> 

    {{$data->ozon->step_4_software_plc_2}}
       
    </td>
    <td colspan="2" style="text-align: center;"> Noted all fault data & reset </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_noted_all == 'Y' )
    √
    @endif 
     
    </td>
    <td colspan="1" style="text-align: center;"> 
    
    @if( $data->ozon->step_4_noted_all == 'N' )
    √
    @endif 
    
     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_noted_all_desc}}
       
 
    </td>
</tr>
<tr>
    <td colspan="4" style="text-align: cecnter;"> HITORY FAULTS </td>
    <td colspan="1" style="text-align: center;"> X </td>
    <td colspan="2" style="text-align: left;"> Check Butterfly Flap </td>
    <td colspan="1" style="text-align: center;"> 
     

    </td>
    <td colspan="1" style="text-align: center;">  

     </td>
    <td colspan="1" style="text-align: center;"> 
    </td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Regeneration blower failure </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_regeneration_blower_failure}}
        
	</td>
    <td colspan="2" style="text-align: center;"> * Open </td>
 <td colspan="1" style="text-align: center;"> 
    
 @if( $data->ozon->step_4_open == 'Y' )
    √
    @endif  
    </td>
    <td colspan="1" style="text-align: center;"> 
        
    @if( $data->ozon->step_4_open == 'N' )
    √
    @endif 
     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_open_desc}}
    
    </td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Heating time in dryer 1 dan dryer 2 </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_heating_time_in_dryer_1_dan_dryer_2}}
     
	</td>
    <td colspan="2" style="text-align: center;"> * Close </td>
 <td colspan="1" style="text-align: center;"> 
    
 @if( $data->ozon->step_4_close == 'Y' )
    √
    @endif 
 
    </td>
    <td colspan="1" style="text-align: center;"> 
   
    @if( $data->ozon->step_4_close == 'N' )
    √
    @endif 
     </td>
    <td colspan="1" style="text-align: center;">
    {{$data->ozon->step_4_close_desc}}
    
    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Thermostat dryer 1 dan dryer 2 </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_thermostat_dryer_1_dan_dryer_2}}
     
	</td>
    <td colspan="2" style="text-align: center;"> Seal Check Valve Injection </td>
 <td colspan="1" style="text-align: center;"> 
 @if( $data->ozon->step_4_seal_check_valve_injection == 'Y' )
    √
    @endif 
 
    </td>
    <td colspan="1" style="text-align: center;"> 
    @if( $data->ozon->step_4_seal_check_valve_injection == 'N' )
    √
    @endif
     </td>
    <td colspan="1" style="text-align: center;">

    {{$data->ozon->step_4_seal_check_valve_injection_desc}}
 
    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Ozone mixing/air flow low </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_ozone_mixing}}
  
	</td>
    <td colspan="5" style="text-align: center;"> Step 5 - Check Safety Unit Ozone </td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Cooling water temp. too high/flow low </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_cooling_water}}
   
	</td>
    <td colspan="4" style="text-align: center;">  </td>
    <td colspan="1" style="text-align: center;"> Description </td>
</tr>
 
<tr>
    <td colspan="4" style="text-align: left;"> Ozone cabinet door switch open/emergency stop </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_ozone_cabinet_door}}
    
	</td>
    <td colspan="4" style="text-align: center;"> Water inrush in ozone generation </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_water_inrush_in_ozone_generation}}
     
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Air too hot </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_air_too_hot}}
      
	</td>
    <td colspan="4" style="text-align: center;"> Ozone mixing/air flow low </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_ozone_mixing}}
       
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Mains power supply phase failure </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_mains_power_supply_phase_failure}}
       
    
	</td>
    <td colspan="4" style="text-align: center;"> Cooling water temp. too high </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_cooling_water_temp}}
       
     
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Water inrush in ozone generation </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_water_inrush_in_ozone_generation}}
       
      
	</td>
    <td colspan="4" style="text-align: center;"> Cleaning Unit Ozone & etc </td>
    <td colspan="1" style="text-align: center;"> 
 
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Booster pump failure/off </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_booster_pump_failure}}
        
	</td>
    <td colspan="4" style="text-align: center;"> Trafo High Voltage </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_trafo_high_voltage}}
         
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Ozone generation </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_ozone_generation}}
          
	</td>
    <td colspan="4" style="text-align: center;"> Tube Generator </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_tube_generator}}
           
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> ozone gas warning </td>
    <td colspan="1" style="text-align: left;"> 
	
    {{$data->ozon->step_4_ozone_gas_warning}}
            
	</td>
    <td colspan="4" style="text-align: center;"> Filter Cabinet Fan/Change </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_filter_cabinet_fan}}
             
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> 
	 
	</td>
    <td colspan="4" style="text-align: center;"> Filter Cooling Water </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_filter_cooling_water}}
              
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> 
	 
	</td>
    <td colspan="4" style="text-align: center;"> Seal Check Valve </td>
    <td colspan="1" style="text-align: center;"> 

    {{$data->ozon->step_5_seal_check_valve}}
               
	</td>
</tr>
 


<tr>
    <td colspan="10" style="text-align: center;"> Step 6 - Recommendation/Note </td>
</tr>



<tr>
    <td colspan="10" style="text-align: center;"> 


    {{$data->ozon->step_6_recommendation}}
                
    </td>
</tr>


  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> 
    {{$data->reminder_service}}  Bulan
                 
    </td>
</tr>

<tr>
    <td colspan="10" style="text-align: left;">file : <br> 
     @if($data->ozon->file)
        <a href="/public/laporan/{{ $data->ozon->file }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a>
        @else
        -
        @endif
    </td>
</tr>

<tr>
    <td colspan="10" style="text-align: left;">
    <a href="/jadwal/{{ Crypt::encrypt($data->id) }}"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <a href="/laporan-ozon/{{ Crypt::encrypt($data->id) }}/{{ Crypt::encrypt($data->ozon->id) }}/destroy"><input class="submit btn btn-danger" type="button" value="Hapus"></a>
    <a href="/laporan-ozon/{{ Crypt::encrypt($data->id) }}/update"><input class="submit btn btn-warning" type="button" value="Edit"></a>
    @endif
</td>
</tr>



</table>

</form>

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