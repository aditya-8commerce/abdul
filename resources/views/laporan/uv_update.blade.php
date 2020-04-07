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
	<h4>LAPORAN UV</h4>
</div>
<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/laporan-uv/{{ Crypt::encrypt($data->id) }}/{{Crypt::encrypt($data->uv->id)}}/update" autocomplete="off">
@csrf
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>
 
<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    <input type="text" class="form-control subject @if($errors->has('subject')) error @endif"  id="subject" name="subject" required="" aria-required="true" value="{{ old('subject') ?? $data->uv->subject }}">
    @if($errors->has('subject'))  <em class="error">{{ $errors->first('subject') }}</em> @endif
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <select class="id_user form-control @if($errors->has('id_user')) error @endif" id="id_user" name="id_user" required="" aria-required="true">
    <option value=""> </option>
    @foreach ($data->users as $d)
    <option value="{{$d->id_user}}" @if(old('id_user') == $d->id_user || ($data->uv->id_user) == $d->id_user) selected="selected" @endif>{{$d->user->name.' - '.$d->user->indentity_number}}</option>
    @endforeach
    @if($errors->has('id_user'))  <em class="error">{{ $errors->first('id_user') }}</em> @endif			
    </select>
    @else 

    {{Auth::user()->name.' ( '.Auth::user()->indentity_number.' )'}} 

    @endif</td>
    <td colspan="2" style="text-align: left;">Customer by : <br>
    <input type="text" class="form-control customer_by @if($errors->has('customer_by')) error @endif"  id="customer_by" name="customer_by" required="" aria-required="true" value="{{ old('customer_by') ?? $data->uv->customer_by }}">
    @if($errors->has('customer_by'))  <em class="error">{{ $errors->first('customer_by') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="5" style="text-align: left;">Model : <br>
    <select name="model" id="model" class="select2-A form-control">
        @foreach ($produk as $d)
            <option value="{{$d->id}}" @if(old('model') == $d->id || $data->uv->id_product == $d->id) selected="selected" @endif>{{$d->model}}</option>
        @endforeach
    </select>
    </td>
    <td colspan="5" style="text-align: left;">SN : <br>
    <input type="text" class="form-control serial_number @if($errors->has('serial_number')) error @endif"  id="serial_number" name="serial_number" required="" aria-required="true" value="{{ old('serial_number') ?? $data->uv->serial_number }}">
    @if($errors->has('serial_number'))  <em class="error">{{ $errors->first('serial_number') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;">Date     : <br> 
    <input type="text" class="form-control date @if($errors->has('date')) error @endif" data-date-format="yyyy-mm-dd" id="date" name="date" required="" aria-required="true" value="{{ old('date') ?? $data->uv->date }}">
    @if($errors->has('date'))  <em class="error">{{ $errors->first('date') }}</em> @endif
</td>
    <td colspan="3" style="text-align: left;">Mfg : <br>  
    <input type="text" class="form-control mfg @if($errors->has('date')) error @endif" data-date-format="yyyy-mm-dd" id="mfg" name="mfg" required="" aria-required="true" value="{{ old('mfg') ?? $data->uv->mfg }}">
    @if($errors->has('mfg'))  <em class="error">{{ $errors->first('mfg') }}</em> @endif
</td>
    <td colspan="4" style="text-align: left;">Running Hours : <br> 
    <input type="number" class="form-control running_hours @if($errors->has('running_hours')) error @endif"  id="running_hours" name="running_hours" required="" aria-required="true" value="{{ old('running_hours') ?? $data->uv->running_hours }}">
    @if($errors->has('running_hours'))  <em class="error">{{ $errors->first('running_hours') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> </td>
    <td colspan="6" style="text-align: left;"> Line : <br> 
    <input type="text" class="form-control line @if($errors->has('line')) error @endif" id="line" name="line" value="{{ old('line') ?? $data->uv->line }}">
    @if($errors->has('line'))  <em class="error">{{ $errors->first('line') }}</em> @endif
    </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;">Description </td>
    <td colspan="2" style="text-align: left;">Range </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">Result </td>
    <td colspan="2" style="text-align: left;">Reccomendation </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Voltage Input </td>
    <td colspan="2" style="text-align: left;">230V </td>
    <td colspan="2" style="text-align: left;"> Volt</td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control voltage_input @if($errors->has('voltage_input')) error @endif" id="voltage_input " name="voltage_input" value="{{ old('voltage_input') ?? $data->uv->voltage_input }}">
    @if($errors->has('voltage_input'))  <em class="error">{{ $errors->first('voltage_input') }}</em> @endif 
    </td>
    <td colspan="2" rowspan="20" style="text-align: left;"><textarea class="form-control reccomendation @if($errors->has('reccomendation')) error @endif" id="reccomendation " name="reccomendation">{{ old('reccomendation') ?? $data->uv->reccomendation }}</textarea> </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 1 </td>
    <td colspan="2" style="text-align: left;">> Volt </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control output_ballast_1 @if($errors->has('output_ballast_1')) error @endif" id="output_ballast_1 " name="output_ballast_1" value="{{ old('output_ballast_1') ?? $data->uv->output_ballast_1 }}">
    @if($errors->has('output_ballast_1'))  <em class="error">{{ $errors->first('output_ballast_1') }}</em> @endif  </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 2 </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control output_ballast_2 @if($errors->has('output_ballast_2')) error @endif" id="output_ballast_2 " name="output_ballast_2" value="{{ old('output_ballast_2') ?? $data->uv->output_ballast_2 }}">
    @if($errors->has('output_ballast_2'))  <em class="error">{{ $errors->first('output_ballast_2') }}</em> @endif  </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 3 </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control output_ballast_3 @if($errors->has('output_ballast_3')) error @endif" id="output_ballast_3 " name="output_ballast_3" value="{{ old('output_ballast_3') ?? $data->uv->output_ballast_3 }}">
    @if($errors->has('output_ballast_3'))  <em class="error">{{ $errors->first('output_ballast_3') }}</em> @endif  </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 4 </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control output_ballast_4 @if($errors->has('output_ballast_4')) error @endif" id="output_ballast_4 " name="output_ballast_4" value="{{ old('output_ballast_4') ?? $data->uv->output_ballast_4 }}">
    @if($errors->has('output_ballast_4'))  <em class="error">{{ $errors->first('output_ballast_4') }}</em> @endif  </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Frequency </td>
    <td colspan="2" style="text-align: left;">50 </td>
    <td colspan="2" style="text-align: left;">Hz </td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control frequency @if($errors->has('frequency')) error @endif" id="frequency " name="frequency" value="{{ old('frequency') ?? $data->uv->frequency }}">
    @if($errors->has('frequency'))  <em class="error">{{ $errors->first('frequency') }}</em> @endif  </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Monitoring Station ( UV Intensitas ) </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">% </td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control monitoring_station @if($errors->has('monitoring_station')) error @endif" id="monitoring_station " name="monitoring_station" value="{{ old('monitoring_station') ?? $data->uv->monitoring_station }}">
    @if($errors->has('monitoring_station'))  <em class="error">{{ $errors->first('monitoring_station') }}</em> @endif  </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Tempreature</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">°C </td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control tempreature @if($errors->has('tempreature')) error @endif" id="tempreature " name="tempreature" value="{{ old('tempreature') ?? $data->uv->tempreature }}">
    @if($errors->has('tempreature'))  <em class="error">{{ $errors->first('tempreature') }}</em> @endif  </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;">Cable Sensor</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;"></td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control cable_sensor @if($errors->has('cable_sensor')) error @endif" id="cable_sensor " name="cable_sensor" value="{{ old('cable_sensor') ?? $data->uv->cable_sensor }}">
    @if($errors->has('cable_sensor'))  <em class="error">{{ $errors->first('cable_sensor') }}</em> @endif  </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;">Sensor UV</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;"></td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control sensor_uv @if($errors->has('sensor_uv')) error @endif" id="sensor_uv " name="sensor_uv" value="{{ old('sensor_uv') ?? $data->uv->sensor_uv }}">
    @if($errors->has('sensor_uv'))  <em class="error">{{ $errors->first('sensor_uv') }}</em> @endif  </td>
</tr>
 

<tr>
    <td colspan="2" style="text-align: left;">Socket Lamp UV</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;"></td>
    <td colspan="2" style="text-align: left;">
    <input type="text" class="form-control lamp_uv @if($errors->has('lamp_uv')) error @endif" id="lamp_uv " name="lamp_uv" value="{{ old('lamp_uv') ?? $data->uv->lamp_uv }}">
    @if($errors->has('lamp_uv'))  <em class="error">{{ $errors->first('lamp_uv') }}</em> @endif  </td>
</tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Indicator Lamp</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control indicator_lamp @if($errors->has('indicator_lamp')) error @endif" id="indicator_lamp" name="indicator_lamp" value="{{ old('indicator_lamp') ?? $data->uv->indicator_lamp }}">
     @if($errors->has('indicator_lamp'))  <em class="error">{{ $errors->first('indicator_lamp') }}</em> @endif  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Noise Filter</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control noise_filter @if($errors->has('noise_filter')) error @endif" id="noise_filter" name="noise_filter" value="{{ old('noise_filter') ?? $data->uv->noise_filter }}">
     @if($errors->has('noise_filter'))  <em class="error">{{ $errors->first('noise_filter') }}</em> @endif  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Compression Nut</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control compression_nut @if($errors->has('compression_nut')) error @endif" id="compression_nut" name="compression_nut" value="{{ old('compression_nut') ?? $data->uv->compression_nut }}">
     @if($errors->has('compression_nut'))  <em class="error">{{ $errors->first('compression_nut') }}</em> @endif  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">O-Ring</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control o_ring  @if($errors->has('o_ring')) error @endif" id="o_ring" name="o_ring" value="{{ old('o_ring') ?? $data->uv->o_ring }}">
     @if($errors->has('o_ring'))  <em class="error">{{ $errors->first('o_ring') }}</em> @endif  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;"> Supply Voltage to detector ( Red, Blck )</td>
     <td colspan="2" style="text-align: left;"><font style="color:red">5.0</font> </td>
     <td colspan="2" style="text-align: left;">V. DC</td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control supply_voltage_to_detector  @if($errors->has('supply_voltage_to_detector')) error @endif" id="supply_voltage_to_detector" name="supply_voltage_to_detector" value="{{ old('supply_voltage_to_detector') ?? $data->uv->supply_voltage_to_detector }}">
     @if($errors->has('supply_voltage_to_detector'))  <em class="error">{{ $errors->first('supply_voltage_to_detector') }}</em> @endif  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Voltage UV Output ( Grn, Blck )</td>
     <td colspan="2" style="text-align: left;"><font style="color:red">0 - 5.0 </font> </td>
     <td colspan="2" style="text-align: left;">V. DC</td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control voltage_uv_output  @if($errors->has('voltage_uv_output')) error @endif" id="voltage_uv_output" name="voltage_uv_output" value="{{ old('voltage_uv_output') ?? $data->uv->voltage_uv_output }}">
     @if($errors->has('voltage_uv_output'))  <em class="error">{{ $errors->first('voltage_uv_output') }}</em> @endif  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Voltage Temperature ( Wht, Brwn )</td>
     <td colspan="2" style="text-align: left;"><font style="color:red">0 - 2.5 </font> </td>
     <td colspan="2" style="text-align: left;">V. DC</td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control voltage_temperature  @if($errors->has('voltage_temperature')) error @endif" id="voltage_temperature" name="voltage_temperature" value="{{ old('voltage_temperature') ?? $data->uv->voltage_temperature }}">
     @if($errors->has('voltage_temperature'))  <em class="error">{{ $errors->first('voltage_temperature') }}</em> @endif  </td>
 </tr>
 
 

 <tr>
     <td colspan="2" style="text-align: left;">Main Switch</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control main_switch  @if($errors->has('main_switch')) error @endif" id="main_switch" name="main_switch" value="{{ old('main_switch') ?? $data->uv->main_switch }}">
     @if($errors->has('main_switch'))  <em class="error">{{ $errors->first('main_switch') }}</em> @endif  </td>
 </tr>
 
 

 <tr>
     <td colspan="2" style="text-align: left;"> Ex. Fan UV</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;">
     <input type="text" class="form-control fan_uv  @if($errors->has('fan_uv')) error @endif" id="fan_uv" name="fan_uv" value="{{ old('fan_uv') ?? $data->uv->fan_uv }}">
     @if($errors->has('fan_uv'))  <em class="error">{{ $errors->first('fan_uv') }}</em> @endif  </td>
 </tr>
 
 

  
<tr>
    <td colspan="10" style="text-align: left;">file 
        @if($data->uv->file)
        <a href="/public/laporan/{{ $data->uv->file }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a>
        @endif
            <br> 
        <input type="file" class="form-control file @if($errors->has('file')) error @endif" id="file " name="file" value="{{ old('file') }}">
        @if($errors->has('file'))  <em class="error">{{ $errors->first('file') }}</em> @endif 
    </td>
</tr>

<tr>
    <td colspan="10" style="text-align: left;">Remarks : <br> 
    <textarea class="form-control remarks @if($errors->has('remarks')) error @endif" id="remarks " name="remarks" style="width: 100%;">{{ old('remarks') ?? $data->uv->remarks }}</textarea>
    </td>
</tr>

 

  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> 
        <input type="number" class="form-control reminder @if($errors->has('reminder')) error @endif" id="reminder " name="reminder" required="" aria-required="true" value="{{ old('reminder') ?? $data->reminder_service }}">
        @if($errors->has('reminder'))  <em class="error">{{ $errors->first('reminder') }}</em> @endif 
    </td>
</tr>


<tr>
    <td colspan="10" style="text-align: left;">
    <a href="/jadwal/{{ Crypt::encrypt($data->id) }}"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
    <input class="submit btn btn-danger" type="submit" value="Submit"> 
</td>
</tr>
 

</table>

</form>

</div>




<script type="text/javascript">
    "use strict"; 
     
	$('.date').datepicker({format:'yyyy-mm-dd'});
	$('.mfg').datepicker({format:'yyyy-mm-dd'});

   $(".select2-A").select2({
      placeholder: "pilih model",
      allowClear: true
    });

</script>


@endsection