@extends('layouts.app')
@section('content_login')

        <form class="form-signin" method="POST" action="{{ route('password.email') }}">
		 @csrf
          <div class="panel periodic-login">
              <div class="panel-body text-center">
                  <p class="element-name">Form Lupa Password</p>
					@if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                  <i class="icons icon-arrow-down"></i>
                  <div class="form-group form-animate-text" style="margin-top:40px !important;">
                  <input id="email" type="email" class="form-text @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    <span class="bar"></span>
                    <label>Email</label>
                  </div>
                   
                  <input type="submit" class="btn col-md-12" value="Kirim Link Reset Password"/>
              </div> 
                <div class="text-center" style="padding:5px;">
                    <a href="/">Login </a>
                </div>
          </div>
        </form>
		
    
@endsection
