@extends('layouts.dashboard')
@section('content_dashboard')
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 

    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


<div class="col-md-12 padding-0">
        <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data Tidak Masuk Kerja</h3> <a href="/form-tidak-masuk/create"><input class="submit btn btn-primary" type="button" value="Tambah Data"></a></div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <div id="datatables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row">
					  <div class="col-sm-12">
					  <form class="cmxform" method="get" action="/list-form-tidak-masuk" novalidate="novalidate">
					  <div id="datatables-example_filter" class="dataTables_filter">
					  <label>Search:<input type="search" name="no_form" class="form-control input-sm" placeholder="No Form" aria-controls="datatables-example" value="{{ Request::get('no_form') }}"></label>
				  
					  @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director')
					  <label>Search:<input type="search" name="filter" class="form-control input-sm" placeholder="Nama / NIK" aria-controls="datatables-example" value="{{ Request::get('filter') }}"></label>
				  
					  <label>Divisi:<select name="divisi"><option value=""></option>@foreach ($divions as $d)<option value="{{$d->id}}" @if($d->id == Request::get('divisi')) selected="selected" @endif>{{$d->name}}</option>@endforeach</select></label>
					  
					   <label>Jabatan:<select name="posisi"><option value=""></option>@foreach ($positions as $p)<option value="{{$p->id}}" @if($p->id == Request::get('posisi')) selected="selected" @endif>{{$p->name}}</option>@endforeach</select></label>
					 @endif
					  <label>By Tanggal :<input type="text" name="reportrange" id="reportrange" class="form-control input-sm reportrange" placeholder="Date" aria-controls="datatables-example" value="{{ Request::get('reportrange') }}"></label>
					  <label> 
					  <input class="submit btn btn-warning" type="submit" value="Cari">
					  <a href="/list-form-tidak-masuk"><input class="submit btn btn-danger" type="button" value="Reset"></a></label>
					  <input class="submit btn btn-primary" name="download" type="submit" value="Download">
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
							<th>Tanggal Mulai</th>
							<th>Tanggal Selesai</th>
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
                          <td>{{ 'CT-'.sprintf("%010d", $absent->id) }}</td>
                          <td>{{ $absent->user->indentity_number }}</td>
                          <td>{{ $absent->user->name }}</td>
                          <td>{{ $absent->user->divisi->name }}</td>
                          <td>{{ $absent->user->posisi->name }}</td>
                          <td>{{ $absent->date_start }}</td>
                          <td>{{ $absent->date_finish }}</td>
                          <td>{{ $absent->approve_status_by_leader }}</td>
						  <td>{{ $absent->approve_status_by_director }}</td>
						  
						@if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')
                          <td><a href="/form-tidak-masuk/{{ Crypt::encrypt($absent->id) }}"><input class="submit btn btn-default" type="button" value="Lihat"></a> |  <a href="/form-tidak-masuk/{{ Crypt::encrypt($absent->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah"></a> | <a onclick="event.preventDefault();document.getElementById('delete-form-{{ $loop->iteration }}').submit();"><input class="submit btn btn-danger" type="button" value="Hapus"></a>  | <a href="/form-tidak-masuk/print/{{ Crypt::encrypt($absent->id) }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Print"></a></td>
							<form id="delete-form-{{ $loop->iteration }}" method="POST" action="/form-tidak-masuk/{{ $absent->id }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
						@else
						<td><a href="/form-tidak-masuk/{{ Crypt::encrypt($absent->id) }}"><input class="submit btn btn-default" type="button" value="Lihat"></a> | <a href="/form-tidak-masuk/print/{{ Crypt::encrypt($absent->id) }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Print"></a>
						@if(empty($absent->approve_status_by_leader)) | 
						<a href="/form-tidak-masuk/{{ Crypt::encrypt($absent->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah"></a>
						@endif
						</td>
						@endif


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
 <script type="text/javascript">
	$('.reportrange').daterangepicker({
      	autoUpdateInput: false}, function(start_date,end_date) {
  		$('.reportrange').val(start_date.format('YYYY-MM-DD')+'~'+end_date.format('YYYY-MM-DD'));
	});
</script>
@endsection