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
	<h4>LAPORAN EMERGENCY</h4>
</div>

<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/laporan-emergency/{{ Crypt::encrypt($data->id) }}/store" autocomplete="off">
@csrf
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    {{$data->emergency->subject}}
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    {{$data->emergency->user->name}}<br>({{$data->emergency->user->indentity_number}})
    </td>
    <td colspan="2" style="text-align: left;">Customer by : <br>
    {{$data->emergency->customer_by}}
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6">
                Model : <br>
                {{$data->emergency->produk->model}}
            </div>
            <div class="col-md-6">
            SN : <br>
                {{$data->emergency->serial_number}}
            </div>
        </div>
    </td>
    <td colspan="4" style="text-align: left;">  
        <div class="col-md-12">
            <div class="col-md-6">
            Running Hours : <br> 
                {{$data->emergency->running_hours}} h
            </div>
            <div class="col-md-6">
            Year : <br>  
                {{$data->emergency->year}} 
            </div>
        </div>
    </td>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6"> Date     : <br> 
                {{$data->emergency->date}}  

            </div>
            <div class="col-md-6"> 
            Working hours : <br>  {{$data->date_start.' ~ '.$data->date_finish}}
            </div>
        </div>
            </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> </td>
    <td colspan="6" style="text-align: left;"> Line : <br> 
                {{$data->emergency->line}}  
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> Issued Problem : <br>

    {{$data->emergency->issue}}  
 

    </td>
    <td colspan="4" style="text-align: left;"> Action : <br> 


    {{$data->emergency->action}}   

    </td>
    <td colspan="3" style="text-align: left;"> Recommendation : <br>


    {{$data->emergency->recommendation}}   
     
    </td>
</tr>


  
<tr>
    <td colspan="10" style="text-align: left;">file : <br> 
    @if($data->emergency->file)
        <a href="/public/laporan/{{ $data->emergency->file }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a>
        @else
        -
        @endif
    </td>
</tr>
  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> 
    {{$data->reminder_service ?? '0'}}  Bulan
              
    </td>
</tr>


<tr>
    <td colspan="10" style="text-align: left;">
    <a href="/jadwal/{{ Crypt::encrypt($data->id) }}"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <a href="/laporan-emergency/{{ Crypt::encrypt($data->id) }}/{{ Crypt::encrypt($data->emergency->id) }}/destroy"><input class="submit btn btn-danger" type="button" value="Hapus"></a>
    <a href="/laporan-emergency/{{ Crypt::encrypt($data->id) }}/update"><input class="submit btn btn-warning" type="button" value="Edit"></a>
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