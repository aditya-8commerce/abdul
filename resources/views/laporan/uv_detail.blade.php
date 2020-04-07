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
<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/laporan-uv/{{ Crypt::encrypt($data->id) }}/store" autocomplete="off">
@csrf
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>
 
<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    {{$data->uv->subject}}
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    {{$data->uv->user->name}}<br>({{$data->uv->user->indentity_number}})</td>
    <td colspan="2" style="text-align: left;">Customer by : <br>
    {{$data->uv->customer_by}}
    </td>
</tr>


<tr>
    <td colspan="5" style="text-align: left;">Model : <br>
       {{$data->uv->produk->model}}
    </td>
    <td colspan="5" style="text-align: left;">SN : <br>
    {{ $data->uv->serial_number }}
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;">Date     : <br> 
    {{$data->uv->date}}
</td>
    <td colspan="3" style="text-align: left;">Mfg : <br>  
    {{$data->uv->mfg}}
</td>
    <td colspan="4" style="text-align: left;">Running Hours : <br> 
    {{$data->uv->running_hours}}
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> </td>
    <td colspan="6" style="text-align: left;"> Line : <br> 
    {{$data->uv->line}}
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
    <td colspan="2" style="text-align: left;"> {{$data->uv->voltage_input}}   </td>
    <td colspan="2" rowspan="20" style="text-align: left;"> {{$data->uv->reccomendation}} </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 1 </td>
    <td colspan="2" style="text-align: left;">> Volt </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->output_ballast_1}} </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 2 </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->output_ballast_2}}  </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 3 </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;">  {{$data->uv->output_ballast_3}} </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Output Ballast 4 </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">Volt </td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->output_ballast_4}}  </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Frequency </td>
    <td colspan="2" style="text-align: left;">50 </td>
    <td colspan="2" style="text-align: left;">Hz </td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->frequency}}   </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Monitoring Station ( UV Intensitas ) </td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">% </td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->monitoring_station}}  </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">Tempreature</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;">°C </td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->tempreature}} </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;">Cable Sensor</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;"></td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->cable_sensor}}  </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;">Sensor UV</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;"></td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->sensor_uv}}  </td>
</tr>
 

<tr>
    <td colspan="2" style="text-align: left;">Socket Lamp UV</td>
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="2" style="text-align: left;"></td>
    <td colspan="2" style="text-align: left;"> {{$data->uv->lamp_uv}}  </td>
</tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Indicator Lamp</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->indicator_lamp}}  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Noise Filter</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->noise_filter}}  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Compression Nut</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;">{{$data->uv->noise_filter}} </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">O-Ring</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"></td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->o_ring}}  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;"> Supply Voltage to detector ( Red, Blck )</td>
     <td colspan="2" style="text-align: left;"><font style="color:red">5.0</font> </td>
     <td colspan="2" style="text-align: left;">V. DC</td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->supply_voltage_to_detector}}  </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Voltage UV Output ( Grn, Blck )</td>
     <td colspan="2" style="text-align: left;"><font style="color:red">0 - 5.0 </font> </td>
     <td colspan="2" style="text-align: left;">V. DC</td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->voltage_uv_output}} </td>
 </tr>
 

 <tr>
     <td colspan="2" style="text-align: left;">Voltage Temperature ( Wht, Brwn )</td>
     <td colspan="2" style="text-align: left;"><font style="color:red">0 - 2.5 </font> </td>
     <td colspan="2" style="text-align: left;">V. DC</td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->voltage_temperature}} </td>
 </tr>
 
 

 <tr>
     <td colspan="2" style="text-align: left;">Main Switch</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->main_switch}}  </td>
 </tr>
 
 

 <tr>
     <td colspan="2" style="text-align: left;"> Ex. Fan UV</td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"> </td>
     <td colspan="2" style="text-align: left;"> {{$data->uv->fan_uv}}  </td>
 </tr>
 
 

  
<tr>
    <td colspan="10" style="text-align: left;">file : <br> 
        @if($data->uv->file)
        <a href="/public/laporan/{{ $data->uv->file }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a>
        @else
        -
        @endif
    </td>
</tr>

<tr>
    <td colspan="10" style="text-align: left;">Remarks : <br>
    {{$data->uv->remarks}} 
   
    </td>
</tr>

 

  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> {{$data->reminder_service}} Bulan
    </td>
</tr>


<tr>
    <td colspan="10" style="text-align: left;">
    <a href="/jadwal/{{ Crypt::encrypt($data->id) }}"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <a href="/laporan-uv/{{ Crypt::encrypt($data->id) }}/{{ Crypt::encrypt($data->uv->id) }}/destroy"><input class="submit btn btn-danger" type="button" value="Hapus"></a>
    <a href="/laporan-uv/{{ Crypt::encrypt($data->id) }}/update"><input class="submit btn btn-warning" type="button" value="Edit"></a>
    @endif
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