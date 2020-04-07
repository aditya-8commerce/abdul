@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Detail Form Tidak Masuk</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">

        <div class="col-md-12">
                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>NO FORM</label>
                    <br>
                    <h3>{{ 'CT-'.sprintf("%010d", $data->id) }}</h3>
                </div>
        </div>

            <div class="col-md-12">
                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <label>TANGGAL FORM</label>
                        <br>
                        <h3>{{$data->created_at}}</h3>
                    </div>
            </div>

			<div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>NIK</label>
					<br>
					<h3>{{$data->user->indentity_number}}</h3>
                </div>
            </div>
            
            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>NAMA</label>
					<br>
					<h3>{{$data->user->name}}</h3>
                </div>
            </div>
            
            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>DIVISI</label>
					<br>
					<h3>{{$data->user->divisi->name}}</h3>
                </div>
            </div>
            
            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>JABATAN</label>
					<br>
					<h3>{{$data->user->posisi->name}}</h3>
                </div>
            </div>

            <div class="col-md-6">
				
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>TANGGAL MULAI</label>
					<br>
					<h3>{{$data->date_start}}</h3>
                </div>
            </div>
            
            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>TANGGAL SELESAI</label><br>
					<h3>{{$data->date_finish}}</h3>
                </div>
            </div>
				
            
            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>KATEGORI IJIN</label><br>
					<h3>{{$data->reason}}</h3>
                </div>
            </div>
				
            
            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>KETERANGAN</label><br>
					<h3>{{$data->description}}</h3>
                </div>
            </div>

            
            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>JUMLAH HARI TIDAK MASUK</label><br>
					<h3>{{$data->total_days}} Hari</h3>
                </div>
            </div>

            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>JUMLAH CUTI</label><br>
					<h3>{{$data->remaining_days_off}} Hari</h3>
                </div>
            </div>


            <div class="col-md-6">
            
            @if($data->piece == "cuti")
                @php
                    $sisa = $data->remaining_days_off - $data->total_days;
                @endphp
            @else
                @php
                    $sisa = $data->remaining_days_off;
                @endphp
            @endif
            
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>SISA CUTI</label><br>
					<h3>{{$sisa}} Hari</h3>
                </div>
            </div>


            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>POTONGAN</label><br>
					<h3>{{$data->piece}}</h3>
                </div>
            </div>



            <div class="col-md-6">

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>APPROVED ATASAN</label><br>
					<h3>{{$data->approve_by_leader}}</h3><br><br>
					<h3>{{$data->approve_status_by_leader}}</h3>
                </div>
            </div>

            <div class="col-md-6">

                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>APPROVED DIREKSI</label><br>
					<h3>{{$data->approve_by_director}}</h3><br><br>
					<h3>{{$data->approve_status_by_director}}</h3>
                </div>
            </div>


			</div>
			  
			<div class="col-md-12">
                <a href="/list-form-tidak-masuk"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
            </div>

		</div>
	</div>
</div>
</div>


@endsection