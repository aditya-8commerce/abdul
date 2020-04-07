@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
        <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data Permintaan Barang</h3> <a href="/permintaan-barang/create"><input class="submit btn btn-primary" type="button" value="Tambah Data"></a></div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <div id="datatables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row">
					  <div class="col-sm-12">
					  <form class="cmxform" method="get" action="/permintaan-barang" novalidate="novalidate">
					  <div id="datatables-example_filter" class="dataTables_filter">
					  <label>Search:<input type="search" name="filter" class="form-control input-sm" placeholder="No Form / Nama Proyek" aria-controls="datatables-example" value="{{ Request::get('filter') }}"></label>
					 
					 
					  <label> 
					  <input class="submit btn btn-warning" type="submit" value="Cari">
					  <a href="/permintaan-barang"><input class="submit btn btn-danger" type="button" value="Reset"></a></label>
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
							<th>Tanggal Form</th>
							<th>Nama Karyawan</th>
							<th>Nama Proyek</th>
							<th>Persetujuan Atasan</th>
							<th>Persetujuan Direksi</th>
							<th>Aksi</th>
						</tr>
                      </thead>
					  @if(isset($datas))
                      <tbody>
					  @foreach ($datas as $d)
					  
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ 'PB-'.sprintf("%010d", $d->id) }}</td>
                          <td>{{ $d->created_at }}</td>
                          <td>{{ $d->user->name }}</td>
                          <td>{{ $d->name_project }}</td>
                          <td>{{ $d->approve_status_by_leader }}</td>
						  <td>{{ $d->approve_status_by_director }}</td>
						  @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')
						  <td><a href="/permintaan-barang/{{ Crypt::encrypt($d->id) }}"><input class="submit btn btn-default" type="button" value="Lihat"></a> |  
						  <a href="/permintaan-barang/{{ Crypt::encrypt($d->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah"></a> | 
						  <a onclick="event.preventDefault();document.getElementById('delete-form-{{ $loop->iteration }}').submit();"><input class="submit btn btn-danger" type="button" value="Hapus Data"></a></td>
						  <form id="delete-form-{{ $loop->iteration }}" method="POST" action="/permintaan-barang/{{ $d->id }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
						@else
						<td>
							<a href="/permintaan-barang/{{ Crypt::encrypt($d->id) }}"><input class="submit btn btn-default" type="button" value="Lihat"></a> 
							@if(empty($d->approve_status_by_leader)) | 
							|  <a href="/permintaan-barang/{{ Crypt::encrypt($d->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah"></a>
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
						{!! $datas->render() !!}
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