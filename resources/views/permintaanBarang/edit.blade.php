@extends('layouts.dashboard')
@section('content_dashboard')

<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Edit Form Permintaan Barang</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/permintaan-barang/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
            <input name="_method" type="hidden" value="PUT"> 
            @csrf
			<div class="col-md-12">
			@if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')

				<div class="form-group form-animate-text @if($errors->has('nama_karyawan')) form-animate-error @endif" style="margin-top:40px !important;">
					
					<select class="nama_karyawan form-text @if($errors->has('nama_karyawan')) error @endif" id="nama_karyawan" name="nama_karyawan" required="" aria-required="true">
					<option value=""> </option>
					@foreach ($users as $d)
						<option value="{{$d->id}}" @if($data->id_user == $d->id) selected="selected" @endif>{{$d->name}}</option>
					@endforeach
						
					</select>
					<span class="bar"></span>
                    <label>Nama Karyawan</label>
					@if($errors->has('nama_karyawan'))  <em class="error">{{ $errors->first('nama_karyawan') }}</em> @endif
                </div>
				@endif
                
                
			  

				<div class="form-group form-animate-text @if($errors->has('nama_proyek')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text @if($errors->has('nama_proyek')) error @endif" id="nama_proyek" name="nama_proyek" required="" aria-required="true" value="{{ $data->name_project }}">
					<span class="bar"></span>
                    <label>Nama Proyek</label>
					@if($errors->has('nama_proyek'))  <em class="error">{{ $errors->first('nama_proyek') }}</em> @endif
                </div>
 

                <div class="col-md-12">
                    <h3>Detail Barang</h3>
                </div>
                <br>
                <br>
                @if(count($data->details) > 0)
                @foreach($data->details as $d)
                <div id="dynamicInput">
                    <div class="form-group form-animate-text @if($errors->has('nama_barang')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="text" class="form-text @if($errors->has('nama_barang')) error @endif" id="nama_barang" name="nama_barang[]" required="" aria-required="true" value="{{ $d->name }}">
                        <span class="bar"></span>
                        <label>Nama Barang</label>
                        @if($errors->has('nama_barang'))  <em class="error">{{ $errors->first('nama_barang') }}</em> @endif
                    </div>

                    <div class="form-group form-animate-text @if($errors->has('qty')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="number" class="form-text @if($errors->has('qty')) error @endif" id="qty" name="qty[]" required="" aria-required="true" value="{{ $d->qty }}">
                        <span class="bar"></span>
                        <label>Qty Barang</label>
                        @if($errors->has('qty'))  <em class="error">{{ $errors->first('qty') }}</em> @endif
                    </div>

                    <div class="form-group form-animate-text @if($errors->has('harga')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="number" class="form-text @if($errors->has('harga')) error @endif" id="harga" name="harga[]" required="" aria-required="true" value="{{ $d->price }}">
                        <span class="bar"></span>
                        <label>Harga Barang</label>
                        @if($errors->has('harga'))  <em class="error">{{ $errors->first('harga') }}</em> @endif
                    </div>
                    
                    <div class="form-group form-animate-text @if($errors->has('keterangan')) form-animate-error @endif" style="margin-top:40px !important;">
                        <textarea class="form-text @if($errors->has('keterangan')) error @endif" id="keterangan" name="keterangan[]" required="" aria-required="true">{{ $d->description }}</textarea>
                        <span class="bar"></span>
                        <label>Keterangan</label>
                        @if($errors->has('keterangan'))  <em class="error">{{ $errors->first('keterangan') }}</em> @endif
                    </div>
                    <div style="text-align:right;margin-right:65px"><a href="/delete-permintaan-barang-detail/{{ Crypt::encrypt($d->id) }}">Hapus</a></div>
                </div>
                @endforeach

                @else
                <div id="dynamicInput">
                    <div class="form-group form-animate-text @if($errors->has('nama_barang')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="text" class="form-text @if($errors->has('nama_barang')) error @endif" id="nama_barang" name="nama_barang[]" required="" aria-required="true" value="{{ old('nama_barang') }}">
                        <span class="bar"></span>
                        <label>Nama Barang</label>
                        @if($errors->has('nama_barang'))  <em class="error">{{ $errors->first('nama_barang') }}</em> @endif
                    </div>

                    <div class="form-group form-animate-text @if($errors->has('qty')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="number" class="form-text @if($errors->has('qty')) error @endif" id="qty" name="qty[]" required="" aria-required="true" value="{{ old('qty') }}">
                        <span class="bar"></span>
                        <label>Qty Barang</label>
                        @if($errors->has('qty'))  <em class="error">{{ $errors->first('qty') }}</em> @endif
                    </div>

                    <div class="form-group form-animate-text @if($errors->has('harga')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="number" class="form-text @if($errors->has('harga')) error @endif" id="harga" name="harga[]" required="" aria-required="true" value="{{ old('harga') }}">
                        <span class="bar"></span>
                        <label>Harga Barang</label>
                        @if($errors->has('harga'))  <em class="error">{{ $errors->first('harga') }}</em> @endif
                    </div>
                    
                    <div class="form-group form-animate-text @if($errors->has('keterangan')) form-animate-error @endif" style="margin-top:40px !important;">
                        <textarea class="form-text @if($errors->has('keterangan')) error @endif" id="keterangan" name="keterangan[]" required="" aria-required="true">{{ old('keterangan') }}</textarea>
                        <span class="bar"></span>
                        <label>Keterangan</label>
                        @if($errors->has('keterangan'))  <em class="error">{{ $errors->first('keterangan') }}</em> @endif
                    </div>
                
                </div>
                @endif
                
			<div class="col-md-12">
                <input type="button" class="submit btn btn-warning" value="Tambah Text Input" onClick="new_link();">
            </div>
<br>
<br><br>        
				
				<div class="form-group form-animate-text @if($errors->has('bukti')) form-animate-error @endif" style="margin-top:40px !important;">
					<label>Bukti</label><br><br>
					@if($errors->has('bukti'))  <em class="error">{{ $errors->first('bukti') }}</em> @endif
					<input type="file" class="form-text @if($errors->has('bukti')) error @endif" id="bukti" name="bukti" multiple accept="image/*">
                    <br><br><br>
                    <a href="/public/permintaan-barang/{{$data->file}}" target="_blank"><input class="submit btn btn-warning" type="button" value="Download"></a>
                </div>
				
				 
			</div>
			  
			<div class="col-md-12">
                <a href="/permintaan-barang"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <input class="submit btn btn-danger" type="submit" value="Submit">
            </div>
			</form>

		</div>
	</div>
</div>
</div> 

<!-- Template. This whole data will be added directly to working form above -->
                <div id="dynamicInputl" style="display:none">
                    <div class="form-group form-animate-text @if($errors->has('nama_barang')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="text" class="form-text @if($errors->has('nama_barang')) error @endif" id="nama_barang" name="nama_barang[]" required="" aria-required="true" value="{{ old('nama_proyek') }}">
                        <span class="bar"></span>
                        <label>Nama Barang</label>
                        @if($errors->has('nama_barang'))  <em class="error">{{ $errors->first('nama_barang') }}</em> @endif
                    </div>

                    <div class="form-group form-animate-text @if($errors->has('qty')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="number" class="form-text @if($errors->has('qty')) error @endif" id="qty" name="qty[]" required="" aria-required="true" value="{{ old('nama_proyek') }}">
                        <span class="bar"></span>
                        <label>Qty Barang</label>
                        @if($errors->has('qty'))  <em class="error">{{ $errors->first('qty') }}</em> @endif
                    </div>

                    <div class="form-group form-animate-text @if($errors->has('harga')) form-animate-error @endif" style="margin-top:40px !important;">
                        <input type="number" class="form-text @if($errors->has('harga')) error @endif" id="harga" name="harga[]" required="" aria-required="true" value="{{ old('nama_proyek') }}">
                        <span class="bar"></span>
                        <label>Harga Satuan Barang</label>
                        @if($errors->has('harga'))  <em class="error">{{ $errors->first('harga') }}</em> @endif
                    </div>
                    
                    <div class="form-group form-animate-text @if($errors->has('keterangan')) form-animate-error @endif" style="margin-top:40px !important;">
                        <textarea class="form-text @if($errors->has('keterangan')) error @endif" id="keterangan" name="keterangan[]" required="" aria-required="true">{{ old('keterangan') }}</textarea>
                        <span class="bar"></span>
                        <label>Keterangan</label>
                        @if($errors->has('keterangan'))  <em class="error">{{ $errors->first('keterangan') }}</em> @endif
                    </div>
            </div>
<script>
/*
This script is identical to the above JavaScript function.
*/
var ct = 1;
function new_link()
{
	ct++;
	var div1 = document.createElement('div');
	div1.id = ct;
	// link to delete extended form elements
	var delLink = '<div style="text-align:right;margin-right:65px"><a href="javascript:delIt('+ ct +')">Hapus</a></div>';
	div1.innerHTML = document.getElementById('dynamicInputl').innerHTML + delLink;
	document.getElementById('dynamicInput').appendChild(div1);
}
// function to delete the newly added set of elements
function delIt(eleId)
{
	d = document;
	var ele = d.getElementById(eleId);
	var parentEle = d.getElementById('dynamicInput');
	parentEle.removeChild(ele);
}
</script>
@endsection