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
	<h4>Detail Jadwal</h4>
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


            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Buat Laporan</label>
					<br>
					<h3><a href="/laporan-uv/{{ Crypt::encrypt($data->id) }}/create"><input class="submit btn btn-primary" type="button" value="GCU UV"></a>
					
                    <a href="/laporan-ozon/{{ Crypt::encrypt($data->id) }}/create"><input class="submit btn btn-warning" type="button" value="GCU OZON"></a>
                    
                    <a href="/laporan-log/{{ Crypt::encrypt($data->id) }}/create"><input class="submit btn btn-success" type="button" value="GCU Baru"></a>

					<a href="/laporan-emergency/{{ Crypt::encrypt($data->id) }}/create"><input class="submit btn btn-danger" type="button" value="Emergency"></a>
					
                </h3>
                </div>
            </div>

			</div>
			  
			<div class="col-md-12">
                <a href="/jadwal-proses"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
            </div>

		</div>
	</div>
</div>
</div>

 
@endsection