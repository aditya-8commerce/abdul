@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Detail Lembur</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
        <form class="cmxform" id="signupForm" method="post" enctype="multipart/form-data" action="/persetujuan-permintaan-barang/{{ Crypt::encrypt($data->id) }}" autocomplete="off">
        <input name="_method" type="hidden" value="PUT">
        @csrf

            <div class="col-md-6">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>NO FORM</label>
					<br>
					<h3>{{ 'PB-'.sprintf("%010d", $data->id) }}</h3>
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
                    <label>NAMA PROYEK</label>
					<br>
					<h3>{{$data->name_project}}</h3>
                </div>
            </div>
            

            <div class="col-md-6">
				
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>DOWNLOAD BUKTI</label>
                    @if($data->file)
					<br>
					<h3><a href="/public/permintaan-barang/{{$data->file}}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a></h3>
                    @endif
                </div>
            </div>

            <div class="col-md-12">

            <div class="responsive-table">
                <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nama Barang</th>
                          <th>Keterangan</th>
                          <th>QTY</th>
                          <th>Harga Satuan</th>
                          <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sum = 0;
                        @endphp
                    @foreach ($data->details as $d)
                        <tr>
                            <td>{{$d->name}}</td>
                            <td>{{$d->description}}</td>
                            <td>{{$d->qty}}</td>
                            <td>Rp. {{number_format($d->price)}}</td>
                            <td>Rp. {{number_format($d->qty*$d->price)}}</td>
                        </tr>
                        @php
                            $value = $d->qty*$d->price;
                            $sum += $value;
                        @endphp
					@endforeach
                        <tr>
                            <td colspan="4" style="text-align: center;">Total</td>
                            <td>Rp. {{number_format($sum)}}</td>
                        </tr>
                    </tbody>
                </table>
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
                <a href="/persetujuan-permintaan-barang"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
            </div>

		</div>
	</div>
</div>
</div>


@endsection