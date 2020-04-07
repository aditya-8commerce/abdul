@extends('layouts.dashboard')
@section('content_dashboard')
<!--  jQuery -->
<link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/select2.min.css') }}"/>
<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-datetimepicker.js') }}"></script>
    <script src="{{ asset('/miminium/js/plugins/select2.full.min.js') }}"></script> 
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.min.css') }}"/>
<link rel="stylesheet" href="{{ asset('/css/bootstrap-datetimepicker.css') }}"/>


<form class="cmxform" method="get" action="/jadwal-teknisi" novalidate="novalidate">
<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>Periksa Jadwal Teknisi</h4>
	</div>
	<div class="col-md-12 panel-body" style="padding-bottom:30px;">
		<div class="col-md-12">


        <div class="form-group form-animate-text @if($errors->has('tanggal_mulai')) form-animate-error @endif" style="margin-top:40px !important;">
					<input type="text" class="form-text tanggal_mulai @if($errors->has('tanggal_mulai')) error @endif" data-date-format="yyyy-mm-dd hh:ii" id="tanggal_mulai" name="tanggal_mulai" required="" aria-required="true" value="{{ Request::get('tanggal_mulai') }}">
					<span class="bar"></span>
                    <label>Tanggal Mulai</label>
					@if($errors->has('tanggal_mulai'))  <em class="error">{{ $errors->first('tanggal_mulai') }}</em> @endif
                </div>

            <div class="form-group form-animate-text @if($errors->has('tanggal_selesai')) form-animate-error @endif" style="margin-top:40px !important;">
                <input type="text" class="form-text tanggal_selesai @if($errors->has('tanggal_selesai')) error @endif" data-date-format="yyyy-mm-dd hh:ii" id="tanggal_selesai" name="tanggal_selesai" required="" aria-required="true" value="{{ Request::get('tanggal_selesai') }}">
                <span class="bar"></span>
                <label>Tanggal Selesai</label>
                @if($errors->has('tanggal_selesai'))  <em class="error">{{ $errors->first('tanggal_selesai') }}</em> @endif
            </div> 
 
				  
            <div class="form-group form-animate-text @if($errors->has('teknisi')) form-animate-error @endif" style="margin-top:40px !important;">
            <label>Teknisi</label>
                <br>
                <br>
                <br>
                <select name="teknisi[]" id="teknisi[]" class="select2-B form-text" multiple="multiple" required>
                @foreach ($users as $d)
                    <option value="{{$d->id}}">{{$d->name .'('.$d->indentity_number.')'}}</option>
                @endforeach
                </select>
                @if($errors->has('teknisi'))  <em class="error">{{ $errors->first('teknisi') }}</em> @endif
            </div>

            <div class="col-md-12">

            <table id="datatables-example" class="table table-striped table-bordered dataTable no-footer" width="100%" cellspacing="0" role="grid" aria-describedby="datatables-example_info" style="width: 100%;">
                      <thead>
                        <tr>
							<th>No</th>
							<th>No Jadwal</th>
							<th>Status</th>
							<th>Proses Type</th>
							<th>Kode Pelanggan</th>
							<th>Tanggal Mulai</th>
							<th>Tanggal Selesai</th>
							<th>Total Jam</th>
							<th>Teknisi</th>
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
							<td>{{$d->status}}</td>
							<td>{{$d->type}}</td>
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
                      </tr>
                    @endforeach
                    @endif


						</tbody>
                        </table>

            </div>

			</div>
			  
			<div class="col-md-12">
                <a href="/jadwal-teknisi"><input class="submit btn btn-primary" type="button" value="Reset"></a>
                <input class="submit btn btn-warning" name="cari" type="submit" value="Cari">
            </div>

		</div>
	</div>
</div>
</div>
</form>

<script type="text/javascript">
    "use strict";
    $('.tanggal_mulai').datetimepicker({
       //language:  'fr',
       format:'yyyy-mm-dd hh:ii:00',
       weekStart: 1,
       todayBtn:  1,
       autoclose: 1,
       todayHighlight: 1,
       startView: 2,
       forceParse: 0,
       showMeridian: 1
   });
    $('.tanggal_selesai').datetimepicker({
       //language:  'fr',
       format:'yyyy-mm-dd hh:ii:00',
       weekStart: 1,
       todayBtn:  1,
       autoclose: 1,
       todayHighlight: 1,
       startView: 2,
       forceParse: 0,
       showMeridian: 1
   });


   $(".select2-B").select2({
      tags: true
    });

</script>

@endsection