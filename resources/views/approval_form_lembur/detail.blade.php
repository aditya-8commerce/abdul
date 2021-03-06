@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Detail Approval Form Tidak Masuk</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
        <form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/persetujuan-form-lembur/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
        <input name="_method" type="hidden" value="PUT">
        @csrf
            <div class="col-md-6">
                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <label>NO FORM</label>
                        <br>
                        <h3>{{ 'LB-'.sprintf("%010d", $data->id) }}</h3>
                    </div>
            </div>

            <div class="col-md-6">
                    <div class="form-group form-animate-text" style="margin-top:40px !important;">
                        <label>TANGGAL FORM</label>
                        <br>
                        <h3>{{$data->created_at}}</h3>
                    </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>NAMA CUSTOMER</label>
                    <br>
                    <h3>{{$data->customer_name}}</h3>
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
                    <label>TOTAL JAM</label><br>
					<h3>{{$data->total_hours}}</h3>
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
                    <label>APPROVED ATASAN</label><br><br>
                    @if(empty($data->approve_status_by_leader) && strtolower(Auth::user()->posisi->name) == 'head')
                  
                    <div> <input name="status" class="submit btn btn-primary" type="submit" value="Setuju"> <input  name="status" class="submit btn btn-danger" type="submit" value="Tolak"> </div>
                   
                    @else
                        <h3>{{$data->approve_by_leader}}</h3>
                        <h3>{{$data->approve_status_by_leader}}</h3>
                    @endif

                    @if(strtolower(Auth::user()->posisi->name) == 'administrator')
                     <div> <input name="status" class="submit btn btn-primary" type="submit" value="Setuju"> <input  name="status" class="submit btn btn-danger" type="submit" value="Tolak"> </div>
                    @endif
                    
                </div>
            </div>

            <div class="col-md-6">

                <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>APPROVED DIREKSI</label><br><br>
                    @if(empty($data->approve_by_director) && strtolower(Auth::user()->posisi->name) == 'director')

                    <div> <input name="status_director" class="submit btn btn-primary" type="submit" value="Setuju"> <input  name="status_director" class="submit btn btn-danger" type="submit" value="Tolak"> </div>
                    
                    @else
					<h3>{{$data->approve_by_director}}</h3>
                    <h3>{{$data->approve_status_by_director}}</h3>
                    @endif

                    @if(strtolower(Auth::user()->posisi->name) == 'administrator')
                        <div> <input name="status_director" class="submit btn btn-primary" type="submit" value="Setuju"> <input  name="status_director" class="submit btn btn-danger" type="submit" value="Tolak"> </div>
                     @endif
                </div>
            </div>
            </form>

			</div>
			  
			<div class="col-md-12">
                <a href="/persetujuan-form-lembur"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
            </div>

		</div>
	</div>
</div>
</div>


@endsection