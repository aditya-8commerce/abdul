@extends('layouts.dashboard')
@section('content_dashboard')


<div class="col-md-12 padding-0">
        <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3>Data User</h3> <a href="/user-akses/create"><input class="submit btn btn-primary" type="button" value="Tambah Data"></a></div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <div id="datatables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row">
					  <div class="col-sm-12">
					  <form class="cmxform" method="get" action="/user-akses" novalidate="novalidate">
					  <div id="datatables-example_filter" class="dataTables_filter">
					  <label>Search:<input type="search" name="filter" class="form-control input-sm" placeholder="Nama" aria-controls="datatables-example" value="{{ Request::get('filter') }}"></label>
					 
					  <label>Divisi:<select name="divisi"><option value=""></option>@foreach ($divions as $d)<option value="{{$d->id}}" @if($d->id == Request::get('divisi')) selected="selected" @endif>{{$d->name}}</option>@endforeach</select></label>
					  
					   <label>Jabatan:<select name="posisi"><option value=""></option>@foreach ($positions as $p)<option value="{{$p->id}}" @if($p->id == Request::get('posisi')) selected="selected" @endif>{{$p->name}}</option>@endforeach</select></label>
					   
					  <label> 
					  <input class="submit btn btn-warning" type="submit" value="Cari">
					  <a href="/user-akses"><input class="submit btn btn-danger" type="button" value="Reset"></a></label>
					  </div>
					  </form>
					  </div>
					  </div>
					  <div class="row"><div class="col-sm-12">
					  <table id="datatables-example" class="table table-striped table-bordered dataTable no-footer" width="100%" cellspacing="0" role="grid" aria-describedby="datatables-example_info" style="width: 100%;">
                      <thead>
                        <tr>
							<th>No</th>
							<th>NIK</th>
							<th>Nama</th>
							<th>Divisi</th>
							<th>Jabatan</th>
							<th>Total Cuti</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Aksi</th>
						</tr>
                      </thead>
					  @if(isset($users))
                      <tbody>
					  @foreach ($users as $user)
					  
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $user->indentity_number }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->divisi->name }}</td>
                          <td>{{ $user->posisi->name }}</td>
                          <td>{{ $user->paid_leave }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->phone }}</td>
                          <td>  <a href="/user-akses/{{ Crypt::encrypt($user->id) }}"><input class="submit btn btn-default" type="button" value="Lihat Data"></a> | <a href="/user-akses/{{ Crypt::encrypt($user->id) }}/edit"><input class="submit btn btn-warning" type="button" value="Rubah Data"></a> | <a onclick="event.preventDefault();document.getElementById('delete-form-{{ $loop->iteration }}').submit();"><input class="submit btn btn-danger" type="button" value="Hapus Data"></a> </td>
						<form id="delete-form-{{ $loop->iteration }}" method="POST" action="/user-akses/{{ $user->id }}">
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
						{!! $users->render() !!}
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