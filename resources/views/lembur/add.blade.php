@extends('layouts.dashboard')
@section('content_dashboard')

<!--  jQuery -->
<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.css') }}"/>

<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Form Lembur</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/form-lembur" autocomplete="off">
			 @csrf
			<div class="col-md-12">
			@if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')

				<div class="form-group form-animate-text @if($errors->has('nama_karyawan')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="nama_karyawan form-text @if($errors->has('nama_karyawan')) error @endif" id="nama_karyawan" name="nama_karyawan" required="" aria-required="true">
					<option value=""> </option>
					@foreach ($users as $d)
						<option value="{{$d->id}}" @if(old('nama_karyawan') == $d->id) selected="selected" @endif>{{$d->name}}</option>
					@endforeach
						
					</select>
					<span class="bar"></span>
                    <label>Nama Karyawan</label>
					@if($errors->has('nama_karyawan'))  <em class="error">{{ $errors->first('nama_karyawan') }}</em> @endif
                </div>
				@endif
                
                
				<div class="form-group form-animate-text @if($errors->has('nama_customer')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="nama_customer form-text @if($errors->has('nama_customer')) error @endif" id="nama_customer" name="nama_customer" required="" aria-required="true">
					<option value=""> </option>
					@foreach ($customers as $d)
						<option value="{{$d->name}}" @if(old('nama_customer') == $d->name) selected="selected" @endif>{{$d->name}}</option>
					@endforeach
						
					</select>
					<span class="bar"></span>
                    <label>Nama Customer</label>
					@if($errors->has('nama_customer'))  <em class="error">{{ $errors->first('nama_customer') }}</em> @endif
                </div>
				
				<div class="form-group form-animate-text @if($errors->has('tanggal_mulai')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text tanggal_mulai @if($errors->has('tanggal_mulai')) error @endif" data-date-format="yyyy-mm-dd hh:ii" id="tanggal_mulai" name="tanggal_mulai" required="" aria-required="true" value="{{ old('tanggal_mulai') }}">
					<span class="bar"></span>
                    <label>Tanggal Mulai</label>
					@if($errors->has('tanggal_mulai'))  <em class="error">{{ $errors->first('tanggal_mulai') }}</em> @endif
                </div>


				<div class="form-group form-animate-text @if($errors->has('tanggal_selesai')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text tanggal_selesai @if($errors->has('tanggal_selesai')) error @endif" data-date-format="yyyy-mm-dd hh:ii" id="tanggal_selesai" name="tanggal_selesai" required="" aria-required="true" value="{{ old('tanggal_selesai') }}">
					<span class="bar"></span>
                    <label>Tanggal Selesai</label>
					@if($errors->has('tanggal_selesai'))  <em class="error">{{ $errors->first('tanggal_selesai') }}</em> @endif
                </div>
 
				  
				 
				<div class="form-group form-animate-text @if($errors->has('keterangan')) form-animate-error @endif" style="margin-top:40px !important;">
					<textarea class="form-text @if($errors->has('keterangan')) error @endif" id="keterangan" name="keterangan" required="" aria-required="true">{{ old('keterangan') }}</textarea>
					<span class="bar"></span>
					<label>Keterangan</label>
					@if($errors->has('keterangan'))  <em class="error">{{ $errors->first('keterangan') }}</em> @endif
				</div>
				 
			</div>
			  
			<div class="col-md-12">
                <a href="/list-form-lembur"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
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
</script>

@endsection