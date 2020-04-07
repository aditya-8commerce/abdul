@extends('layouts.dashboard')
@section('content_dashboard')

<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Edit Data Produk</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/produk/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
            <input name="_method" type="hidden" value="PUT">  
            @csrf
			<div class="col-md-12">
			
            <div class="form-group form-animate-text @if($errors->has('kode_produk')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('kode_produk')) error @endif" id="kode_produk" name="kode_produk" required="" aria-required="true" value="{{ $data->code }}">
					<span class="bar"></span>
                    <label>Kode produk</label>
					@if($errors->has('kode_produk'))  <em class="error">{{ $errors->first('kode_produk') }}</em> @endif
            </div>

            <div class="form-group form-animate-text @if($errors->has('nama_produk')) form-animate-error @endif" style="margin-top:40px !important;">
                <input type="text" class="form-text @if($errors->has('nama_produk')) error @endif" id="nama_produk" name="nama_produk" required="" aria-required="true" value="{{ $data->name }}">
                <span class="bar"></span>
                <label>Nama produk</label>
                @if($errors->has('nama_produk'))  <em class="error">{{ $errors->first('nama_produk') }}</em> @endif
            </div>

			
				
            <div class="form-group form-animate-text @if($errors->has('brand')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('brand')) error @endif" id="brand" name="brand" required="" aria-required="true" value="{{ $data->brand }}">
					<span class="bar"></span>
					<label>Brand</label>
					@if($errors->has('brand'))  <em class="error">{{ $errors->first('brand') }}</em> @endif
			</div>
				 
				
            <div class="form-group form-animate-text @if($errors->has('model')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('model')) error @endif" id="model" name="model" required="" aria-required="true" value="{{ $data->model }}">
					<span class="bar"></span>
					<label>Model / Type</label>
					@if($errors->has('model'))  <em class="error">{{ $errors->first('model') }}</em> @endif
			</div>
				 
			</div>
			  
			<div class="col-md-12">
                <a href="/produk"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div>


@endsection