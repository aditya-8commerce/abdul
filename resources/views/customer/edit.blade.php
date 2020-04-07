@extends('layouts.dashboard')
@section('content_dashboard')

<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Edit Data Pelanggan</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/pelanggan/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
            <input name="_method" type="hidden" value="PUT"> 
            @csrf
			<div class="col-md-12">
			
            <div class="form-group form-animate-text @if($errors->has('kode_pelanggan')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('kode_pelanggan')) error @endif" id="kode_pelanggan" name="kode_pelanggan" required="" aria-required="true" value="{{ $data->code }}">
					<span class="bar"></span>
                    <label>Kode Pelanggan</label>
					@if($errors->has('kode_pelanggan'))  <em class="error">{{ $errors->first('kode_pelanggan') }}</em> @endif
            </div>

            <div class="form-group form-animate-text @if($errors->has('nama_pelanggan')) form-animate-error @endif" style="margin-top:40px !important;">
                <input type="text" class="form-text @if($errors->has('nama_pelanggan')) error @endif" id="nama_pelanggan" name="nama_pelanggan" required="" aria-required="true" value="{{ $data->name }}">
                <span class="bar"></span>
                <label>Nama Pelanggan</label>
                @if($errors->has('nama_pelanggan'))  <em class="error">{{ $errors->first('nama_pelanggan') }}</em> @endif
            </div>

				

            <div class="form-group form-animate-text @if($errors->has('email_pelanggan')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="email" class="form-text @if($errors->has('email_pelanggan')) error @endif" id="email_pelanggan" name="email_pelanggan" required="" aria-required="true" value="{{ $data->email }}">
					<span class="bar"></span>
                    <label>Email</label>
					@if($errors->has('email_pelanggan'))  <em class="error">{{ $errors->first('email_pelanggan') }}</em> @endif
            </div>
				
            <div class="form-group form-animate-text @if($errors->has('telepon_pelanggan')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('telepon_pelanggan')) error @endif" id="telepon_pelanggan" name="telepon_pelanggan" required="" aria-required="true" pattern="\+?([ -]?\d+)+|\(\d+\)([ -]\d+)" maxlength="20" value="{{ $data->phone }}"  title="Masukan no telpon / handtelepon_pelanggan dengan benar">
					<span class="bar"></span>
					<label>Telepon</label>
					@if($errors->has('telepon_pelanggan'))  <em class="error">{{ $errors->first('telepon_pelanggan') }}</em> @endif
			</div>
				 
				<div class="form-group form-animate-text @if($errors->has('alamat_pelanggan')) form-animate-error @endif" style="margin-top:40px !important;">
					<textarea class="form-text @if($errors->has('alamat_pelanggan')) error @endif" id="alamat_pelanggan" name="alamat_pelanggan" required="" aria-required="true">{{ $data->address }}</textarea>
					<span class="bar"></span>
					<label>Alamat</label>
					@if($errors->has('alamat_pelanggan'))  <em class="error">{{ $errors->first('alamat_pelanggan') }}</em> @endif
				</div>
				
			</div>
			  
			<div class="col-md-12">
                <a href="/pelanggan"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div>


@endsection