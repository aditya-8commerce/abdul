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

<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/laporan-log/{{ Crypt::encrypt($data->id) }}/store" autocomplete="off">
@csrf
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    <input type="text" class="form-control subject @if($errors->has('subject')) error @endif"  id="subject" name="subject" value="{{ old('subject') }}">
    @if($errors->has('subject'))  <em class="error">{{ $errors->first('subject') }}</em> @endif
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <select class="id_user form-control @if($errors->has('id_user')) error @endif" id="id_user" name="id_user" aria-required="true">
    <option value=""> </option>
    @foreach ($data->users as $d)
    <option value="{{$d->id_user}}" @if(old('id_user') == $d->id_user) selected="selected" @endif>{{$d->user->name.' - '.$d->user->indentity_number}}</option>
    @endforeach
    @if($errors->has('id_user'))  <em class="error">{{ $errors->first('id_user') }}</em> @endif			
    </select>
    @else 

    {{Auth::user()->name.' ( '.Auth::user()->indentity_number.' )'}} 

    @endif</td>
    <td colspan="2" style="text-align: left;">Customer by : <br>
    <input type="text" class="form-control customer_by @if($errors->has('customer_by')) error @endif"  id="customer_by" name="customer_by" value="{{ old('customer_by') }}">
    @if($errors->has('customer_by'))  <em class="error">{{ $errors->first('customer_by') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6">
                Model : <br>
                <select name="model" id="model" class="select2-A form-control">
                    @foreach ($produk as $d)
                        <option value="{{$d->id}}" @if(old('model') == $d->id) selected="selected" @endif>{{$d->model}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
            SN : <br>
    <input type="text" class="form-control serial_number @if($errors->has('serial_number')) error @endif"  id="serial_number" name="serial_number" value="{{ old('serial_number') }}">
    @if($errors->has('serial_number'))  <em class="error">{{ $errors->first('serial_number') }}</em> @endif
            </div>
        </div>
    </td>
    <td colspan="4" style="text-align: left;">  
        <div class="col-md-12">
            <div class="col-md-6">
            Running Hours : <br> 
    <input type="number" step="any" class="form-control running_hours @if($errors->has('running_hours')) error @endif" id="running_hours" name="running_hours" value="{{ old('running_hours') }}"> h
    @if($errors->has('running_hours'))  <em class="error">{{ $errors->first('running_hours') }}</em> @endif
            </div>
            <div class="col-md-6">
            Year : <br>  
    <input type="text" class="form-control year @if($errors->has('year')) error @endif" data-date-format="yyyy-mm" id="year" name="year" value="{{ old('year') }}">
    @if($errors->has('year'))  <em class="error">{{ $errors->first('year') }}</em> @endif
            </div>
        </div>
    </td>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6"> Date     : <br> 
    <input type="text" class="form-control date @if($errors->has('date')) error @endif" data-date-format="yyyy-mm-dd" id="date" name="date" value="{{ old('date') }}">
    @if($errors->has('date'))  <em class="error">{{ $errors->first('date') }}</em> @endif

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


    <input type="number" step="any" class="form-control dryer_1_heating_up @if($errors->has('dryer_1_heating_up')) error @endif" id="dryer_1_heating_up" name="dryer_1_heating_up" value="{{ old('dryer_1_heating_up') }}">
    @if($errors->has('dryer_1_heating_up'))  <em class="error">{{ $errors->first('dryer_1_heating_up') }}</em> @endif


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
    
    <input type="number" step="any" class="form-control dryer_1_heating @if($errors->has('dryer_1_heating')) error @endif" id="dryer_1_heating" name="dryer_1_heating" value="{{ old('dryer_1_heating') }}">
    @if($errors->has('dryer_1_heating'))  <em class="error">{{ $errors->first('dryer_1_heating') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control dryer_1_heating_16s3 @if($errors->has('dryer_1_heating_16s3')) error @endif" id="dryer_1_heating_16s3" name="dryer_1_heating_16s3" value="{{ old('dryer_1_heating_16s3') }}">
    @if($errors->has('dryer_1_heating_16s3'))  <em class="error">{{ $errors->first('dryer_1_heating_16s3') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control dryer_1_regeneration_time @if($errors->has('dryer_1_regeneration_time')) error @endif" id="dryer_1_regeneration_time" name="dryer_1_regeneration_time" value="{{ old('dryer_1_regeneration_time') }}">
    @if($errors->has('dryer_1_regeneration_time'))  <em class="error">{{ $errors->first('dryer_1_regeneration_time') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control dryer_1_heater_current_1 @if($errors->has('dryer_1_heater_current_1')) error @endif" id="dryer_1_heater_current_1" name="dryer_1_heater_current_1" value="{{ old('dryer_1_heater_current_1') }}">
    @if($errors->has('dryer_1_heater_current_1'))  <em class="error">{{ $errors->first('dryer_1_heater_current_1') }}</em> @endif
    /

    <input type="number" step="any" class="form-control dryer_1_heater_current_2 @if($errors->has('dryer_1_heater_current_2')) error @endif" id="dryer_1_heater_current_2" name="dryer_1_heater_current_2" value="{{ old('dryer_1_heater_current_2') }}">
    @if($errors->has('dryer_1_heater_current_2'))  <em class="error">{{ $errors->first('dryer_1_heater_current_2') }}</em> @endif
    /
    <input type="number" step="any" class="form-control dryer_1_heater_current_3 @if($errors->has('dryer_1_heater_current_3')) error @endif" id="dryer_1_heater_current_3" name="dryer_1_heater_current_3" value="{{ old('dryer_1_heater_current_3') }}">
    @if($errors->has('dryer_1_heater_current_3'))  <em class="error">{{ $errors->first('dryer_1_heater_current_3') }}</em> @endif
    

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
    
    <input type="number" step="any" class="form-control dryer_1_fan_blower_1 @if($errors->has('dryer_1_fan_blower_1')) error @endif" id="dryer_1_fan_blower_1" name="dryer_1_fan_blower_1" value="{{ old('dryer_1_fan_blower_1') }}">
    @if($errors->has('dryer_1_fan_blower_1'))  <em class="error">{{ $errors->first('dryer_1_fan_blower_1') }}</em> @endif
    /

    <input type="number" step="any" class="form-control dryer_1_fan_blower_2 @if($errors->has('dryer_1_fan_blower_2')) error @endif" id="dryer_1_fan_blower_2" name="dryer_1_fan_blower_2" value="{{ old('dryer_1_fan_blower_2') }}">
    @if($errors->has('dryer_1_fan_blower_2'))  <em class="error">{{ $errors->first('dryer_1_fan_blower_2') }}</em> @endif
    /
    <input type="number" step="any" class="form-control dryer_1_fan_blower_3 @if($errors->has('dryer_1_fan_blower_3')) error @endif" id="dryer_1_fan_blower_3" name="dryer_1_fan_blower_3" value="{{ old('dryer_1_fan_blower_3') }}">
    @if($errors->has('dryer_1_fan_blower_3'))  <em class="error">{{ $errors->first('dryer_1_fan_blower_3') }}</em> @endif
    

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


    <input type="number" step="any" class="form-control dryer_2_heating_up @if($errors->has('dryer_2_heating_up')) error @endif" id="dryer_2_heating_up" name="dryer_2_heating_up" value="{{ old('dryer_2_heating_up') }}">
    @if($errors->has('dryer_2_heating_up'))  <em class="error">{{ $errors->first('dryer_2_heating_up') }}</em> @endif


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
    
    <input type="number" step="any" class="form-control dryer_2_heating @if($errors->has('dryer_2_heating')) error @endif" id="dryer_2_heating" name="dryer_2_heating" value="{{ old('dryer_2_heating') }}">
    @if($errors->has('dryer_2_heating'))  <em class="error">{{ $errors->first('dryer_2_heating') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control dryer_2_heating_16s3 @if($errors->has('dryer_2_heating_16s3')) error @endif" id="dryer_2_heating_16s3" name="dryer_2_heating_16s3" value="{{ old('dryer_2_heating_16s3') }}">
    @if($errors->has('dryer_2_heating_16s3'))  <em class="error">{{ $errors->first('dryer_2_heating_16s3') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control dryer_2_regeneration_time @if($errors->has('dryer_2_regeneration_time')) error @endif" id="dryer_2_regeneration_time" name="dryer_2_regeneration_time" value="{{ old('dryer_2_regeneration_time') }}">
    @if($errors->has('dryer_2_regeneration_time'))  <em class="error">{{ $errors->first('dryer_2_regeneration_time') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control dryer_2_heater_current_1 @if($errors->has('dryer_2_heater_current_1')) error @endif" id="dryer_2_heater_current_1" name="dryer_2_heater_current_1" value="{{ old('dryer_2_heater_current_1') }}">
    @if($errors->has('dryer_2_heater_current_1'))  <em class="error">{{ $errors->first('dryer_2_heater_current_1') }}</em> @endif
    /

    <input type="number" step="any" class="form-control dryer_2_heater_current_2 @if($errors->has('dryer_2_heater_current_2')) error @endif" id="dryer_2_heater_current_2" name="dryer_2_heater_current_2" value="{{ old('dryer_2_heater_current_2') }}">
    @if($errors->has('dryer_2_heater_current_2'))  <em class="error">{{ $errors->first('dryer_2_heater_current_2') }}</em> @endif
    /
    <input type="number" step="any" class="form-control dryer_2_heater_current_3 @if($errors->has('dryer_2_heater_current_3')) error @endif" id="dryer_2_heater_current_3" name="dryer_2_heater_current_3" value="{{ old('dryer_2_heater_current_3') }}">
    @if($errors->has('dryer_2_heater_current_3'))  <em class="error">{{ $errors->first('dryer_2_heater_current_3') }}</em> @endif
    

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
    
    <input type="number" step="any" class="form-control maximum_absolut_humidity_2 @if($errors->has('maximum_absolut_humidity_2')) error @endif" id="maximum_absolut_humidity_2" name="maximum_absolut_humidity_2" value="{{ old('maximum_absolut_humidity_2') }}">
    @if($errors->has('maximum_absolut_humidity_2'))  <em class="error">{{ $errors->first('maximum_absolut_humidity_2') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control air_flow_3 @if($errors->has('air_flow_3')) error @endif" id="air_flow_3" name="air_flow_3" value="{{ old('air_flow_3') }}">
    @if($errors->has('air_flow_3'))  <em class="error">{{ $errors->first('air_flow_3') }}</em> @endif

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
    
    <input type="number" step="any" class="form-control regeneration_blower_4 @if($errors->has('regeneration_blower_4')) error @endif" id="regeneration_blower_4" name="regeneration_blower_4" value="{{ old('regeneration_blower_4') }}">
    @if($errors->has('regeneration_blower_4'))  <em class="error">{{ $errors->first('regeneration_blower_4') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    4.2 Dryer 1 heating time
    </td>
    <td colspan="6" style="text-align: left;">
    
    <input type="number" step="any" class="form-control dryer_1_heating_time_4 @if($errors->has('dryer_1_heating_time_4')) error @endif" id="dryer_1_heating_time_4" name="dryer_1_heating_time_4" value="{{ old('dryer_1_heating_time_4') }}">
    @if($errors->has('dryer_1_heating_time_4'))  <em class="error">{{ $errors->first('dryer_1_heating_time_4') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="4" style="text-align: left;">
    4.3 Dryer 2 heating time
    </td>
    <td colspan="6" style="text-align: left;">
    
    <input type="number" step="any" class="form-control dryer_2_heating_time_4 @if($errors->has('dryer_2_heating_time_4')) error @endif" id="dryer_2_heating_time_4" name="dryer_2_heating_time_4" value="{{ old('dryer_2_heating_time_4') }}">
    @if($errors->has('dryer_2_heating_time_4'))  <em class="error">{{ $errors->first('dryer_2_heating_time_4') }}</em> @endif

    </td>
</tr>




<tr>
    <td colspan="4" style="text-align: left;">
    4.4 Air too hot
    </td>
    <td colspan="6" style="text-align: left;">
    
    <input type="number" step="any" class="form-control air_too_hot_4 @if($errors->has('air_too_hot_4')) error @endif" id="air_too_hot_4" name="air_too_hot_4" value="{{ old('air_too_hot_4') }}">
    @if($errors->has('air_too_hot_4'))  <em class="error">{{ $errors->first('air_too_hot_4') }}</em> @endif

    </td>
</tr>




<tr>
    <td colspan="4" style="text-align: left;">
    4.5 Mixing
    </td>
    <td colspan="6" style="text-align: left;">
    
    <input type="number" step="any" class="form-control mixing_4 @if($errors->has('mixing_4')) error @endif" id="mixing_4" name="mixing_4" value="{{ old('mixing_4') }}">
    @if($errors->has('mixing_4'))  <em class="error">{{ $errors->first('mixing_4') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="4" style="text-align: left;">
    4.6 Water inrush
    </td>
    <td colspan="6" style="text-align: left;">
    
    <input type="number" step="any" class="form-control water_inrush_4 @if($errors->has('water_inrush_4')) error @endif" id="water_inrush_4" name="water_inrush_4" value="{{ old('water_inrush_4') }}">
    @if($errors->has('water_inrush_4'))  <em class="error">{{ $errors->first('water_inrush_4') }}</em> @endif

    </td>
</tr>




<tr>
    <td colspan="4" style="text-align: left;">
    4.7 Ozone generation Cooling water 
    </td>
    <td colspan="6" style="text-align: left;">
    
    <input type="number" step="any" class="form-control ozone_generation_cooling_water_4 @if($errors->has('ozone_generation_cooling_water_4')) error @endif" id="ozone_generation_cooling_water_4" name="ozone_generation_cooling_water_4" value="{{ old('ozone_generation_cooling_water_4') }}">
    @if($errors->has('ozone_generation_cooling_water_4'))  <em class="error">{{ $errors->first('ozone_generation_cooling_water_4') }}</em> @endif

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
    <input type="radio" name="dew_point_between_adsorber_and_generators_5" @if(old('dew_point_between_adsorber_and_generators_5') == 'correct') checked="checked" @endif value="correct">
    </td>
    <td colspan="1" style="text-align: left;">
    <input type="radio" name="dew_point_between_adsorber_and_generators_5" @if(old('dew_point_between_adsorber_and_generators_5') == 'faulty') checked="checked" @endif value="faulty">
    
    </td>
</tr>


  
<tr>
    <td colspan="8" style="text-align: left;">
    5.2 Dew point at unit output <br>  (dew point must be at least -40 °C, if dew point <br>
        < -40 °C, check pipe leak , etc)

    </td>
    <td colspan="1" style="text-align: left;">
    <input type="radio" name="dew_point_at_unit_output_5" @if(old('dew_point_at_unit_output_5') == 'correct') checked="checked" @endif value="correct">
    </td>
    <td colspan="1" style="text-align: left;">
    <input type="radio" name="dew_point_at_unit_output_5" @if(old('dew_point_at_unit_output_5') == 'faulty') checked="checked" @endif value="faulty">
    
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    5.3 Ozone level current consumption according to test log <br>
       (see unit)

    </td>
    <td colspan="1" style="text-align: left;">
    <input type="radio" name="ozone_level_5" @if(old('ozone_level_5') == 'correct') checked="checked" @endif value="correct">
    </td>
    <td colspan="1" style="text-align: left;">
    <input type="radio" name="ozone_level_5" @if(old('ozone_level_5') == 'faulty') checked="checked" @endif value="faulty">
    
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

    <input type="radio" name="check_supply_main_6" @if(old('check_supply_main_6') == 'correct') checked="checked" @endif value="correct">

    </td>
    <td colspan="1" style="text-align: left;">

    <input type="radio" name="check_supply_main_6" @if(old('check_supply_main_6') == 'faulty') checked="checked" @endif value="faulty">
    
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    6.2 Check operating/error signal lamps
    </td>
    <td colspan="1" style="text-align: left;">
    

    <input type="radio" name="check_operating_6" @if(old('check_operating_6') == 'correct') checked="checked" @endif value="correct">

    </td>
    <td colspan="1" style="text-align: left;">

    <input type="radio" name="check_operating_6" @if(old('check_operating_6') == 'faulty') checked="checked" @endif value="faulty">
    
    </td>
</tr>



  
<tr>
    <td colspan="8" style="text-align: left;">
    6.3 Check the function and setting of dryer thermostats
    </td>
    <td colspan="1" style="text-align: left;">

    <input type="radio" name="check_the_function_6" @if(old('check_the_function_6') == 'correct') checked="checked" @endif value="correct">

    </td>
    <td colspan="1" style="text-align: left;">

    <input type="radio" name="check_the_function_6" @if(old('check_the_function_6') == 'faulty') checked="checked" @endif value="faulty">
     
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
    
    <input type="text" class="form-control dryer_1_input_6 @if($errors->has('dryer_1_input_6')) error @endif"  id="dryer_1_input_6" name="dryer_1_input_6" value="{{ old('dryer_1_input_6') }}">
    @if($errors->has('dryer_1_input_6'))  <em class="error">{{ $errors->first('dryer_1_input_6') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="text" class="form-control dryer_1_output_6 @if($errors->has('dryer_1_output_6')) error @endif"  id="dryer_1_output_6" name="dryer_1_output_6" value="{{ old('dryer_1_output_6') }}">
    @if($errors->has('dryer_1_output_6'))  <em class="error">{{ $errors->first('dryer_1_output_6') }}</em> @endif
    
    </td>
</tr>


   
<tr>
    <td colspan="8" style="text-align: left;">
    Dryer 2
    </td>
    <td colspan="1" style="text-align: left;">
    
    <input type="text" class="form-control dryer_2_input_6 @if($errors->has('dryer_2_input_6')) error @endif"  id="dryer_2_input_6" name="dryer_2_input_6" value="{{ old('dryer_2_input_6') }}">
    @if($errors->has('dryer_2_input_6'))  <em class="error">{{ $errors->first('dryer_2_input_6') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="text" class="form-control dryer_2_output_6 @if($errors->has('dryer_2_output_6')) error @endif"  id="dryer_2_output_6" name="dryer_2_output_6" value="{{ old('dryer_2_output_6') }}">
    @if($errors->has('dryer_2_output_6'))  <em class="error">{{ $errors->first('dryer_2_output_6') }}</em> @endif
    
    </td>
</tr>



<tr>
    <td colspan="8" style="text-align: left;">
    Gas Temperatur Monitoring
    </td>
    <td colspan="1" style="text-align: left;">
    
    <input type="text" class="form-control  @if($errors->has('gas_temperatur_monitoring_input_6')) error @endif"  id="gas_temperatur_monitoring_input_6" name="gas_temperatur_monitoring_input_6" value="{{ old('gas_temperatur_monitoring_input_6') }}">
    @if($errors->has('gas_temperatur_monitoring_input_6'))  <em class="error">{{ $errors->first('gas_temperatur_monitoring_input_6') }}</em> @endif

    </td> 
    <td colspan="1" style="text-align: left;">


    <input type="text" class="form-control gas_temperatur_monitoring_output_6 @if($errors->has('gas_temperatur_monitoring_output_6')) error @endif"  id="gas_temperatur_monitoring_output_6" name="gas_temperatur_monitoring_output_6" value="{{ old('gas_temperatur_monitoring_output_6') }}">
    @if($errors->has('gas_temperatur_monitoring_output_6'))  <em class="error">{{ $errors->first('gas_temperatur_monitoring_output_6') }}</em> @endif
    
    </td>
</tr>

<tr>
    <td colspan="8" style="text-align: left;">
    Cooling Water Monitoring
    </td>
    <td colspan="1" style="text-align: left;">
    
    <input type="text" class="form-control cooling_water_monitoring_input_6 @if($errors->has('cooling_water_monitoring_input_6')) error @endif"  id="cooling_water_monitoring_input_6" name="cooling_water_monitoring_input_6" value="{{ old('cooling_water_monitoring_input_6') }}">
    @if($errors->has('cooling_water_monitoring_input_6'))  <em class="error">{{ $errors->first('cooling_water_monitoring_input_6') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="text" class="form-control cooling_water_monitoring_output_6 @if($errors->has('cooling_water_monitoring_output_6')) error @endif"  id="cooling_water_monitoring_output_6" name="cooling_water_monitoring_output_6" value="{{ old('cooling_water_monitoring_output_6') }}">
    @if($errors->has('cooling_water_monitoring_output_6'))  <em class="error">{{ $errors->first('cooling_water_monitoring_output_6') }}</em> @endif
    
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

    <input type="number" step="any" class="form-control voltage_1_7 @if($errors->has('voltage_1_7')) error @endif"  id="voltage_1_7" name="voltage_1_7" value="{{ old('voltage_1_7') }}">
@if($errors->has('voltage_1_7'))  <em class="error">{{ $errors->first('voltage_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control voltage_2_7 @if($errors->has('voltage_2_7')) error @endif"  id="voltage_2_7" name="voltage_2_7" value="{{ old('voltage_2_7') }}">
@if($errors->has('voltage_2_7'))  <em class="error">{{ $errors->first('voltage_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control voltage_3_7 @if($errors->has('voltage_3_7')) error @endif"  id="voltage_3_7" name="voltage_3_7" value="{{ old('voltage_3_7') }}">
@if($errors->has('voltage_3_7'))  <em class="error">{{ $errors->first('voltage_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control voltage_4_7 @if($errors->has('voltage_4_7')) error @endif"  id="voltage_4_7" name="voltage_4_7" value="{{ old('voltage_4_7') }}">
@if($errors->has('voltage_4_7'))  <em class="error">{{ $errors->first('voltage_4_7') }}</em> @endif

    </td>
</tr>






<tr>
    <td colspan="5" style="text-align: left;"> Current Consumption    </td>
    <td colspan="1" style="text-align: left;">(A)   </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control current_consumption_1_7 @if($errors->has('current_consumption_1_7')) error @endif"  id="current_consumption_1_7" name="current_consumption_1_7" value="{{ old('current_consumption_1_7') }}">
@if($errors->has('current_consumption_1_7'))  <em class="error">{{ $errors->first('current_consumption_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control current_consumption_2_7 @if($errors->has('current_consumption_2_7')) error @endif"  id="current_consumption_2_7" name="current_consumption_2_7" value="{{ old('current_consumption_2_7') }}">
@if($errors->has('current_consumption_2_7'))  <em class="error">{{ $errors->first('current_consumption_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control current_consumption_3_7 @if($errors->has('current_consumption_3_7')) error @endif"  id="current_consumption_3_7" name="current_consumption_3_7" value="{{ old('current_consumption_3_7') }}">
@if($errors->has('current_consumption_3_7'))  <em class="error">{{ $errors->first('current_consumption_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control current_consumption_4_7 @if($errors->has('current_consumption_4_7')) error @endif"  id="current_consumption_4_7" name="current_consumption_4_7" value="{{ old('current_consumption_4_7') }}">
@if($errors->has('current_consumption_4_7'))  <em class="error">{{ $errors->first('current_consumption_4_7') }}</em> @endif

    </td>
</tr>




<tr>
    <td colspan="5" style="text-align: left;"> Gas flow ( Vaccum )  </td>
    <td colspan="1" style="text-align: left;"> Nm3/h </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control gas_flow_1_7 @if($errors->has('gas_flow_1_7')) error @endif"  id="gas_flow_1_7" name="gas_flow_1_7" value="{{ old('gas_flow_1_7') }}">
@if($errors->has('gas_flow_1_7'))  <em class="error">{{ $errors->first('gas_flow_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control gas_flow_2_7 @if($errors->has('gas_flow_2_7')) error @endif"  id="gas_flow_2_7" name="gas_flow_2_7" value="{{ old('gas_flow_2_7') }}">
@if($errors->has('gas_flow_2_7'))  <em class="error">{{ $errors->first('gas_flow_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control gas_flow_3_7 @if($errors->has('gas_flow_3_7')) error @endif"  id="gas_flow_3_7" name="gas_flow_3_7" value="{{ old('gas_flow_3_7') }}">
@if($errors->has('gas_flow_3_7'))  <em class="error">{{ $errors->first('gas_flow_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control gas_flow_4_7 @if($errors->has('gas_flow_4_7')) error @endif"  id="gas_flow_4_7" name="gas_flow_4_7" value="{{ old('gas_flow_4_7') }}">
@if($errors->has('gas_flow_4_7'))  <em class="error">{{ $errors->first('gas_flow_4_7') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Ozone  level  </td>
    <td colspan="1" style="text-align: left;"> step </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control ozone_level_1_7 @if($errors->has('ozone_level_1_7')) error @endif"  id="ozone_level_1_7" name="ozone_level_1_7" value="{{ old('ozone_level_1_7') }}">
@if($errors->has('ozone_level_1_7'))  <em class="error">{{ $errors->first('ozone_level_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control ozone_level_2_7 @if($errors->has('ozone_level_2_7')) error @endif"  id="ozone_level_2_7" name="ozone_level_2_7" value="{{ old('ozone_level_2_7') }}">
@if($errors->has('ozone_level_2_7'))  <em class="error">{{ $errors->first('ozone_level_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control ozone_level_3_7 @if($errors->has('ozone_level_3_7')) error @endif"  id="ozone_level_3_7" name="ozone_level_3_7" value="{{ old('ozone_level_3_7') }}">
@if($errors->has('ozone_level_3_7'))  <em class="error">{{ $errors->first('ozone_level_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control ozone_level_4_7 @if($errors->has('ozone_level_4_7')) error @endif"  id="ozone_level_4_7" name="ozone_level_4_7" value="{{ old('ozone_level_4_7') }}">
@if($errors->has('ozone_level_4_7'))  <em class="error">{{ $errors->first('ozone_level_4_7') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Injection Pressure  ( IN )  </td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control injection_pressure_in_1_7 @if($errors->has('injection_pressure_in_1_7')) error @endif"  id="injection_pressure_in_1_7" name="injection_pressure_in_1_7" value="{{ old('injection_pressure_in_1_7') }}">
@if($errors->has('injection_pressure_in_1_7'))  <em class="error">{{ $errors->first('injection_pressure_in_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control injection_pressure_in_2_7 @if($errors->has('injection_pressure_in_2_7')) error @endif"  id="injection_pressure_in_2_7" name="injection_pressure_in_2_7" value="{{ old('injection_pressure_in_2_7') }}">
@if($errors->has('injection_pressure_in_2_7'))  <em class="error">{{ $errors->first('injection_pressure_in_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control injection_pressure_in_3_7 @if($errors->has('injection_pressure_in_3_7')) error @endif"  id="injection_pressure_in_3_7" name="injection_pressure_in_3_7" value="{{ old('injection_pressure_in_3_7') }}">
@if($errors->has('injection_pressure_in_3_7'))  <em class="error">{{ $errors->first('injection_pressure_in_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control injection_pressure_in_4_7 @if($errors->has('injection_pressure_in_4_7')) error @endif"  id="injection_pressure_in_4_7" name="injection_pressure_in_4_7" value="{{ old('injection_pressure_in_4_7') }}">
@if($errors->has('injection_pressure_in_4_7'))  <em class="error">{{ $errors->first('injection_pressure_in_4_7') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Injection Pressure  ( OUT )  </td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control injection_pressure_out_1_7 @if($errors->has('injection_pressure_out_1_7')) error @endif"  id="injection_pressure_out_1_7" name="injection_pressure_out_1_7" value="{{ old('injection_pressure_out_1_7') }}">
@if($errors->has('injection_pressure_out_1_7'))  <em class="error">{{ $errors->first('injection_pressure_out_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control injection_pressure_out_2_7 @if($errors->has('injection_pressure_out_2_7')) error @endif"  id="injection_pressure_out_2_7" name="injection_pressure_out_2_7" value="{{ old('injection_pressure_out_2_7') }}">
@if($errors->has('injection_pressure_out_2_7'))  <em class="error">{{ $errors->first('injection_pressure_out_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control injection_pressure_out_3_7 @if($errors->has('injection_pressure_out_3_7')) error @endif"  id="injection_pressure_out_3_7" name="injection_pressure_out_3_7" value="{{ old('injection_pressure_out_3_7') }}">
@if($errors->has('injection_pressure_out_3_7'))  <em class="error">{{ $errors->first('injection_pressure_out_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control injection_pressure_out_4_7 @if($errors->has('injection_pressure_out_4_7')) error @endif"  id="injection_pressure_out_4_7" name="injection_pressure_out_4_7" value="{{ old('injection_pressure_out_4_7') }}">
@if($errors->has('injection_pressure_out_4_7'))  <em class="error">{{ $errors->first('injection_pressure_out_4_7') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Cooling Water  flow </td>
    <td colspan="1" style="text-align: left;"> l/h </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control cooling_water_flow_1_7 @if($errors->has('cooling_water_flow_1_7')) error @endif"  id="cooling_water_flow_1_7" name="cooling_water_flow_1_7" value="{{ old('cooling_water_flow_1_7') }}">
@if($errors->has('cooling_water_flow_1_7'))  <em class="error">{{ $errors->first('cooling_water_flow_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control cooling_water_flow_2_7 @if($errors->has('cooling_water_flow_2_7')) error @endif"  id="cooling_water_flow_2_7" name="cooling_water_flow_2_7" value="{{ old('cooling_water_flow_2_7') }}">
@if($errors->has('cooling_water_flow_2_7'))  <em class="error">{{ $errors->first('cooling_water_flow_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control cooling_water_flow_3_7 @if($errors->has('cooling_water_flow_3_7')) error @endif"  id="cooling_water_flow_3_7" name="cooling_water_flow_3_7" value="{{ old('cooling_water_flow_3_7') }}">
@if($errors->has('cooling_water_flow_3_7'))  <em class="error">{{ $errors->first('cooling_water_flow_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control cooling_water_flow_4_7 @if($errors->has('cooling_water_flow_4_7')) error @endif"  id="cooling_water_flow_4_7" name="cooling_water_flow_4_7" value="{{ old('cooling_water_flow_4_7') }}">
@if($errors->has('cooling_water_flow_4_7'))  <em class="error">{{ $errors->first('cooling_water_flow_4_7') }}</em> @endif

    </td>
</tr>






<tr>
    <td colspan="5" style="text-align: left;"> Water Flow Rate </td>
    <td colspan="1" style="text-align: left;"> m3/h </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control water_flow_rate_1_7 @if($errors->has('water_flow_rate_1_7')) error @endif"  id="water_flow_rate_1_7" name="water_flow_rate_1_7" value="{{ old('water_flow_rate_1_7') }}">
@if($errors->has('water_flow_rate_1_7'))  <em class="error">{{ $errors->first('water_flow_rate_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control water_flow_rate_2_7 @if($errors->has('water_flow_rate_2_7')) error @endif"  id="water_flow_rate_2_7" name="water_flow_rate_2_7" value="{{ old('water_flow_rate_2_7') }}">
@if($errors->has('water_flow_rate_2_7'))  <em class="error">{{ $errors->first('water_flow_rate_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control water_flow_rate_3_7 @if($errors->has('water_flow_rate_3_7')) error @endif"  id="water_flow_rate_3_7" name="water_flow_rate_3_7" value="{{ old('water_flow_rate_3_7') }}">
@if($errors->has('water_flow_rate_3_7'))  <em class="error">{{ $errors->first('water_flow_rate_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control water_flow_rate_4_7 @if($errors->has('water_flow_rate_4_7')) error @endif"  id="water_flow_rate_4_7" name="water_flow_rate_4_7" value="{{ old('water_flow_rate_4_7') }}">
@if($errors->has('water_flow_rate_4_7'))  <em class="error">{{ $errors->first('water_flow_rate_4_7') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Excess Ozone in water </td>
    <td colspan="1" style="text-align: left;"> mg/l </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control excess_ozone_in_water_1_7 @if($errors->has('excess_ozone_in_water_1_7')) error @endif"  id="excess_ozone_in_water_1_7" name="excess_ozone_in_water_1_7" value="{{ old('excess_ozone_in_water_1_7') }}">
@if($errors->has('excess_ozone_in_water_1_7'))  <em class="error">{{ $errors->first('excess_ozone_in_water_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control excess_ozone_in_water_2_7 @if($errors->has('excess_ozone_in_water_2_7')) error @endif"  id="excess_ozone_in_water_2_7" name="excess_ozone_in_water_2_7" value="{{ old('excess_ozone_in_water_2_7') }}">
@if($errors->has('excess_ozone_in_water_2_7'))  <em class="error">{{ $errors->first('excess_ozone_in_water_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control excess_ozone_in_water_3_7 @if($errors->has('excess_ozone_in_water_3_7')) error @endif"  id="excess_ozone_in_water_3_7" name="excess_ozone_in_water_3_7" value="{{ old('excess_ozone_in_water_3_7') }}">
@if($errors->has('excess_ozone_in_water_3_7'))  <em class="error">{{ $errors->first('excess_ozone_in_water_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control excess_ozone_in_water_4_7 @if($errors->has('excess_ozone_in_water_4_7')) error @endif"  id="excess_ozone_in_water_4_7" name="excess_ozone_in_water_4_7" value="{{ old('excess_ozone_in_water_4_7') }}">
@if($errors->has('excess_ozone_in_water_4_7'))  <em class="error">{{ $errors->first('excess_ozone_in_water_4_7') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="5" style="text-align: left;"> Running time </td>
    <td colspan="1" style="text-align: left;"> hour </td>
    <td colspan="1" style="text-align: left;">

    <input type="number" step="any" class="form-control running_time_1_7 @if($errors->has('running_time_1_7')) error @endif"  id="running_time_1_7" name="running_time_1_7" value="{{ old('running_time_1_7') }}">
@if($errors->has('running_time_1_7'))  <em class="error">{{ $errors->first('running_time_1_7') }}</em> @endif

</td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control running_time_2_7 @if($errors->has('running_time_2_7')) error @endif"  id="running_time_2_7" name="running_time_2_7" value="{{ old('running_time_2_7') }}">
@if($errors->has('running_time_2_7'))  <em class="error">{{ $errors->first('running_time_2_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control running_time_3_7 @if($errors->has('running_time_3_7')) error @endif"  id="running_time_3_7" name="running_time_3_7" value="{{ old('running_time_3_7') }}">
@if($errors->has('running_time_3_7'))  <em class="error">{{ $errors->first('running_time_3_7') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;">


    <input type="number" step="any" class="form-control running_time_4_7 @if($errors->has('running_time_4_7')) error @endif"  id="running_time_4_7" name="running_time_4_7" value="{{ old('running_time_4_7') }}">
@if($errors->has('running_time_4_7'))  <em class="error">{{ $errors->first('running_time_4_7') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="10" style="text-align: left;"> 
    Note : <br>

    <textarea class="form-control noted @if($errors->has('noted')) error @endif"  id="noted" name="noted">{{ old('noted') }}</textarea>
    @if($errors->has('noted'))  <em class="error">{{ $errors->first('noted') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="10" style="text-align: left;">file : <br> 
        <input type="file" class="form-control file @if($errors->has('file')) error @endif" id="file " name="file" value="{{ old('file') }}">
        @if($errors->has('file'))  <em class="error">{{ $errors->first('file') }}</em> @endif 
    </td>
</tr>
  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> 
        <input type="number" step="any" class="form-control reminder @if($errors->has('reminder')) error @endif" id="reminder " name="reminder" value="{{ old('reminder') ?? 0 }}">
        @if($errors->has('reminder'))  <em class="error">{{ $errors->first('reminder') }}</em> @endif 
    </td>
</tr>


<tr>
    <td colspan="10" style="text-align: left;"> 
    <a href="/jadwal-proses/{{ Crypt::encrypt($data->id) }}"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
    <input class="submit btn btn-danger" type="submit" value="Submit"> 
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