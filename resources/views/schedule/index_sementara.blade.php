@extends('layouts.dashboard')
@section('content_dashboard')

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<div class="col-md-12 padding-0">
        <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>List Jadwal Sementara</h3> <a href="/jadwal-sementara/create"><input class="submit btn btn-primary" type="button" value="Tambah Data"></a></div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <div id="datatables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row">
					  <div class="col-sm-12">
					  <form class="cmxform" method="get" action="/jadwal-sementara" novalidate="novalidate">
					  <div id="datatables-example_filter" class="dataTables_filter">
					  <label>no jadwal:<input type="search" name="no_jadwal" class="form-control input-sm" placeholder="no jadwal" aria-controls="datatables-example" value="{{ Request::get('no_jadwal') }}"></label>
					 
					  <label>kode pelanggan:<input type="search" name="kode_pelanggan" class="form-control input-sm" placeholder="kode pelanggan" aria-controls="datatables-example" value="{{ Request::get('kode_pelanggan') }}"></label>
					 
					  <label>Tanggal Mulai / Selesai:<input type="text" name="reportrange" id="reportrange" class="form-control input-sm reportrange" placeholder="Date" aria-controls="datatables-example" value="{{ Request::get('reportrange') }}"></label>
					  <label>
					 
					  <label> 
					  <input class="submit btn btn-warning" type="submit" value="Cari">
					  <a href="/jadwal-sementara"><input class="submit btn btn-danger" type="button" value="Reset"></a>
					  <input class="submit btn btn-primary" name="download" type="submit" value="Download">
					</label>
					  </div>
					  </form>
					  </div>
					  </div>
					  <div class="row"><div class="col-sm-12">
					  <table id="datatables-example" class="table table-striped table-bordered dataTable no-footer" width="100%" cellspacing="0" role="grid" aria-describedby="datatables-example_info" style="width: 100%;">
                      <thead>
                        <tr>
							<th>No</th>
							<th>No Jadwal</th>
							<th>Kode Pelanggan</th>
							<th>Tanggal Mulai</th>
							<th>Tanggal Selesai</th>
							<th>Total Jam</th>
							<th>Teknisi</th>
							<th>Aksi</th>
						</tr>
                      </thead>
                      <tbody>
                    @if(isset($datas))
					@foreach ($datas as $d)
					@php
						$date1 = strtotime($d->date_start);
						$date2 = strtotime($d->date_finish);
						$diff = abs($date2 - $date1); 
						$years = floor($diff / (365*60*60*24)); 
						$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
						$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
						$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
  
					@endphp
                      <tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ 'BA-'.sprintf("%010d", $d->id) }}</td>
							<td>{{$d->customer->code}}</td>
                            <td>{{$d->date_start}}</td>
                            <td>{{$d->date_finish}}</td>
                            <td>{{$hours}}</td>
                            <td>
								@if(isset($d->users))
								@foreach ($d->users as $u)
									{{ $u->user->name .' - '. $u->user->indentity_number}}
									<br>
								@endforeach
								@endif
							</td>
							<td>
								<a href="/jadwal-sementara/{{ Crypt::encrypt($d->id) }}"><input class="submit btn btn-primary" type="button" value="Detail Data"></a> |
								<a href="/jadwal-sementara/{{ Crypt::encrypt($d->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah Data"></a>
							</td>
                      </tr>
                    @endforeach
                    @endif


						</tbody>
                        </table>
						
						</div></div><div class="row">
						<div class="col-sm-5"><div class="dataTables_info" id="datatables-example_info" role="status" aria-live="polite">total  {{$total}}  entries</div></div>
						<div class="col-sm-7">
						<div class="dataTables_paginate paging_simple_numbers" id="datatables-example_paginate">
						{!! $datas->render() !!}
						</div>
						</div>
						</div>
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