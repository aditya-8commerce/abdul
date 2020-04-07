@extends('layouts.app')
@section('content_login')
 <form class="form-signin" method="POST" action="{{ route('password.update') }}">
		 @csrf
		 <input type="hidden" name="token" value="{{ $token }}">
          <div class="panel periodic-login">
              <div class="panel-body text-center">
                  <p class="element-name">Form Reset Password</p>
                  <i class="icons icon-arrow-down"></i>
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                    <input id="email" type="email" class="form-text @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    <span class="bar"></span>
                    <label>Email</label>
                  </div>
				  
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                     <input id="password" type="password" class="form-text @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    <span class="bar"></span>
                    <label>Password</label>
                  </div>
				  
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                       <input id="password-confirm" type="password" class="form-text" name="password_confirmation" required autocomplete="new-password">
                    <span class="bar"></span>
                    <label>Password Konfirmasi</label>
                  </div>
                   
                  <input type="submit" class="btn col-md-12" value="Reset Password"/>
              </div> 
                <div class="text-center" style="padding:5px;">
                    <a href="/">Login </a>
                </div>
          </div>
        </form>
@endsection
