@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Form Divisi</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/divisi" autocomplete="off">
			 @csrf
			<div class="col-md-12">

				<div class="form-group form-animate-text @if($errors->has('nama_divisi')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('nama_divisi')) error @endif" id="nama_divisi" name="nama_divisi" required="" aria-required="true" value="{{ old('nama_divisi') }}">
					<span class="bar"></span>
                    <label>Nama Divisi</label>
					@if($errors->has('nama_divisi'))  <em class="error">{{ $errors->first('nama_divisi') }}</em> @endif
                </div>
				
				
				
			</div>
			  
			<div class="col-md-12">
                <a href="/divisi"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div>


@endsection