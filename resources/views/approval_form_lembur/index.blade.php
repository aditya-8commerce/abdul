@extends('layouts.dashboard')
@section('content_dashboard')
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 

    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


<div class="col-md-12 padding-0">
        <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data Approval Lembur</h3> </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <div id="datatables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row">
					  <div class="col-sm-12">
					  <form class="cmxform" method="get" action="/persetujuan-form-lembur" novalidate="novalidate">
					  <div id="datatables-example_filter" class="dataTables_filter">	  
					  <label>Search:<input type="search" name="no_form" class="form-control input-sm" placeholder="No Form" aria-controls="datatables-example" value="{{ Request::get('no_form') }}"></label>
				  
					  <label>Search:<input type="search" name="filter" class="form-control input-sm" placeholder="Nama / NIK" aria-controls="datatables-example" value="{{ Request::get('filter') }}"></label>
				  
					  @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director')
				
					  <label>Divisi:<select name="divisi"><option value=""></option>@foreach ($divions as $d)<option value="{{$d->id}}" @if($d->id == Request::get('divisi')) selected="selected" @endif>{{$d->name}}</option>@endforeach</select></label>
					  
					   <label>Jabatan:<select name="posisi"><option value=""></option>@foreach ($positions as $p)<option value="{{$p->id}}" @if($p->id == Request::get('posisi')) selected="selected" @endif>{{$p->name}}</option>@endforeach</select></label>
					 @endif
					 <label> 
					  <input class="submit btn btn-warning" type="submit" value="Cari">
					  <a href="/persetujuan-form-lembur"><input class="submit btn btn-danger" type="button" value="Reset"></a></label>
					  </div>
					  </form>
					  </div>
					  </div>
					  <div class="row"><div class="col-sm-12">
					  <table id="datatables-example" class="table table-striped table-bordered dataTable no-footer" width="100%" cellspacing="0" role="grid" aria-describedby="datatables-example_info" style="width: 100%;">
                      <thead>
                        <tr>
							<th>No</th>
							<th>No. Form</th>
							<th>NIK</th>
							<th>Nama</th>
							<th>Divisi</th>
							<th>Jabatan</th>
							<th>Tanggal Form</th>
							<th>Total Jam</th>
							<th>Nama Customer</th>
							<th>Keterangan</th>
							<th>Persetujuan Atasan</th>
							<th>Persetujuan director</th>
							<th>Aksi</th>
						</tr>
                      </thead>
					  @if(isset($absents))
                      <tbody>
					  @foreach ($absents as $absent)
					  
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ 'LB-'.sprintf("%010d", $absent->id) }}</td>
                          <td>{{ $absent->user->indentity_number }}</td>
                          <td>{{ $absent->user->name }}</td>
                          <td>{{ $absent->user->divisi->name }}</td>
                          <td>{{ $absent->user->posisi->name }}</td>
                          <td>{{ $absent->created_at }}</td>
                          <td>{{ $absent->total_hours }}</td>
                          <td>{{ $absent->customer_name }}</td>
                          <td>{{ $absent->description }}</td>
                          <td>{{ $absent->approve_status_by_leader }}</td>
						  <td>{{ $absent->approve_status_by_director }}</td>
						  
						  <td><a href="/persetujuan-form-lembur/{{ Crypt::encrypt($absent->id) }}"><input class="submit btn btn-default" type="button" value="Lihat"></a> </td>
						


                        </tr>
						 @endforeach
						</tbody>
                        </table>
						
						</div></div><div class="row">
						<div class="col-sm-5"><div class="dataTables_info" id="datatables-example_info" role="status" aria-live="polite">total {{$total}} entries</div></div>
						<div class="col-sm-7">
						<div class="dataTables_paginate paging_simple_numbers" id="datatables-example_paginate">
						{!! $absents->render() !!}
						</div>
						</div>
						</div>
						@endif
						</div>
                      </div>
                  </div>
                </div>
              </div>                  
</div>
@endsection