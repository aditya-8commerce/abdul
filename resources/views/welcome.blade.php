@extends('layouts.app')
@section('content_login')

        <form class="form-signin" method="POST" action="{{ route('login') }}">
		 @csrf
          <div class="panel periodic-login">
              <div class="panel-body text-center">
                  <p class="element-name">PT. Triotirta Karsa Abadi</p>
					@error('email')
					<div class="alert alert-card alert-{{ $message }}" role="alert">
						<strong class="text-capitalize" style="color: red;">{{ $message }}</strong> {{ Session::get('alert-' . $message) }}.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="color: red;">×</span>
						</button>
					</div> 
                    @enderror
					@error('password')
					<div class="alert alert-card alert-{{ $message }}" role="alert">
						<strong class="text-capitalize" style="color: red;">{{ $message }}</strong> {{ Session::get('alert-' . $message) }}.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true" style="color: red;">×</span>
						</button>
					</div> 
                    @enderror
                  <i class="icons icon-arrow-down"></i>
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <input id="email" type="email" class="form-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <span class="bar"></span>
                    <label>Email</label>
                  </div>
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <input id="password" type="password" class="form-text @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    <span class="bar"></span>
                    <label>Password</label>
                  </div>
                  <input type="submit" class="btn col-md-12" value="SignIn"/>
              </div>
                <div class="text-center" style="padding:5px;">
                    <a href="{{ route('password.request') }}">Forgot Password </a>
                </div>
          </div>
        </form>
@endsection