@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
        <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data Divisi</h3> <a href="/divisi/create"><input class="submit btn btn-primary" type="button" value="Tambah Data"></a></div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <div id="datatables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row">
					  <div class="col-sm-12">
					  <form class="cmxform" method="get" action="/divisi" novalidate="novalidate">
					  <div id="datatables-example_filter" class="dataTables_filter">
					  <label>Search:<input type="search" name="filter" class="form-control input-sm" placeholder="Nama Divisi" aria-controls="datatables-example" value="{{ Request::get('filter') }}"></label>
					 
					 
					  <label> 
					  <input class="submit btn btn-warning" type="submit" value="Cari">
					  <a href="/divisi"><input class="submit btn btn-danger" type="button" value="Reset"></a></label>
					  </div>
					  </form>
					  </div>
					  </div>
					  <div class="row"><div class="col-sm-12">
					  <table id="datatables-example" class="table table-striped table-bordered dataTable no-footer" width="100%" cellspacing="0" role="grid" aria-describedby="datatables-example_info" style="width: 100%;">
                      <thead>
                        <tr>
							<th>No</th>
							<th>Nama Divisi</th>
							<th>Jumlah Pekerja</th>
							<th>Aksi</th>
						</tr>
                      </thead>
					  @if(isset($divisions))
                      <tbody>
					  @foreach ($divisions as $division)
					  
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $division->name }}</td>
                          <td>{{ $division->listUsers->count() }}</td>
                          <td>  <a href="/divisi/{{ Crypt::encrypt($division->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah Data"></a> | <a onclick="event.preventDefault();document.getElementById('delete-form-{{ $loop->iteration }}').submit();"><input class="submit btn btn-danger" type="button" value="Hapus Data"></a> </td>
						<form id="delete-form-{{ $loop->iteration }}" method="POST" action="/divisi/{{ $division->id }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
						</form>
                        </tr>
						 @endforeach
						</tbody>
                        </table>
						
						</div></div><div class="row">
						<div class="col-sm-5"><div class="dataTables_info" id="datatables-example_info" role="status" aria-live="polite">total {{$total}} entries</div></div>
						<div class="col-sm-7">
						<div class="dataTables_paginate paging_simple_numbers" id="datatables-example_paginate">
						{!! $divisions->render() !!}
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