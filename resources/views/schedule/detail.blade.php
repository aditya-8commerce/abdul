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
                    <label>Status</label>
					<br>
					<h3>{{ $data->status }}</h3>
                </div>
            </div>

            

            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Tipe Proses</label>
					<br>
					<h3>{{ $data->type ?? '-' }}</h3>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Reminder</label>
                    <br>
                    <h3>{{ $data->reminder_service ?? '0' }} Bulan</h3>
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
                    <label>Catatan</label>
                    <br>
                    <h3>{{ $data->remarks ?? '-' }}</h3>
                </div>
            </div>
				 
            <div class="col-md-6">
                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Laporan</label>
                    <br>
                    <h3>
                        @if($data->report_type == "uv")
                            <a href="/laporan-uv/{{ Crypt::encrypt($data->id) }}/detail" target="_blank"><input class="submit btn btn-primary" type="button" value="GCU UV"></a>
                        @elseif($data->report_type == "ozon")
                        <a href="/laporan-ozon/{{ Crypt::encrypt($data->id) }}/detail" target="_blank"><input class="submit btn btn-primary" type="button" value="GCU OZON"></a>
                        @elseif($data->report_type == "emergency")
                        <a href="/laporan-emergency/{{ Crypt::encrypt($data->id) }}/detail" target="_blank"><input class="submit btn btn-primary" type="button" value="GCU EMERGENCY"></a>
                        @elseif($data->report_type == "log")
                        <a href="/laporan-log/{{ Crypt::encrypt($data->id) }}/detail" target="_blank"><input class="submit btn btn-primary" type="button" value="GCU LOG"></a>
                        @else
                            -
                        @endif
                    </h3>
                </div>
            </div>



			</div>
			  
			<div class="col-md-12">
                <a href="/jadwal"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
                
            </div>

		</div>
	</div>
</div>
</div>
 
@endsection