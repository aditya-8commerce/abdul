@extends('layouts.dashboard')
@section('content_dashboard')

<!--  jQuery -->
<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.min.js') }}"></script>
 

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.css') }}"/>

<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Form Tidak Masuk Kerja</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/form-tidak-masuk" autocomplete="off">
			 @csrf
			<div class="col-md-12">
			@if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')

				<div class="form-group form-animate-text @if($errors->has('kategori_ijin')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="nama_karyawan form-text @if($errors->has('nama_karyawan')) error @endif" id="nama_karyawan" name="nama_karyawan" required="" aria-required="true">
					<option value=""> </option>
					@foreach ($users as $d)
						<option value="{{$d->id.'_'.$d->paid_leave}}" @if(old('nama_karyawan') == $d->id.'_'.$d->paid_leave) selected="selected" @endif>{{$d->name}}</option>
					@endforeach
						
					</select>
					<span class="bar"></span>
                    <label>Nama Karyawan</label>
					@if($errors->has('nama_karyawan'))  <em class="error">{{ $errors->first('nama_karyawan') }}</em> @endif
                </div>
				<input type="hidden" class="id_user form-text" id="id_user" name="id_user" required="" aria-required="true" value="">
				@endif
				
				
				<div class="form-group form-animate-text @if($errors->has('tanggal_mulai')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text tanggal_mulai @if($errors->has('tanggal_mulai')) error @endif" id="tanggal_mulai" name="tanggal_mulai" required="" aria-required="true" value="{{ old('tanggal_mulai') }}">
					<span class="bar"></span>
                    <label>Tanggal Mulai</label>
					@if($errors->has('tanggal_mulai'))  <em class="error">{{ $errors->first('tanggal_mulai') }}</em> @endif
                </div>


				<div class="form-group form-animate-text @if($errors->has('tanggal_selesai')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text tanggal_selesai @if($errors->has('tanggal_selesai')) error @endif" id="tanggal_selesai" name="tanggal_selesai" required="" aria-required="true" value="{{ old('tanggal_selesai') }}">
					<span class="bar"></span>
                    <label>Tanggal Selesai</label>
					@if($errors->has('tanggal_selesai'))  <em class="error">{{ $errors->first('tanggal_selesai') }}</em> @endif
                </div>
 
				 

				<div class="form-group form-animate-text @if($errors->has('kategori_ijin')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="form-text @if($errors->has('kategori_ijin')) error @endif" id="kategori_ijin" name="kategori_ijin" required="" aria-required="true">
						<option value="sakit" @if(old('kategori_ijin') == 'sakit') selected="selected" @endif>Sakit</option>
						<option value="ijin" @if(old('kategori_ijin') == 'ijin') selected="selected" @endif>Ijin</option>
						<option value="cuti" @if(old('kategori_ijin') == 'cuti') selected="selected" @endif>Cuti</option>
					</select>
					<span class="bar"></span>
                    <label>Kategori Ijin</label>
					@if($errors->has('kategori_ijin'))  <em class="error">{{ $errors->first('kategori_ijin') }}</em> @endif
                </div>
 
				 
				<div class="form-group form-animate-text @if($errors->has('keterangan')) form-animate-error @endif" style="margin-top:40px !important;">
					<textarea class="form-text @if($errors->has('keterangan')) error @endif" id="keterangan" name="keterangan" required="" aria-required="true">{{ old('keterangan') }}</textarea>
					<span class="bar"></span>
					<label>Keterangan</label>
					@if($errors->has('keterangan'))  <em class="error">{{ $errors->first('keterangan') }}</em> @endif
				</div>
				
				<div class="form-group form-animate-text @if($errors->has('potongan')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="form-text @if($errors->has('potongan')) error @endif" id="potongan" name="potongan" required="" aria-required="true">
						<option value="gaji" @if(old('potongan') == 'gaji') selected="selected" @endif>Potongan Gaji</option>
						<option value="cuti" @if(old('potongan') == 'cuti') selected="selected" @endif>Potongan Cuti</option>
					</select>
					<span class="bar"></span>
					<label>Potongan</label>
					@if($errors->has('potongan'))  <em class="error">{{ $errors->first('potongan') }}</em> @endif
                </div>
				 
				<div class="form-group" style="margin-top:40px !important;">
				@if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')
					<label>Sisa Cuti <div id="cuti"></div></label>
				@else
				<label>Sisa Cuti <div>{{ Auth::user()->paid_leave }}</div></label>
				@endif	
				</div>
				
				
			</div>
			  
			<div class="col-md-12">
                <a href="/list-form-tidak-masuk"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div>

 <script type="text/javascript">
 	"use strict";
	 
	$('.tanggal_mulai').datepicker({format:'yyyy-mm-dd'});
	$('.tanggal_selesai').datepicker({format:'yyyy-mm-dd'});
	
	
	$(document).ready(function(){
		$("select.nama_karyawan").change(function(){
			var strUser = $(this).children("option:selected").val();
			var userArr = strUser.split('_');
			var idUser	= userArr[0];
			var ttlPaid = userArr[1];
			document.getElementById('id_user').value = idUser;
    		document.getElementById('cuti').innerHTML = ttlPaid;
		});
	});
</script>

@endsection