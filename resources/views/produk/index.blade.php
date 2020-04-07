@extends('layouts.dashboard')
@section('content_dashboard')

<div class="col-md-12 padding-0">
        <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data Produk</h3> @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') <a href="/produk/create"><input class="submit btn btn-primary" type="button" value="Tambah Data"></a> @endif </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <div id="datatables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row">
					  <div class="col-sm-12">
					  <form class="cmxform" method="get" action="/produk" novalidate="novalidate">
					  <div id="datatables-example_filter" class="dataTables_filter">
					  <label>Search:<input type="search" name="filter" class="form-control input-sm" placeholder="Kode / Nama / Model" aria-controls="datatables-example" value="{{ Request::get('filter') }}"></label>
				   
					  <input class="submit btn btn-warning" type="submit" value="Cari">
					  <a href="/produk"><input class="submit btn btn-danger" type="button" value="Reset"></a></label>
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
							<th>Kode Produk</th>
							<th>Nama</th>
							<th>Brand</th>
							<th>Model / Type</th>
                            @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')
                            <th>Aksi</th>
                            @endif
						</tr>
                      </thead>
					  @if(isset($datas))
                      <tbody>
					  @foreach ($datas as $data)
					  
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $data->code }}</td>
                          <td>{{ $data->name }}</td>
                          <td>{{ $data->brand }}</td>
                          <td>{{ $data->model }}</td>
                          @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator')
                         <td><a href="/produk/{{ Crypt::encrypt($data->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah"></a> | <a onclick="event.preventDefault();document.getElementById('delete-form-{{ $loop->iteration }}').submit();"><input class="submit btn btn-danger" type="button" value="Hapus"></a></td>
							<form id="delete-form-{{ $loop->iteration }}" method="POST" action="/produk/{{ $data->id }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}
							</form>
						<td></a>
						
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