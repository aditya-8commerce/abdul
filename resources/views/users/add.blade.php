@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Form User</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/user-akses" autocomplete="off">
			 @csrf
			<div class="col-md-12">

				<div class="form-group form-animate-text @if($errors->has('nik')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('nik')) error @endif" id="nik" name="nik" required="" aria-required="true" value="{{ old('nik') }}">
					<span class="bar"></span>
                    <label>NIK</label>
					@if($errors->has('nik'))  <em class="error">{{ $errors->first('nik') }}</em> @endif
                </div>

				<div class="form-group form-animate-text @if($errors->has('cuti')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="number" class="form-text @if($errors->has('cuti')) error @endif" id="cuti" name="cuti" required="" aria-required="true" value="{{ old('cuti') }}">
					<span class="bar"></span>
                    <label>Total Cuti</label>
					@if($errors->has('cuti'))  <em class="error">{{ $errors->first('cuti') }}</em> @endif
                </div>
				
				<div class="form-group form-animate-text @if($errors->has('divisi')) form-animate-error @endif" style="margin-top:40px !important;">
					<select class="form-text @if($errors->has('divisi')) error @endif" id="divisi" name="divisi" required="" aria-required="true">
						@foreach ($divions as $p)
						<option value="{{$p->id}}" @if($p->id == old('divisi')) selected="selected" @endif>{{$p->name}}</option>@endforeach
					</select>
                    <span class="bar"></span>
                    <label>Divisi</label>
					@if($errors->has('divisi'))  <em class="error">{{ $errors->first('divisi') }}</em> @endif
                </div>

				<div class="form-group form-animate-text @if($errors->has('jabatan')) form-animate-error @endif" style="margin-top:40px !important;">
					<select class="form-text @if($errors->has('jabatan')) error @endif" id="jabatan" name="jabatan" required="" aria-required="true">
						@foreach ($positions as $p)
						<option value="{{$p->id}}" @if($p->id == old('jabatan')) selected="selected" @endif>{{$p->name}}</option>@endforeach
					</select>
                    <span class="bar"></span>
                    <label>Jabatan</label>
					@if($errors->has('jabatan'))  <em class="error">{{ $errors->first('jabatan') }}</em> @endif
                </div>
				
				<div class="form-group form-animate-text @if($errors->has('nama')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('nama')) error @endif" id="nama" name="nama" required="" aria-required="true" value="{{ old('nama') }}">
					<span class="bar"></span>
                    <label>Nama</label>
					@if($errors->has('nama'))  <em class="error">{{ $errors->first('nama') }}</em> @endif
                </div>

				<div class="form-group form-animate-text @if($errors->has('email')) form-animate-error @endif" style="margin-top:40px !important;">
                    <input type="email" class="form-text @if($errors->has('email')) error @endif" id="email" name="email" required="" aria-required="true" value="{{ old('email') }}">
                    <span class="bar"></span>
                    <label>Email</label>
					@if($errors->has('email'))  <em class="error">{{ $errors->first('email') }}</em> @endif
                </div>

				<div class="form-group form-animate-text @if($errors->has('password')) form-animate-error @endif" style="margin-top:40px !important;">
                    <input type="password" class="form-text @if($errors->has('password')) error @endif" id="password" name="password" required="" aria-required="true" value="{{ old('password') }}">
                    <span class="bar"></span>
                    <label>Password</label>
					@if($errors->has('password'))  <em class="error">{{ $errors->first('password') }}</em> @endif
                </div>

				

				<div class="form-group form-animate-text @if($errors->has('phone')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('phone')) error @endif" id="phone" name="phone" required="" aria-required="true" pattern="\+?([ -]?\d+)+|\(\d+\)([ -]\d+)" maxlength="20" value="{{ old('phone') }}"  title="Masukan no telpon / handphone dengan benar">
					<span class="bar"></span>
					<label>Phone</label>
					@if($errors->has('phone'))  <em class="error">{{ $errors->first('phone') }}</em> @endif
				</div>

				<div class="form-group form-animate-text @if($errors->has('alamat')) form-animate-error @endif" style="margin-top:40px !important;">
					<textarea class="form-text @if($errors->has('alamat')) error @endif" id="alamat" name="alamat" required="" aria-required="true">{{ old('alamat') }}</textarea>
					<span class="bar"></span>
					<label>Alamat</label>
					@if($errors->has('alamat'))  <em class="error">{{ $errors->first('alamat') }}</em> @endif
				</div>
				
				<div class="form-group form-animate-text @if($errors->has('foto')) form-animate-error @endif" style="margin-top:40px !important;">
					<label>Foto</label><br><br>
					@if($errors->has('foto'))  <em class="error">{{ $errors->first('foto') }}</em> @endif
					<input type="file" class="form-text @if($errors->has('foto')) error @endif" id="foto" name="foto" multiple accept="image/*">
				</div>
				
				
			</div>
			  
			<div class="col-md-12">
                <a href="/user-akses"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div>


@endsection