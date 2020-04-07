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

<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/laporan-emergency/{{ Crypt::encrypt($data->id) }}/{{Crypt::encrypt($data->emergency->id)}}/update" autocomplete="off">
@csrf
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    <input type="text" class="form-control subject @if($errors->has('subject')) error @endif"  id="subject" name="subject" value="{{ old('subject') ?? $data->emergency->subject }}">
    @if($errors->has('subject'))  <em class="error">{{ $errors->first('subject') }}</em> @endif
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <select class="id_user form-control @if($errors->has('id_user')) error @endif" id="id_user" name="id_user" aria-required="true">
    <option value=""> </option>
    @foreach ($data->users as $d)
    <option value="{{$d->id_user}}" @if(old('id_user') == $d->id_user || $data->emergency->id_user == $d->id_user) selected="selected" @endif>{{$d->user->name.' - '.$d->user->indentity_number}}</option>
    @endforeach
    @if($errors->has('id_user'))  <em class="error">{{ $errors->first('id_user') }}</em> @endif			
    </select>
    @else 

    {{Auth::user()->name.' ( '.Auth::user()->indentity_number.' )'}} 

    @endif</td>
    <td colspan="2" style="text-align: left;">Customer by : <br>
    <input type="text" class="form-control customer_by @if($errors->has('customer_by')) error @endif"  id="customer_by" name="customer_by" value="{{ old('customer_by') ?? $data->emergency->customer_by }}">
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
    <input type="text" class="form-control serial_number @if($errors->has('serial_number')) error @endif"  id="serial_number" name="serial_number" value="{{ old('serial_number') ?? $data->emergency->serial_number }}">
    @if($errors->has('serial_number'))  <em class="error">{{ $errors->first('serial_number') }}</em> @endif
            </div>
        </div>
    </td>
    <td colspan="4" style="text-align: left;">  
        <div class="col-md-12">
            <div class="col-md-6">
            Running Hours : <br> 
    <input type="number" step="any" class="form-control running_hours @if($errors->has('running_hours')) error @endif" id="running_hours" name="running_hours" value="{{ old('running_hours') ?? $data->emergency->running_hours }}"> h
    @if($errors->has('running_hours'))  <em class="error">{{ $errors->first('running_hours') }}</em> @endif
            </div>
            <div class="col-md-6">
            Year : <br>  
    <input type="text" class="form-control year @if($errors->has('year')) error @endif" data-date-format="yyyy-mm" id="year" name="year" value="{{ old('year') ?? $data->emergency->year }}">
    @if($errors->has('year'))  <em class="error">{{ $errors->first('year') }}</em> @endif
            </div>
        </div>
    </td>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6"> Date     : <br> 
    <input type="text" class="form-control date @if($errors->has('date')) error @endif" data-date-format="yyyy-mm-dd" id="date" name="date" value="{{ old('date') ?? $data->emergency->date }}">
    @if($errors->has('date'))  <em class="error">{{ $errors->first('date') }}</em> @endif

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
    <input type="text" class="form-control line @if($errors->has('line')) error @endif" id="line" name="line" value="{{ old('line') ?? $data->emergency->line }}">
    @if($errors->has('line'))  <em class="error">{{ $errors->first('line') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="3" style="text-align: left;"> Issued Problem : <br>


    <textarea class="form-control issue @if($errors->has('issue')) error @endif"  id="issue" name="issue">{{ old('issue') ?? $data->emergency->issue }}</textarea>
    @if($errors->has('issue'))  <em class="error">{{ $errors->first('issue') }}</em> @endif

    </td>
    <td colspan="4" style="text-align: left;"> Action : <br> 


    <textarea class="form-control action @if($errors->has('action')) error @endif"  id="action" name="action">{{ old('action') ?? $data->emergency->action }}</textarea>
    @if($errors->has('action'))  <em class="error">{{ $errors->first('action') }}</em> @endif

    </td>
    <td colspan="3" style="text-align: left;"> Recommendation : <br>


    <textarea class="form-control recommendation @if($errors->has('recommendation')) error @endif"  id="recommendation" name="recommendation">{{ old('recommendation') ?? $data->emergency->recommendation }}</textarea>
    @if($errors->has('recommendation'))  <em class="error">{{ $errors->first('recommendation') }}</em> @endif

    </td>
</tr>


  
<tr>
    <td colspan="10" style="text-align: left;">file :  
        @if($data->emergency->file)
        <a href="/public/laporan/{{ $data->emergency->file }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a>
        @endif
        <br> 
        <input type="file" class="form-control file @if($errors->has('file')) error @endif" id="file " name="file" value="{{ old('file') }}">
        @if($errors->has('file'))  <em class="error">{{ $errors->first('file') }}</em> @endif 
    </td>
</tr>
  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> 
        <input type="number" step="any" class="form-control reminder @if($errors->has('reminder')) error @endif" id="reminder " name="reminder" value="{{ old('reminder')  ?? $data->reminder_service }}">
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