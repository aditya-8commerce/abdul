@extends('layouts.dashboard')
@section('content_dashboard')
@php
    $date1 = strtotime($data->date_start);
    $date2 = strtotime($data->date_finish);
    $diff = abs($date2 - $date1); 
    $years = floor($diff / (365*60*60*24)); 
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));    
@endphp

<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Detail Jadwal Sementara</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">


            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>NO FORM</label>
					<br>
					<h3>{{ 'BA-'.sprintf("%010d", $data->id) }}</h3>
                </div>
            </div>
 
				 
            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Pelanggan</label>
					<br>
					<h3>{{ $data->customer->name }} <br> <b>{{ $data->customer->code }}</b></h3>
                </div>
            </div>

				 
            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Tipe Pelayanan</label>
					<br>
					<h3>{{ $data->service_type }}</h3>
                </div>
            </div>
				 
            <div class="col-md-6">
                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                <div class="col-md-4">
                    <label>Tanggal Mulai</label>
					<br>
                    <h3>{{ $data->date_start }}</h3>
                </div>
                <div class="col-md-4">
                    <label>Tanggal Selesai</label>
					<br>
                    <h3>{{ $data->date_finish }}</h3>
                </div>
                <div class="col-md-4">
                    <label>Total Jam</label>
					<br>
                    <h3>{{ $hours }}</h3>
                </div>

                </div>
                
            </div>

            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Teknisi</label>
                    <br>
                    @if(isset($data->users))
					    @foreach ($data->users as $u)
                        <h3><b>{{ $u->user->name .' - '. $u->user->indentity_number}}</b></h3>
							<br>
						@endforeach
					@endif
                </div>
            </div>



			</div>
			  
			<div class="col-md-12">
                <a href="/jadwal-sementara"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleStatus">
                    Update Status
                </button>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                    Batalkan Jadwal
                </button>
            </div>

		</div>
	</div>
</div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleStatus" tabindex="-1" role="dialog" aria-labelledby="exampleStatusTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/jadwal-sementara/update-status/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
  @csrf
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleStatusTitle">Update Jadwal Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <div class="form-group form-animate-text @if($errors->has('type')) form-animate-error @endif" style="margin-top:40px !important;">
					
                    <select class="type form-text @if($errors->has('type')) error @endif" id="type" name="type" required="" aria-required="true">
                    <option value="pekerjaan-baru">Pekerjaan Baru / New Project</option>
                    <option value="pemeliharaan">Pemeliharaan / Checkup</option>
                    <option value="darurat">Darurat</option>			
                    </select>
                    <span class="bar"></span>
                    <label>Type Jadwal</label>
                    @if($errors->has('type'))  <em class="error">{{ $errors->first('type') }}</em> @endif
                </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/jadwal-sementara/update-status/batal/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
  @csrf
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalTitle">Pembatalan Jadwal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

		<div class="form-group form-animate-text @if($errors->has('catatan')) form-animate-error @endif" style="margin-top:40px !important;">
			<textarea class="form-text catatan @if($errors->has('catatan')) error @endif" id="catatan" name="catatan" required="" aria-required="true" value="{{ old('catatan') ?? $data->remarks }}"></textarea>
			<span class="bar"></span>
            <label>Catatan</label>
			@if($errors->has('catatan'))  <em class="error">{{ $errors->first('catatan') }}</em> @endif
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </div>
    </form>
  </div>
</div>
@endsection