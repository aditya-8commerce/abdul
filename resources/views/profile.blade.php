@extends('layouts.dashboard')
@section('content_dashboard')
<div class="col-md-12 padding-0">
	<div class="col-md-12 panel">
		<div class="col-md-12 panel-heading">
            <h4>Rubah Password</h4>
        </div>
        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
            <div class="col-md-12">
                <form class="cmxform" method="post" action="{{ route('changePassword') }}">
				 @csrf
                    <div class="col-md-6">
                      <div class="form-group form-animate-text" style="margin-top:40px !important;">
                            <input type="password" class="form-text" id="password" name="password" required="" aria-required="true">
                             <span class="bar"></span>
                            <label>Password</label>
                         </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-animate-text" style="margin-top:40px !important;">
                              <input type="password" class="form-text" id="password_confirmation" name="password_confirmation" required="" aria-required="true">
                              <span class="bar"></span>
                              <label>Confirm Password</label>
                            </div>
                    </div>
                    
                                          
                    <div class="col-md-12">
                        <input class="submit btn btn-danger" type="submit" value="Submit">
                    </div>
                </form>

            </div>
        </div>
    </div>     
	<div class="col-md-12 panel">
		<div class="col-md-12 panel-heading">
            <h4>Profile</h4>
        </div>
        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
            <div class="col-md-12">
                    <div class="col-md-6">
                        <label>Foto</label> <br>
						@if(isset(Auth::user()->photo))
						<img src="{{ asset('/foto/'.Auth::user()->photo) }}" class="img-circle avatar" style="height: 100px !important;width: 100px !important;" alt="{{ Auth::user()->name }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>							
						@else
						<img src="{{ asset('/miminium/img/avatar.jpg') }}" class="img-circle avatar" style="height: 100px !important;width: 100px !important;" alt="{{ Auth::user()->name }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
						@endif
                    </div>
                    <div class="col-md-6">
                        <label>NIK</label> <br>
						<h3>{{ Auth::user()->indentity_number }}</h3>
                    </div>
                    <div class="col-md-6">
                        <label>NAMA</label> <br>
						<h3>{{ Auth::user()->name }}</h3>
                    </div>
                    <div class="col-md-6">
                        <label>DIVISI</label> <br>
						<h3>{{ Auth::user()->divisi->name }}</h3>
                    </div>
                    <div class="col-md-6">
                        <label>JABATAN</label> <br>
						<h3>{{ Auth::user()->posisi->name }}</h3>
                    </div>
                    <div class="col-md-6">
                        <label>EMAIL</label> <br>
						<h3>{{ Auth::user()->email }}</h3>
                    </div>
                    <div class="col-md-6">
                        <label>PHONE</label> <br>
						<h3>{{ Auth::user()->phone }}</h3>
                    </div>

                    <div class="col-md-6">
                        <label>ALAMAT</label> <br>
						<h3>{{ Auth::user()->address }}</h3>
                    </div>

                       

            </div>
        </div>
    </div>                           
</div>
 

@endsection