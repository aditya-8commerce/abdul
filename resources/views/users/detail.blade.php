@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Detail User</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">
			<div class="col-md-12">
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>NIK</label>
					<br>
					<h3>{{$user->indentity_number}}</h3>
                </div>
				
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Total Cuti</label>
					<br>
					<h3>{{$user->paid_leave}}</h3>
                </div>

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Divisi</label><br>
					<h3>{{$user->divisi->name}}</h3>
                </div>

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Jabatan</label>
					<br>
					<h3>{{$user->posisi->name}}</h3>
                </div>
				
				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Nama</label>
					<br>
					<h3>{{$user->name}}</h3>
                </div>

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <label>Email</label>
					<br>
					<h3>{{$user->email}}</h3>
                </div>

				

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
					<label>Phone</label>
					<br>
					<h3>{{$user->phone}}</h3>
				</div>

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
					<label>Alamat</label>
					<br>
					<h3>{{$user->address}}</h3>
				</div>

				<div class="form-group form-animate-text" style="margin-top:40px !important;">
					<label>Foto</label>
					<br>
					<br>
					<br>
					@if(isset($user->photo))
						<img src="{{ asset('/foto/'.$user->photo) }}" class="img-circle avatar" style="height: 100px !important;width: 100px !important;" alt="{{ $user->name }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
					<br>
					<br>	<a href="/user-akses/download-foto/{{$user->photo}}" target="_blank"><input class="submit btn btn-warning" type="button" value="download Foto"></a>				
						@else
						<img src="{{ asset('/miminium/img/avatar.jpg') }}" class="img-circle avatar" style="height: 100px !important;width: 100px !important;" alt="{{ $user->name }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
						@endif
				</div>
				
				
			</div>
			  
			<div class="col-md-12">
                <a href="/user-akses"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
            </div>

		</div>
	</div>
</div>
</div>


@endsection