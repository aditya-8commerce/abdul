@extends('layouts.dashboard')
@section('content_dashboard')

<!--  jQuery -->
<link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/select2.min.css') }}"/>
<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('/miminium/js/plugins/select2.full.min.js') }}"></script> 
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.css') }}"/>

<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Edit Form Jadwal Sementara</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/jadwal-sementara/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
            <input name="_method" type="hidden" value="PUT"> 
            @csrf
			<div class="col-md-12">


            
				<div class="form-group form-animate-text @if($errors->has('kode_pelanggan')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="kode_pelanggan form-text @if($errors->has('kode_pelanggan')) error @endif" id="kode_pelanggan" name="kode_pelanggan" required="" aria-required="true">
					<option value=""> </option>
                    @foreach ($customers as $d)
						<option value="{{$d->id}}" @if(old('kode_pelanggan') == $d->id || $data->id_customer == $d->id ) selected="selected" @endif>{{$d->name.' / '.$d->code}}</option>
					@endforeach
						
					</select>
					<span class="bar"></span>
                    <label>Nama Customer</label>
					@if($errors->has('kode_pelanggan'))  <em class="error">{{ $errors->first('kode_pelanggan') }}</em> @endif
                </div>


				<div class="form-group form-animate-text @if($errors->has('tipe_pelayanan')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="tipe_pelayanan form-text @if($errors->has('tipe_pelayanan')) error @endif" id="tipe_pelayanan" name="tipe_pelayanan" required="" aria-required="true">
					<option value="datang langsung" @if(old('tipe_pelayanan') == 'datang langsung' || $data->service_type == 'datang langsung' ) selected="selected" @endif>Datang Langsung</option>
                    <option value="melalui telpon" @if(old('tipe_pelayanan') == 'melalui telpon' || $data->service_type == 'melalui telpon') selected="selected" @endif>Melalui Telpon</option>
					</select>
					<span class="bar"></span>
                    <label>Tipe Pelayanan</label>
					@if($errors->has('tipe_pelayanan'))  <em class="error">{{ $errors->first('tipe_pelayanan') }}</em> @endif
                </div>

				<div class="form-group form-animate-text @if($errors->has('tanggal_mulai')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text tanggal_mulai @if($errors->has('tanggal_mulai')) error @endif" data-date-format="yyyy-mm-dd hh:ii" id="tanggal_mulai" name="tanggal_mulai" required="" aria-required="true" value="{{ old('tanggal_mulai') ?? $data->date_start }}">
					<span class="bar"></span>
                    <label>Tanggal Mulai</label>
					@if($errors->has('tanggal_mulai'))  <em class="error">{{ $errors->first('tanggal_mulai') }}</em> @endif
                </div>

            <div class="form-group form-animate-text @if($errors->has('tanggal_selesai')) form-animate-error @endif" style="margin-top:40px !important;">
                <input type="text" class="form-text tanggal_selesai @if($errors->has('tanggal_selesai')) error @endif" data-date-format="yyyy-mm-dd hh:ii" id="tanggal_selesai" name="tanggal_selesai" required="" aria-required="true" value="{{ old('tanggal_selesai') ?? $data->date_finish }}">
                <span class="bar"></span>
                <label>Tanggal Selesai</label>
                @if($errors->has('tanggal_selesai'))  <em class="error">{{ $errors->first('tanggal_selesai') }}</em> @endif
            </div> 

            <div class="form-group form-animate-text @if($errors->has('teknisi')) form-animate-error @endif" style="margin-top:40px !important;">
            <label>Teknisi</label>
                <br>
                <br>
                <br>
                <select name="teknisi[]" id="teknisi[]" class="select2-B form-text" multiple="multiple">
                @foreach ($users as $d)
                    <option value="{{$d->id}}" @if(old('teknisi') == $d->id) selected="selected" @endif>{{$d->name .'('.$d->indentity_number.')'}}</option>
                @endforeach
                </select>
                @if($errors->has('teknisi'))  <em class="error">{{ $errors->first('teknisi') }}</em> @endif
            </div>	
             
			</div>
			  
			<div class="col-md-12">
                <a href="/jadwal-sementara"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div>

<script type="text/javascript">
    "use strict";
    $('.tanggal_mulai').datetimepicker({
       //language:  'fr',
       format:'yyyy-mm-dd hh:ii:00',
       weekStart: 1,
       todayBtn:  1,
       autoclose: 1,
       todayHighlight: 1,
       startView: 2,
       forceParse: 0,
       showMeridian: 1
   });
    $('.tanggal_selesai').datetimepicker({
       //language:  'fr',
       format:'yyyy-mm-dd hh:ii:00',
       weekStart: 1,
       todayBtn:  1,
       autoclose: 1,
       todayHighlight: 1,
       startView: 2,
       forceParse: 0,
       showMeridian: 1
   });
   
   <?php 
        $dataId = json_encode($data->users);
        $array = array_column(json_decode($dataId,TRUE),'id_user');
    ?>

   var selectedValues = <?php echo json_encode($array);?>;

    
   var s2 =  $(".select2-B").select2({
      tags: true
    });
 
    s2.val(selectedValues).trigger("change"); 
</script>

@endsection