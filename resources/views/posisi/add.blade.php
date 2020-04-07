@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Form Jabatan</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/jabatan" autocomplete="off">
			 @csrf
			<div class="col-md-12">

				<div class="form-group form-animate-text @if($errors->has('nama_jabatan')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('nama_jabatan')) error @endif" id="nama_jabatan" name="nama_jabatan" required="" aria-required="true" value="{{ old('nama_jabatan') }}">
					<span class="bar"></span>
                    <label>Nama Jabatan</label>
					@if($errors->has('nama_jabatan'))  <em class="error">{{ $errors->first('nama_jabatan') }}</em> @endif
                </div>
				
				
				
			</div>
			  
			<div class="col-md-12">
                <a href="/jabatan"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div>


@endsection