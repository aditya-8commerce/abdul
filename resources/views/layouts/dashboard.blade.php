<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="description" content="@adit_XxX_">
	<meta name="author" content="@adit_XxX_">
	<meta name="keyword" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'App') }}</title>
 
    <!-- start: Css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/bootstrap.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/font-awesome.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/animate.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/nouislider.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/select2.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/ionrangeslider/ion.rangeSlider.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/ionrangeslider/ion.rangeSlider.skinFlat.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/bootstrap-material-datetimepicker.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/style.css') }}"/>
	<!-- end: Css -->

  </head>

 <body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
              <div class="opener-left-menu is-closed">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
              </div>
                <a href="{{ route('home') }}" class="navbar-brand"> 
                 <b>{{ config('app.name', 'App') }}</b>
                </a>
 

              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span>{{ Auth::user()->name }}</span></li>
                  <li class="dropdown avatar-dropdown">
                   <img src="{{ asset('/miminium/img/avatar.jpg') }}" class="img-circle avatar" alt="{{ Auth::user()->name }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="#"><span class="fa fa-user"></span> My Profile</a></li> 
                     <li role="separator" class="divider"></li>
                     <li class="more">
                      <ul>
                        <li><a href="{{ route('profile') }}"><span class="fa fa-cogs"></span></a></li> 
                        <li><a onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="fa fa-power-off "></span></a></li>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                      </ul>
                    </li>
                  </ul>
                </li> 
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">
  
          <!-- start:Left Menu -->
            <div id="left-menu">
              <div class="sub-left-menu scroll" tabindex="5000" style="overflow: hidden; outline: none; width: 0px; display: none;">
                <ul class="nav nav-list">
                    <li><div class="left-bg"></div></li>
                    <li class="time">
                      <h1 class="animated fadeInLeft">21:00</h1>
                      <p class="animated fadeInRight">Sat,October 1st 2029</p>
                    </li>
                    <li class="active ripple">
                      <a href="{{ route('home') }}"><span class="fa-home fa"></span> Beranda
                      </a>
                    </li>
                    


                    <li class="ripple">
                        <a class="tree-toggle nav-header">
                          <span class="fa-bell fa"></span> Jadwal
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list tree">
                            <li><a href="/jadwal-proses">On Process</a></li>
                            @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'administrator')
                            <li><a href="/jadwal-sementara">Sementara</a></li>
                            <li><a href="/jadwal-reminder">Reminder</a></li>
                            <li><a href="/jadwal">Riwayat Jadwal</a></li>
                            <li><a href="/jadwal-teknisi">Teknisi</a></li>
                            @endif
                            
                          </ul>
                    </li>

                    <li class="ripple">
                        <a class="tree-toggle nav-header">
                          <span class="fa-wrench fa"></span> Permintaan Barang
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list tree">
                            <li><a href="/permintaan-barang">Pengajuan</a></li>
                            @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'head' || strtolower(Auth::user()->posisi->name) == 'administrator')
                              <li><a href="/persetujuan-permintaan-barang">Persetujuan</a></li>
                          <li><a href="{{ route('grafikPermintaanBarang') }}">Grafik</a></li>
                            @endif
                          </ul>
                    </li>

                    <li class="ripple">
                      <a href="/produk">
                        <span class="fa-barcode fa"></span> Produk
                      </a>
                    </li>
					          <li class="ripple">
                      <a class="tree-toggle nav-header">
                        <span class="fa-users fa"></span>Karyawan
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                      <ul class="nav nav-list tree">

                      <li class="ripple">
                          <a class="sub-tree-toggle nav-header">
                            Form Tidak Masuk
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list sub-tree">
                          <li><a href="{{ route('tidakMasukIndex') }}">Pengajuan</a></li>
                          @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'head' || strtolower(Auth::user()->posisi->name) == 'administrator')
                          <li><a href="{{ route('ApprovalTidakMasukIndex') }}">Persetujuan</a></li>
                          @endif
                          </ul>
                        </li>

                        <li class="ripple">
                          <a class="sub-tree-toggle nav-header">
                            Form Lembur
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list sub-tree">
                          <li><a href="{{ route('lemburIndex') }}">Pengajuan</a></li>
                          @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'head' || strtolower(Auth::user()->posisi->name) == 'administrator')
                          <li><a href="{{ route('ApprovalLemburIndex') }}">Persetujuan</a></li>
                          @endif
                          </ul>
                        </li>
                         
                          @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director')
                            <li><a href="/user-akses"> List User</a></li>
                          @endif
                      
                    </ul>
                    </li>
                    <li class="ripple">
                      <a href="/pelanggan">
                        <span class="fa-th-large fa"></span> List Pelanggan
                      </a>
                    </li>
                  @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director')
                    <li class="ripple">
                      <a href="/divisi">
                        <span class="fa-tags fa"></span> List Divisi
                      </a>
                    </li>
                    <li class="ripple">
                      <a href="/jabatan">
                        <span class="fa-black-tie fa"></span> List Jabatan
                      </a>
                    </li>
                  @endif

                  </ul>
                </div>
            </div>
          <!-- end: Left Menu -->

  		
          <!-- start: content -->
            <div id="content" style="padding-left: 0px; padding-right: 0px;"> 
                <div class="col-md-12" style="padding:20px;">
                   
					@include('errors.alert') 		
					@yield('content_dashboard')
                  
                     
                </div>
      		  </div>
          <!-- end: content -->

     
          
      </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                 <ul class="nav nav-list">
                    <li><div class="left-bg"></div></li>
                    <li class="time">
                      <h1 class="animated fadeInLeft">21:00</h1>
                      <p class="animated fadeInRight">Sat,October 1st 2029</p>
                    </li>
                    <li class="active ripple">
                      <a href="{{ route('home') }}"><span class="fa-home fa"></span> Beranda
                      </a>
                    </li>
                    


                    <li class="ripple">
                        <a class="tree-toggle nav-header">
                          <span class="fa-bell fa"></span> Jadwal
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list tree">
                            <li><a href="/jadwal-proses">On Process</a></li>
                            @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'administrator')
                            <li><a href="/jadwal-sementara">Sementara</a></li>
                            <li><a href="/jadwal-reminder">Reminder</a></li>
                            <li><a href="/jadwal">Riwayat Jadwal</a></li>
                            <li><a href="/jadwal-teknisi">Teknisi</a></li>
                            @endif
                            
                          </ul>
                    </li>

                    <li class="ripple">
                        <a class="tree-toggle nav-header">
                          <span class="fa-wrench fa"></span> Permintaan Barang
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list tree">
                            <li><a href="/permintaan-barang">Pengajuan</a></li>
                            @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'head' || strtolower(Auth::user()->posisi->name) == 'administrator')
                              <li><a href="/persetujuan-permintaan-barang">Persetujuan</a></li>
                          <li><a href="{{ route('grafikPermintaanBarang') }}">Grafik</a></li>
                            @endif
                          </ul>
                    </li>

                    <li class="ripple">
                      <a href="/produk">
                        <span class="fa-barcode fa"></span> Produk
                      </a>
                    </li>
					          <li class="ripple">
                      <a class="tree-toggle nav-header">
                        <span class="fa-users fa"></span>Karyawan
                        <span class="fa-angle-right fa right-arrow text-right"></span>
                      </a>
                      <ul class="nav nav-list tree">

                      <li class="ripple">
                          <a class="sub-tree-toggle nav-header">
                            Form Tidak Masuk
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list sub-tree">
                          <li><a href="{{ route('tidakMasukIndex') }}">Pengajuan</a></li>
                          @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'head' || strtolower(Auth::user()->posisi->name) == 'administrator')
                          <li><a href="{{ route('ApprovalTidakMasukIndex') }}">Persetujuan</a></li>
                          @endif
                          </ul>
                        </li>

                        <li class="ripple">
                          <a class="sub-tree-toggle nav-header">
                            Form Lembur
                            <span class="fa-angle-right fa right-arrow text-right"></span>
                          </a>
                          <ul class="nav nav-list sub-tree">
                          <li><a href="{{ route('lemburIndex') }}">Pengajuan</a></li>
                          @if(strtolower(Auth::user()->posisi->name) == 'director' || strtolower(Auth::user()->posisi->name) == 'head' || strtolower(Auth::user()->posisi->name) == 'administrator')
                          <li><a href="{{ route('ApprovalLemburIndex') }}">Persetujuan</a></li>
                          @endif
                          </ul>
                        </li>
                         
                          @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director')
                            <li><a href="/user-akses"> List User</a></li>
                          @endif
                      
                    </ul>
                    </li>
                    <li class="ripple">
                      <a href="/pelanggan">
                        <span class="fa-th-large fa"></span> List Pelanggan
                      </a>
                    </li>
                  @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director')
                    <li class="ripple">
                      <a href="/divisi">
                        <span class="fa-tags fa"></span> List Divisi
                      </a>
                    </li>
                    <li class="ripple">
                      <a href="/jabatan">
                        <span class="fa-black-tie fa"></span> List Jabatan
                      </a>
                    </li>
                  @endif

                  </ul>
            </div>
        </div>       
      </div>
      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
      </button>
       <!-- end: Mobile -->
	   
	   
    <script src="{{ asset('/miminium/js/jquery.min.js') }}"></script> 
    <script src="{{ asset('/miminium/js/jquery.ui.min.js') }}"></script> 
    <script src="{{ asset('/miminium/js/bootstrap.min.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/moment.min.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/jquery.knob.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/bootstrap-material-datetimepicker.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/jquery.nicescroll.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/jquery.mask.min.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/select2.full.min.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/nouislider.min.js') }}"></script> 
    <script src="{{ asset('/miminium/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/miminium/js/main.js') }}"></script> 
  </body>
</html>