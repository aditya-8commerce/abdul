@extends('layouts.dashboard')
@section('content_dashboard')
<!--  jQuery -->
<script type="text/javascript" src="{{ asset('/js/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('/miminium/js/plugins/select2.full.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>



<link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker3.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/select2.min.css') }}"/>



<div class="col-md-12 padding-0">
<div class="col-md-12 panel">
	<div class="col-md-12 panel-heading">
	<h4>LAPORAN OZON</h4>
</div>

<form class="cmxform" id="divisiForm" method="post" enctype="multipart/form-data" action="/laporan-ozon/{{ Crypt::encrypt($data->id) }}/{{Crypt::encrypt($data->ozon->id)}}/update" autocomplete="off">
@csrf
<table id="datatables-example" class="table table-bordered dataTable no-footer" width="100%" cellspacing="0" style="width: 100%;">

<tr>
    <td colspan="10" style="text-align: center;"><h3><b>PT.Triotirta Karsa Abadi</b></h3> <br> Jl.Raya Pejuangan 1, Kedoya Center Blok C5, Kebon Jeruk - Jakbar.Tlp.021 6307 083 / 84, Fax.021 5347 305</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;">Customer :  <br> <b>{{$data->customer->code}}</b></td>
    <td colspan="2" style="text-align: left;">Subject     : <br>
    <input type="text" class="form-control subject @if($errors->has('subject')) error @endif"  id="subject" name="subject" value="{{ old('subject') ?? $data->ozon->subject }}">
    @if($errors->has('subject'))  <em class="error">{{ $errors->first('subject') }}</em> @endif
    </td>
    <td colspan="2" style="text-align: left;">Check by : <br>
    @if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator') 
    <select class="id_user form-control @if($errors->has('id_user')) error @endif" id="id_user" name="id_user" aria-required="true">
    <option value=""> </option>
    @foreach ($data->users as $d)
    <option value="{{$d->id_user}}" @if(old('id_user') == $d->id_user || ($data->ozon->id_user) == $d->id_user) selected="selected" @endif>{{$d->user->name.' - '.$d->user->indentity_number}}</option>
    @endforeach
    @if($errors->has('id_user'))  <em class="error">{{ $errors->first('id_user') }}</em> @endif			
    </select>
    @else 

    {{Auth::user()->name.' ( '.Auth::user()->indentity_number.' )'}} 

    @endif</td>
    <td colspan="2" style="text-align: left;">Customer by : <br>
    <input type="text" class="form-control customer_by @if($errors->has('customer_by')) error @endif"  id="customer_by" name="customer_by" value="{{ old('customer_by') ?? $data->ozon->customer_by }}">
    @if($errors->has('customer_by'))  <em class="error">{{ $errors->first('customer_by') }}</em> @endif
    </td>
</tr>

<tr>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6">
                Model : <br>
                <select name="model" id="model" class="select2-A form-control">
                    @foreach ($produk as $d)
                        <option value="{{$d->id}}" @if(old('model') == $d->id || $data->ozon->id_product == $d->id) selected="selected" @endif>{{$d->model}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
            SN : <br>
    <input type="text" class="form-control serial_number @if($errors->has('serial_number')) error @endif"  id="serial_number" name="serial_number" value="{{ old('serial_number') ?? $data->ozon->serial_number }}">
    @if($errors->has('serial_number'))  <em class="error">{{ $errors->first('serial_number') }}</em> @endif
            </div>
        </div>
    </td>
    <td colspan="4" style="text-align: left;">  
        <div class="col-md-12">
            <div class="col-md-6">
            Running Hours : <br> 
    <input type="number" step="any" class="form-control running_hours @if($errors->has('running_hours')) error @endif" id="running_hours" name="running_hours" value="{{ old('running_hours') ?? $data->ozon->running_hours }}"> h
    @if($errors->has('running_hours'))  <em class="error">{{ $errors->first('running_hours') }}</em> @endif
            </div>
            <div class="col-md-6">
            Year : <br>  
    <input type="text" class="form-control year @if($errors->has('year')) error @endif" data-date-format="yyyy-mm" id="year" name="year" value="{{ old('year') ?? $data->ozon->year }}">
    @if($errors->has('year'))  <em class="error">{{ $errors->first('year') }}</em> @endif
            </div>
        </div>
    </td>
    <td colspan="3" style="text-align: left;"> 
        <div class="col-md-12">
            <div class="col-md-6"> Date     : <br> 
    <input type="text" class="form-control date @if($errors->has('date')) error @endif" data-date-format="yyyy-mm-dd" id="date" name="date" value="{{ old('date') ?? $data->ozon->date }}">
    @if($errors->has('date'))  <em class="error">{{ $errors->first('date') }}</em> @endif

            </div>
            <div class="col-md-6"> 
            Working hours : <br>  {{$data->date_start.' ~ '.$data->date_finish}}
            </div>
        </div>
            </td>
</tr>

 
<tr>
    <td colspan="5" style="text-align: center;"> >  >  >   Ozone cabinet door switch open/emergency stop    >  >  > </td>
    <td colspan="5" style="text-align: left;"> Lock : <input type="radio" name="lock" @if(old('lock') == 'Y' || $data->ozon->lock == 'Y') checked="checked" @endif value="Y"> Y  / <input type="radio" @if(old('lock') == 'N'  || $data->ozon->lock == 'N') checked="checked" @endif name="lock" value="N"> N

    </td>
</tr>


<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 1 - Dew Point after the tube generator</b> </td>
</tr>



<tr>
    <td colspan="5" style="text-align: center;"> Dryer 1 </td>
    <td colspan="5" style="text-align: center;"> Dryer 2 </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_1_remaining_capacity_before @if($errors->has('step_1_dryer_1_remaining_capacity_before')) error @endif"  id="step_1_dryer_1_remaining_capacity_before" name="step_1_dryer_1_remaining_capacity_before" value="{{ old('step_1_dryer_1_remaining_capacity_before') ?? $data->ozon->step_1_dryer_1_remaining_capacity_before }}">
    @if($errors->has('step_1_dryer_1_remaining_capacity_before'))  <em class="error">{{ $errors->first('step_1_dryer_1_remaining_capacity_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_1_remaining_capacity_after @if($errors->has('step_1_dryer_1_remaining_capacity_after')) error @endif"  id="step_1_dryer_1_remaining_capacity_after" name="step_1_dryer_1_remaining_capacity_after" value="{{ old('step_1_dryer_1_remaining_capacity_after') ?? $data->ozon->step_1_dryer_1_remaining_capacity_after }}">
    @if($errors->has('step_1_dryer_1_remaining_capacity_after'))  <em class="error">{{ $errors->first('step_1_dryer_1_remaining_capacity_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_1_dryer_1_remaining_capacity_noted @if($errors->has('step_1_dryer_1_remaining_capacity_noted')) error @endif"  id="step_1_dryer_1_remaining_capacity_before" name="step_1_dryer_1_remaining_capacity_noted" value="{{ old('step_1_dryer_1_remaining_capacity_noted') ?? $data->ozon->step_1_dryer_1_remaining_capacity_noted }}">
    @if($errors->has('step_1_dryer_1_remaining_capacity_noted'))  <em class="error">{{ $errors->first('step_1_dryer_1_remaining_capacity_noted') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_2_remaining_capacity_before @if($errors->has('step_1_dryer_2_remaining_capacity_before')) error @endif"  id="step_1_dryer_2_remaining_capacity_before" name="step_1_dryer_2_remaining_capacity_before" value="{{ old('step_1_dryer_2_remaining_capacity_before') ?? $data->ozon->step_1_dryer_2_remaining_capacity_before }}">
    @if($errors->has('step_1_dryer_2_remaining_capacity_before'))  <em class="error">{{ $errors->first('step_1_dryer_2_remaining_capacity_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_2_remaining_capacity_after @if($errors->has('step_1_dryer_2_remaining_capacity_after')) error @endif"  id="step_1_dryer_1_remaining_capacity_after" name="step_1_dryer_2_remaining_capacity_after" value="{{ old('step_1_dryer_2_remaining_capacity_after') ?? $data->ozon->step_1_dryer_2_remaining_capacity_after }}">
    @if($errors->has('step_1_dryer_2_remaining_capacity_after'))  <em class="error">{{ $errors->first('step_1_dryer_2_remaining_capacity_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_1_dryer_2_remaining_capacity_noted @if($errors->has('step_1_dryer_2_remaining_capacity_noted')) error @endif"  id="step_1_dryer_1_remaining_capacity_before" name="step_1_dryer_2_remaining_capacity_noted" value="{{ old('step_1_dryer_2_remaining_capacity_noted') ?? $data->ozon->step_1_dryer_2_remaining_capacity_noted }}">
    @if($errors->has('step_1_dryer_2_remaining_capacity_noted'))  <em class="error">{{ $errors->first('step_1_dryer_2_remaining_capacity_noted') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_1_dew_point_before @if($errors->has('step_1_dryer_1_dew_point_before')) error @endif"  id="step_1_dryer_1_dew_point_before" name="step_1_dryer_1_dew_point_before" value="{{ old('step_1_dryer_1_dew_point_before') ?? $data->ozon->step_1_dryer_1_dew_point_before }}">
    @if($errors->has('step_1_dryer_1_dew_point_before'))  <em class="error">{{ $errors->first('step_1_dryer_1_dew_point_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_1_dew_point_after @if($errors->has('step_1_dryer_1_dew_point_after')) error @endif"  id="step_1_dryer_1_dew_point_after" name="step_1_dryer_1_dew_point_after" value="{{ old('step_1_dryer_1_dew_point_after') ?? $data->ozon->step_1_dryer_1_dew_point_after }}">
    @if($errors->has('step_1_dryer_1_dew_point_after'))  <em class="error">{{ $errors->first('step_1_dryer_1_dew_point_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_1_dryer_1_dew_point_noted @if($errors->has('step_1_dryer_1_dew_point_noted')) error @endif"  id="step_1_dryer_1_dew_point_before" name="step_1_dryer_1_dew_point_noted" value="{{ old('step_1_dryer_1_dew_point_noted') ?? $data->ozon->step_1_dryer_1_dew_point_noted }}">
    @if($errors->has('step_1_dryer_1_dew_point_noted'))  <em class="error">{{ $errors->first('step_1_dryer_1_dew_point_noted') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_2_dew_point_before @if($errors->has('step_1_dryer_2_dew_point_before')) error @endif"  id="step_1_dryer_2_dew_point_before" name="step_1_dryer_2_dew_point_before" value="{{ old('step_1_dryer_2_dew_point_before') ?? $data->ozon->step_1_dryer_2_dew_point_before }}">
    @if($errors->has('step_1_dryer_2_dew_point_before'))  <em class="error">{{ $errors->first('step_1_dryer_2_dew_point_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_2_dew_point_after @if($errors->has('step_1_dryer_2_dew_point_after')) error @endif"  id="step_1_dryer_1_dew_point_after" name="step_1_dryer_2_dew_point_after" value="{{ old('step_1_dryer_2_dew_point_after') ?? $data->ozon->step_1_dryer_2_dew_point_after }}">
    @if($errors->has('step_1_dryer_2_dew_point_after'))  <em class="error">{{ $errors->first('step_1_dryer_2_dew_point_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_1_dryer_2_dew_point_noted @if($errors->has('step_1_dryer_2_dew_point_noted')) error @endif"  id="step_1_dryer_1_dew_point_before" name="step_1_dryer_2_dew_point_noted" value="{{ old('step_1_dryer_2_dew_point_noted') ?? $data->ozon->step_1_dryer_2_dew_point_noted }}">
    @if($errors->has('step_1_dryer_2_dew_point_noted'))  <em class="error">{{ $errors->first('step_1_dryer_2_dew_point_noted') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_1_gas_temperature_before @if($errors->has('step_1_dryer_1_gas_temperature_before')) error @endif"  id="step_1_dryer_1_gas_temperature_before" name="step_1_dryer_1_gas_temperature_before" value="{{ old('step_1_dryer_1_gas_temperature_before') ?? $data->ozon->step_1_dryer_1_gas_temperature_before }}">
    @if($errors->has('step_1_dryer_1_gas_temperature_before'))  <em class="error">{{ $errors->first('step_1_dryer_1_gas_temperature_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_1_gas_temperature_after @if($errors->has('step_1_dryer_1_gas_temperature_after')) error @endif"  id="step_1_dryer_1_gas_temperature_after" name="step_1_dryer_1_gas_temperature_after" value="{{ old('step_1_dryer_1_gas_temperature_after') ?? $data->ozon->step_1_dryer_1_gas_temperature_after }}">
    @if($errors->has('step_1_dryer_1_gas_temperature_after'))  <em class="error">{{ $errors->first('step_1_dryer_1_gas_temperature_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_1_dryer_1_gas_temperature_noted @if($errors->has('step_1_dryer_1_gas_temperature_noted')) error @endif"  id="step_1_dryer_1_gas_temperature_before" name="step_1_dryer_1_gas_temperature_noted" value="{{ old('step_1_dryer_1_gas_temperature_noted') ?? $data->ozon->step_1_dryer_1_gas_temperature_noted }}">
    @if($errors->has('step_1_dryer_1_gas_temperature_noted'))  <em class="error">{{ $errors->first('step_1_dryer_1_gas_temperature_noted') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_2_gas_temperature_before @if($errors->has('step_1_dryer_2_gas_temperature_before')) error @endif"  id="step_1_dryer_2_gas_temperature_before" name="step_1_dryer_2_gas_temperature_before" value="{{ old('step_1_dryer_2_gas_temperature_before') ?? $data->ozon->step_1_dryer_2_gas_temperature_before }}">
    @if($errors->has('step_1_dryer_2_gas_temperature_before'))  <em class="error">{{ $errors->first('step_1_dryer_2_gas_temperature_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_1_dryer_2_gas_temperature_after @if($errors->has('step_1_dryer_2_gas_temperature_after')) error @endif"  id="step_1_dryer_1_gas_temperature_after" name="step_1_dryer_2_gas_temperature_after" value="{{ old('step_1_dryer_2_gas_temperature_after') ?? $data->ozon->step_1_dryer_2_gas_temperature_after }}">
    @if($errors->has('step_1_dryer_2_gas_temperature_after'))  <em class="error">{{ $errors->first('step_1_dryer_2_gas_temperature_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_1_dryer_2_gas_temperature_noted @if($errors->has('step_1_dryer_2_gas_temperature_noted')) error @endif"  id="step_1_dryer_1_gas_temperature_before" name="step_1_dryer_2_gas_temperature_noted" value="{{ old('step_1_dryer_2_gas_temperature_noted') ?? $data->ozon->step_1_dryer_2_gas_temperature_noted }}">
    @if($errors->has('step_1_dryer_2_gas_temperature_noted'))  <em class="error">{{ $errors->first('step_1_dryer_2_gas_temperature_noted') }}</em> @endif
    </td>
</tr>

<tr>
    <td colspan="5" style="text-align: left;">Description : <br> <textarea class="form-control step_1_dryer_1_description @if($errors->has('step_1_dryer_1_description')) error @endif" id="step_1_dryer_1_description " name="step_1_dryer_1_description">{{ old('step_1_dryer_1_description') ?? $data->ozon->step_1_dryer_1_description }}</textarea> </td>

    <td colspan="5" style="text-align: left;">Description : <br> <textarea class="form-control step_1_dryer_2_description @if($errors->has('step_1_dryer_2_description')) error @endif" id="step_1_dryer_2_description " name="step_1_dryer_2_description">{{ old('step_1_dryer_2_description') ?? $data->ozon->step_1_dryer_2_description }}</textarea> </td>

</tr>


<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 2 - Dew Point after the Dryer</b> </td>
</tr>



<tr>
    <td colspan="5" style="text-align: center;"> Dryer 1 </td>
    <td colspan="5" style="text-align: center;"> Dryer 2 </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_1_remaining_capacity_before @if($errors->has('step_2_dryer_1_remaining_capacity_before')) error @endif"  id="step_2_dryer_1_remaining_capacity_before" name="step_2_dryer_1_remaining_capacity_before" value="{{ old('step_2_dryer_1_remaining_capacity_before') ?? $data->ozon->step_2_dryer_1_remaining_capacity_before }}">
    @if($errors->has('step_2_dryer_1_remaining_capacity_before'))  <em class="error">{{ $errors->first('step_2_dryer_1_remaining_capacity_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_1_remaining_capacity_after @if($errors->has('step_2_dryer_1_remaining_capacity_after')) error @endif"  id="step_2_dryer_1_remaining_capacity_after" name="step_2_dryer_1_remaining_capacity_after" value="{{ old('step_2_dryer_1_remaining_capacity_after') ?? $data->ozon->step_2_dryer_1_remaining_capacity_after }}">
    @if($errors->has('step_2_dryer_1_remaining_capacity_after'))  <em class="error">{{ $errors->first('step_2_dryer_1_remaining_capacity_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_2_dryer_1_remaining_capacity_noted @if($errors->has('step_2_dryer_1_remaining_capacity_noted')) error @endif"  id="step_2_dryer_1_remaining_capacity_before" name="step_2_dryer_1_remaining_capacity_noted" value="{{ old('step_2_dryer_1_remaining_capacity_noted') ?? $data->ozon->step_2_dryer_1_remaining_capacity_noted }}">
    @if($errors->has('step_2_dryer_1_remaining_capacity_noted'))  <em class="error">{{ $errors->first('step_2_dryer_1_remaining_capacity_noted') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> Remaining Capacity </td>
    <td colspan="1" style="text-align: left;"> % </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_2_remaining_capacity_before @if($errors->has('step_2_dryer_2_remaining_capacity_before')) error @endif"  id="step_2_dryer_2_remaining_capacity_before" name="step_2_dryer_2_remaining_capacity_before" value="{{ old('step_2_dryer_2_remaining_capacity_before') ?? $data->ozon->step_2_dryer_2_remaining_capacity_before }}">
    @if($errors->has('step_2_dryer_2_remaining_capacity_before'))  <em class="error">{{ $errors->first('step_2_dryer_2_remaining_capacity_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_2_remaining_capacity_after @if($errors->has('step_2_dryer_2_remaining_capacity_after')) error @endif"  id="step_2_dryer_1_remaining_capacity_after" name="step_2_dryer_2_remaining_capacity_after" value="{{ old('step_2_dryer_2_remaining_capacity_after') ?? $data->ozon->step_2_dryer_2_remaining_capacity_after }}">
    @if($errors->has('step_2_dryer_2_remaining_capacity_after'))  <em class="error">{{ $errors->first('step_2_dryer_2_remaining_capacity_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_2_dryer_2_remaining_capacity_noted @if($errors->has('step_2_dryer_2_remaining_capacity_noted')) error @endif"  id="step_2_dryer_1_remaining_capacity_before" name="step_2_dryer_2_remaining_capacity_noted" value="{{ old('step_2_dryer_2_remaining_capacity_noted') ?? $data->ozon->step_2_dryer_2_remaining_capacity_noted }}">
    @if($errors->has('step_2_dryer_2_remaining_capacity_noted'))  <em class="error">{{ $errors->first('step_2_dryer_2_remaining_capacity_noted') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_1_dew_point_before @if($errors->has('step_2_dryer_1_dew_point_before')) error @endif"  id="step_2_dryer_1_dew_point_before" name="step_2_dryer_1_dew_point_before" value="{{ old('step_2_dryer_1_dew_point_before') ?? $data->ozon->step_2_dryer_1_dew_point_before }}">
    @if($errors->has('step_2_dryer_1_dew_point_before'))  <em class="error">{{ $errors->first('step_2_dryer_1_dew_point_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_1_dew_point_after @if($errors->has('step_2_dryer_1_dew_point_after')) error @endif"  id="step_2_dryer_1_dew_point_after" name="step_2_dryer_1_dew_point_after" value="{{ old('step_2_dryer_1_dew_point_after') ?? $data->ozon->step_2_dryer_1_dew_point_after }}">
    @if($errors->has('step_2_dryer_1_dew_point_after'))  <em class="error">{{ $errors->first('step_2_dryer_1_dew_point_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_2_dryer_1_dew_point_noted @if($errors->has('step_2_dryer_1_dew_point_noted')) error @endif"  id="step_2_dryer_1_dew_point_before" name="step_2_dryer_1_dew_point_noted" value="{{ old('step_2_dryer_1_dew_point_noted') ?? $data->ozon->step_2_dryer_1_dew_point_noted }}">
    @if($errors->has('step_2_dryer_1_dew_point_noted'))  <em class="error">{{ $errors->first('step_2_dryer_1_dew_point_noted') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> Dew Point </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_2_dew_point_before @if($errors->has('step_2_dryer_2_dew_point_before')) error @endif"  id="step_2_dryer_2_dew_point_before" name="step_2_dryer_2_dew_point_before" value="{{ old('step_2_dryer_2_dew_point_before') ?? $data->ozon->step_2_dryer_2_dew_point_before }}">
    @if($errors->has('step_2_dryer_2_dew_point_before'))  <em class="error">{{ $errors->first('step_2_dryer_2_dew_point_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_2_dew_point_after @if($errors->has('step_2_dryer_2_dew_point_after')) error @endif"  id="step_2_dryer_1_dew_point_after" name="step_2_dryer_2_dew_point_after" value="{{ old('step_2_dryer_2_dew_point_after') ?? $data->ozon->step_2_dryer_2_dew_point_after }}">
    @if($errors->has('step_2_dryer_2_dew_point_after'))  <em class="error">{{ $errors->first('step_2_dryer_2_dew_point_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_2_dryer_2_dew_point_noted @if($errors->has('step_2_dryer_2_dew_point_noted')) error @endif"  id="step_2_dryer_1_dew_point_before" name="step_2_dryer_2_dew_point_noted" value="{{ old('step_2_dryer_2_dew_point_noted') ?? $data->ozon->step_2_dryer_2_dew_point_noted }}">
    @if($errors->has('step_2_dryer_2_dew_point_noted'))  <em class="error">{{ $errors->first('step_2_dryer_2_dew_point_noted') }}</em> @endif
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_1_gas_temperature_before @if($errors->has('step_2_dryer_1_gas_temperature_before')) error @endif"  id="step_2_dryer_1_gas_temperature_before" name="step_2_dryer_1_gas_temperature_before" value="{{ old('step_2_dryer_1_gas_temperature_before') ?? $data->ozon->step_2_dryer_1_gas_temperature_before }}">
    @if($errors->has('step_2_dryer_1_gas_temperature_before'))  <em class="error">{{ $errors->first('step_2_dryer_1_gas_temperature_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_1_gas_temperature_after @if($errors->has('step_2_dryer_1_gas_temperature_after')) error @endif"  id="step_2_dryer_1_gas_temperature_after" name="step_2_dryer_1_gas_temperature_after" value="{{ old('step_2_dryer_1_gas_temperature_after') ?? $data->ozon->step_2_dryer_1_gas_temperature_after }}">
    @if($errors->has('step_2_dryer_1_gas_temperature_after'))  <em class="error">{{ $errors->first('step_2_dryer_1_gas_temperature_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_2_dryer_1_gas_temperature_noted @if($errors->has('step_2_dryer_1_gas_temperature_noted')) error @endif"  id="step_2_dryer_1_gas_temperature_noted" name="step_2_dryer_1_gas_temperature_noted" value="{{ old('step_2_dryer_1_gas_temperature_noted') ?? $data->ozon->step_2_dryer_1_gas_temperature_noted }}">
    @if($errors->has('step_2_dryer_1_gas_temperature_noted'))  <em class="error">{{ $errors->first('step_2_dryer_1_gas_temperature_noted') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> Gas Temperature </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_2_gas_temperature_before @if($errors->has('step_2_dryer_2_gas_temperature_before')) error @endif"  id="step_2_dryer_2_gas_temperature_before" name="step_2_dryer_2_gas_temperature_before" value="{{ old('step_2_dryer_2_gas_temperature_before') ?? $data->ozon->step_2_dryer_2_gas_temperature_before }}">
    @if($errors->has('step_2_dryer_2_gas_temperature_before'))  <em class="error">{{ $errors->first('step_2_dryer_2_gas_temperature_before') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_2_dryer_2_gas_temperature_after @if($errors->has('step_2_dryer_2_gas_temperature_after')) error @endif"  id="step_2_dryer_1_gas_temperature_after" name="step_2_dryer_2_gas_temperature_after" value="{{ old('step_2_dryer_2_gas_temperature_after') ?? $data->ozon->step_2_dryer_2_gas_temperature_after }}">
    @if($errors->has('step_2_dryer_2_gas_temperature_after'))  <em class="error">{{ $errors->first('step_2_dryer_2_gas_temperature_after') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_2_dryer_2_gas_temperature_noted @if($errors->has('step_2_dryer_2_gas_temperature_noted')) error @endif"  id="step_2_dryer_1_gas_temperature_before" name="step_2_dryer_2_gas_temperature_noted" value="{{ old('step_2_dryer_2_gas_temperature_noted') ?? $data->ozon->step_2_dryer_2_gas_temperature_noted }}">
    @if($errors->has('step_2_dryer_2_gas_temperature_noted'))  <em class="error">{{ $errors->first('step_2_dryer_2_gas_temperature_noted') }}</em> @endif
    </td>
</tr>

<tr>
    <td colspan="5" style="text-align: left;">Description : <br> <textarea class="form-control step_2_dryer_1_description @if($errors->has('step_2_dryer_1_description')) error @endif" id="step_2_dryer_1_description " name="step_2_dryer_1_description">{{ old('step_2_dryer_1_description') ?? $data->ozon->step_2_dryer_1_description }}</textarea> </td>

    <td colspan="5" style="text-align: left;">Description : <br> <textarea class="form-control step_2_dryer_2_description @if($errors->has('step_2_dryer_2_description')) error @endif" id="step_2_dryer_2_description " name="step_2_dryer_2_description">{{ old('step_2_dryer_2_description') ?? $data->ozon->step_2_dryer_2_description }}</textarea> </td>

</tr>



<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 3 - Regeneration the Dryer</b> </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;"> ******************** </td>
    <td colspan="1" style="text-align: left;"> Phase R </td>
    <td colspan="1" style="text-align: left;"> Phase S </td>
    <td colspan="1" style="text-align: left;"> Phase T </td>
    <td colspan="2" style="text-align: left;"> Flow Blower </td>
    <td colspan="1" style="text-align: left;"> m/s </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_flow_blower_1 @if($errors->has('step_3_flow_blower_1')) error @endif"  id="step_3_flow_blower_1" name="step_3_flow_blower_1" value="{{ old('step_3_flow_blower_1') }}">
    @if($errors->has('step_3_flow_blower_1'))  <em class="error">{{ $errors->first('step_3_flow_blower_1') }}</em> @endif
     </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_flow_blower_2 @if($errors->has('step_3_flow_blower_2')) error @endif"  id="step_3_flow_blower_2" name="step_3_flow_blower_2" value="{{ old('step_3_flow_blower_2') }}">
    @if($errors->has('step_3_flow_blower_2'))  <em class="error">{{ $errors->first('step_3_flow_blower_2') }}</em> @endif
     </td>
</tr>

<tr>
    <td colspan="1" style="text-align: left;"> Regeneration Blower </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_regeneration_blower_phase_r @if($errors->has('step_3_regeneration_blower_phase_r')) error @endif"  id="step_3_regeneration_blower_phase_r" name="step_3_regeneration_blower_phase_r" value="{{ old('step_3_regeneration_blower_phase_r') ?? $data->ozon->step_3_regeneration_blower_phase_r }}">
    @if($errors->has('step_3_regeneration_blower_phase_r'))  <em class="error">{{ $errors->first('step_3_regeneration_blower_phase_r') }}</em> @endif </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_regeneration_blower_phase_s @if($errors->has('step_3_regeneration_blower_phase_s')) error @endif"  id="step_3_regeneration_blower_phase_s" name="step_3_regeneration_blower_phase_s" value="{{ old('step_3_regeneration_blower_phase_s') ?? $data->ozon->step_3_regeneration_blower_phase_s }}">
    @if($errors->has('step_3_regeneration_blower_phase_s'))  <em class="error">{{ $errors->first('step_3_regeneration_blower_phase_s') }}</em> @endif </td>
    <td colspan="1" style="text-align: left;"> 
    
    <input type="number" step="any" class="form-control step_3_regeneration_blower_phase_t @if($errors->has('step_3_regeneration_blower_phase_t')) error @endif"  id="step_3_regeneration_blower_phase_t" name="step_3_regeneration_blower_phase_t" value="{{ old('step_3_regeneration_blower_phase_t') ?? $data->ozon->step_3_regeneration_blower_phase_t }}">
    @if($errors->has('step_3_regeneration_blower_phase_t'))  <em class="error">{{ $errors->first('step_3_regeneration_blower_phase_t') }}</em> @endif 

    </td>
    
    <td colspan="2" style="text-align: left;"> Dryer Heating 1 16S1 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    <input type="number" step="any" class="form-control step_3_dryer_heating_1_1 @if($errors->has('step_3_dryer_heating_1_1')) error @endif"  id="step_3_dryer_heating_1_1" name="step_3_dryer_heating_1_1" value="{{ old('step_3_dryer_heating_1_1') ?? $data->ozon->step_3_dryer_heating_1_1 }}">
    @if($errors->has('step_3_dryer_heating_1_1'))  <em class="error">{{ $errors->first('step_3_dryer_heating_1_1') }}</em> @endif 

     </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_heating_1_2 @if($errors->has('step_3_dryer_heating_1_2')) error @endif"  id="step_3_dryer_heating_1_2" name="step_3_dryer_heating_1_2" value="{{ old('step_3_dryer_heating_1_2') ?? $data->ozon->step_3_dryer_heating_1_2 }}">
    @if($errors->has('step_3_dryer_heating_1_2'))  <em class="error">{{ $errors->first('step_3_dryer_heating_1_2') }}</em> @endif 
    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heater Dryer 1 </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_3_dryer_heating_1_phase_r @if($errors->has('step_3_dryer_heating_1_phase_r')) error @endif"  id="step_3_dryer_heating_1_phase_r" name="step_3_dryer_heating_1_phase_r" value="{{ old('step_3_dryer_heating_1_phase_r') ?? $data->ozon->step_3_dryer_heating_1_phase_r }}">
    @if($errors->has('step_3_dryer_heating_1_phase_r'))  <em class="error">{{ $errors->first('step_3_dryer_heating_1_phase_r') }}</em> @endif 

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_3_dryer_heating_1_phase_s @if($errors->has('step_3_dryer_heating_1_phase_s')) error @endif"  id="step_3_dryer_heating_1_phase_s" name="step_3_dryer_heating_1_phase_s" value="{{ old('step_3_dryer_heating_1_phase_s') ?? $data->ozon->step_3_dryer_heating_1_phase_s }}">
    @if($errors->has('step_3_dryer_heating_1_phase_s'))  <em class="error">{{ $errors->first('step_3_dryer_heating_1_phase_s') }}</em> @endif  

    </td>
    
    <td colspan="1" style="text-align: left;"> 
    

    <input type="number" step="any" class="form-control step_3_dryer_heating_1_phase_t @if($errors->has('step_3_dryer_heating_1_phase_t')) error @endif"  id="step_3_dryer_heating_1_phase_t" name="step_3_dryer_heating_1_phase_t" value="{{ old('step_3_dryer_heating_1_phase_t') ?? $data->ozon->step_3_dryer_heating_1_phase_t }}">
    @if($errors->has('step_3_dryer_heating_1_phase_t'))  <em class="error">{{ $errors->first('step_3_dryer_heating_1_phase_t') }}</em> @endif 
    
    </td>
    
    <td colspan="2" style="text-align: left;"> Dryer Heating 2 16S2 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    <input type="number" step="any" class="form-control step_3_dryer_heating_2_1 @if($errors->has('step_3_dryer_heating_2_1')) error @endif"  id="step_3_dryer_heating_2_1" name="step_3_dryer_heating_2_1" value="{{ old('step_3_dryer_heating_2_1') ?? $data->ozon->step_3_dryer_heating_2_1 }}">
    @if($errors->has('step_3_dryer_heating_2_1'))  <em class="error">{{ $errors->first('step_3_dryer_heating_2_1') }}</em> @endif  

     </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_3_dryer_heating_2_2 @if($errors->has('step_3_dryer_heating_2_2')) error @endif"  id="step_3_dryer_heating_2_2" name="step_3_dryer_heating_2_2" value="{{ old('step_3_dryer_heating_2_2') ?? $data->ozon->step_3_dryer_heating_2_2 }}">
    @if($errors->has('step_3_dryer_heating_2_2'))  <em class="error">{{ $errors->first('step_3_dryer_heating_2_2') }}</em> @endif 

    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heater Dryer 2 </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_3_heater_dryer_2_phase_r @if($errors->has('step_3_heater_dryer_2_phase_r')) error @endif"  id="step_3_heater_dryer_2_phase_r" name="step_3_heater_dryer_2_phase_r" value="{{ old('step_3_heater_dryer_2_phase_r') ?? $data->ozon->step_3_heater_dryer_2_phase_r }}">
    @if($errors->has('step_3_heater_dryer_2_phase_r'))  <em class="error">{{ $errors->first('step_3_heater_dryer_2_phase_r') }}</em> @endif 

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_3_heater_dryer_2_phase_s @if($errors->has('step_3_heater_dryer_2_phase_s')) error @endif"  id="step_3_heater_dryer_2_phase_s" name="step_3_heater_dryer_2_phase_s" value="{{ old('step_3_heater_dryer_2_phase_s') ?? $data->ozon->step_3_heater_dryer_2_phase_s }}">
    @if($errors->has('step_3_heater_dryer_2_phase_s'))  <em class="error">{{ $errors->first('step_3_heater_dryer_2_phase_s') }}</em> @endif  

    </td>
    
    <td colspan="1" style="text-align: left;"> 
    

    <input type="number" step="any" class="form-control step_3_heater_dryer_2_phase_t @if($errors->has('step_3_heater_dryer_2_phase_t')) error @endif"  id="step_3_heater_dryer_2_phase_t" name="step_3_heater_dryer_2_phase_t" value="{{ old('step_3_heater_dryer_2_phase_t') ?? $data->ozon->step_3_heater_dryer_2_phase_t }}">
    @if($errors->has('step_3_heater_dryer_2_phase_t'))  <em class="error">{{ $errors->first('step_3_heater_dryer_2_phase_t') }}</em> @endif 
    
    </td>
    
    <td colspan="2" style="text-align: left;"> Dryer regeneration 1 16S3 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    <input type="number" step="any" class="form-control step_3_dryer_regeneration_1_1 @if($errors->has('step_3_dryer_regeneration_1_1')) error @endif"  id="step_3_dryer_regeneration_1_1" name="step_3_dryer_regeneration_1_1" value="{{ old('step_3_dryer_regeneration_1_1') ?? $data->ozon->step_3_dryer_regeneration_1_1 }}">
    @if($errors->has('step_3_dryer_regeneration_1_1'))  <em class="error">{{ $errors->first('step_3_dryer_regeneration_1_1') }}</em> @endif 

     </td>
    <td colspan="1" style="text-align: left;"> 
    
    <input type="number" step="any" class="form-control step_3_dryer_regeneration_1_2 @if($errors->has('step_3_dryer_regeneration_1_2')) error @endif"  id="step_3_dryer_regeneration_1_2" name="step_3_dryer_regeneration_1_2" value="{{ old('step_3_dryer_regeneration_1_2') ?? $data->ozon->step_3_dryer_regeneration_1_2  }}">
    @if($errors->has('step_3_dryer_regeneration_1_2'))  <em class="error">{{ $errors->first('step_3_dryer_regeneration_1_2') }}</em> @endif 

    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="2" style="text-align: left;"> Dryer regeneration 2 16S4 </td>
    <td colspan="1" style="text-align: left;"> ⁰C </td>
    <td colspan="1" style="text-align: left;">    
    
    <input type="number" step="any" class="form-control step_3_dryer_regeneration_2_1 @if($errors->has('step_3_dryer_regeneration_2_1')) error @endif"  id="step_3_dryer_regeneration_2_1" name="step_3_dryer_regeneration_2_1" value="{{ old('step_3_dryer_regeneration_2_1') ?? $data->ozon->step_3_dryer_regeneration_2_1 }}">
    @if($errors->has('step_3_dryer_regeneration_2_1'))  <em class="error">{{ $errors->first('step_3_dryer_regeneration_2_1') }}</em> @endif

     </td>
    <td colspan="1" style="text-align: left;"> 
    
    <input type="number" step="any" class="form-control step_3_dryer_regeneration_2_2 @if($errors->has('step_3_dryer_regeneration_2_2')) error @endif"  id="step_3_dryer_regeneration_2_2" name="step_3_dryer_regeneration_2_2" value="{{ old('step_3_dryer_regeneration_2_2') ?? $data->ozon->step_3_dryer_regeneration_2_2 }}">
    @if($errors->has('step_3_dryer_regeneration_2_2'))  <em class="error">{{ $errors->first('step_3_dryer_regeneration_2_2') }}</em> @endif 

    </td>
</tr>


<tr>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="1" style="text-align: left;">  </td>
    
    <td colspan="2" style="text-align: left;"> </td>
    <td colspan="1" style="text-align: left;"> </td>
    <td colspan="1" style="text-align: left;"> </td>
    <td colspan="1" style="text-align: left;">  </td>
</tr>

<tr>
    <td colspan="5" style="text-align: center;"> Dryer 1 </td>
    <td colspan="5" style="text-align: center;"> Dryer 2 </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
    <td colspan="2" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> Before </td>
    <td colspan="1" style="text-align: left;"> After </td>
    <td colspan="1" style="text-align: left;"> Note </td>
</tr>

<tr>
    <td colspan="1" style="text-align: left;">Heating Up Time  </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_1_heating_up_time_before @if($errors->has('step_3_dryer_1_heating_up_time_before')) error @endif"  id="step_3_dryer_1_heating_up_time_before" name="step_3_dryer_1_heating_up_time_before" value="{{ old('step_3_dryer_1_heating_up_time_before') ?? $data->ozon->step_3_dryer_1_heating_up_time_before }}">
    @if($errors->has('step_3_dryer_1_heating_up_time_before'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_up_time_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_1_heating_up_time_after @if($errors->has('step_3_dryer_1_heating_up_time_after')) error @endif"  id="step_3_dryer_1_heating_up_time_after" name="step_3_dryer_1_heating_up_time_after" value="{{ old('step_3_dryer_1_heating_up_time_after') ?? $data->ozon->step_3_dryer_1_heating_up_time_after }}">
    @if($errors->has('step_3_dryer_1_heating_up_time_after'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_up_time_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_1_heating_up_time_noted @if($errors->has('step_3_dryer_1_heating_up_time_noted')) error @endif"  id="step_3_dryer_1_heating_up_time_noted" name="step_3_dryer_1_heating_up_time_noted" value="{{ old('step_3_dryer_1_heating_up_time_noted') ?? $data->ozon->step_3_dryer_1_heating_up_time_noted }}">
    @if($errors->has('step_3_dryer_1_heating_up_time_noted'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_up_time_noted') }}</em> @endif
    </td>
    
    <td colspan="1" style="text-align: left;">Heating Up Time  </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_2_heating_up_time_before @if($errors->has('step_3_dryer_2_heating_up_time_before')) error @endif"  id="step_3_dryer_2_heating_up_time_before" name="step_3_dryer_2_heating_up_time_before" value="{{ old('step_3_dryer_2_heating_up_time_before') ?? $data->ozon->step_3_dryer_2_heating_up_time_before }}">
    @if($errors->has('step_3_dryer_2_heating_up_time_before'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_up_time_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_2_heating_up_time_after @if($errors->has('step_3_dryer_2_heating_up_time_after')) error @endif"  id="step_3_dryer_2_heating_up_time_after" name="step_3_dryer_2_heating_up_time_after" value="{{ old('step_3_dryer_2_heating_up_time_after') ?? $data->ozon->step_3_dryer_2_heating_up_time_after}}">
    @if($errors->has('step_3_dryer_2_heating_up_time_after'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_up_time_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_2_heating_up_time_noted @if($errors->has('step_3_dryer_2_heating_up_time_noted')) error @endif"  id="step_3_dryer_2_heating_up_time_noted" name="step_3_dryer_2_heating_up_time_noted" value="{{ old('step_3_dryer_2_heating_up_time_noted') ?? $data->ozon->step_3_dryer_2_heating_up_time_noted }}">
    @if($errors->has('step_3_dryer_2_heating_up_time_noted'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_up_time_noted') }}</em> @endif
    </td>
    
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heating On/Off </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_1_heating_on_off_before @if($errors->has('step_3_dryer_1_heating_on_off_before')) error @endif"  id="step_3_dryer_1_heating_on_off_before" name="step_3_dryer_1_heating_on_off_before" value="{{ old('step_3_dryer_1_heating_on_off_before') ?? $data->ozon->step_3_dryer_1_heating_on_off_before }}">
    @if($errors->has('step_3_dryer_1_heating_on_off_before'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_on_off_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_1_heating_on_off_after @if($errors->has('step_3_dryer_1_heating_on_off_after')) error @endif"  id="step_3_dryer_1_heating_on_off_after" name="step_3_dryer_1_heating_on_off_after" value="{{ old('step_3_dryer_1_heating_on_off_after') ?? $data->ozon->step_3_dryer_1_heating_on_off_after }}">
    @if($errors->has('step_3_dryer_1_heating_on_off_after'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_on_off_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_1_heating_on_off_noted @if($errors->has('step_3_dryer_1_heating_on_off_noted')) error @endif"  id="step_3_dryer_1_heating_on_off_noted" name="step_3_dryer_1_heating_on_off_noted" value="{{ old('step_3_dryer_1_heating_on_off_noted') ?? $data->ozon->step_3_dryer_1_heating_on_off_noted }}">
    @if($errors->has('step_3_dryer_1_heating_on_off_noted'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_on_off_noted') }}</em> @endif
    </td>
    
    <td colspan="1" style="text-align: left;"> Heating On/Off </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_2_heating_on_off_before @if($errors->has('step_3_dryer_2_heating_on_off_before')) error @endif"  id="step_3_dryer_2_heating_on_off_before" name="step_3_dryer_2_heating_on_off_before" value="{{ old('step_3_dryer_2_heating_on_off_before') ?? $data->ozon->step_3_dryer_2_heating_on_off_before }}">
    @if($errors->has('step_3_dryer_2_heating_on_off_before'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_on_off_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_2_heating_on_off_after @if($errors->has('step_3_dryer_2_heating_on_off_after')) error @endif"  id="step_3_dryer_2_heating_on_off_after" name="step_3_dryer_2_heating_on_off_after" value="{{ old('step_3_dryer_2_heating_on_off_after') ?? $data->ozon->step_3_dryer_2_heating_on_off_after }}">
    @if($errors->has('step_3_dryer_2_heating_on_off_after'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_on_off_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_2_heating_on_off_noted @if($errors->has('step_3_dryer_2_heating_on_off_noted')) error @endif"  id="step_3_dryer_2_heating_on_off_noted" name="step_3_dryer_2_heating_on_off_noted" value="{{ old('step_3_dryer_2_heating_on_off_noted') ?? $data->ozon->step_3_dryer_2_heating_on_off_noted }}">
    @if($errors->has('step_3_dryer_2_heating_on_off_noted'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_on_off_noted') }}</em> @endif
    </td>
    
</tr>


<tr>
    <td colspan="1" style="text-align: left;"> Heating Time </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_1_heating_time_before @if($errors->has('step_3_dryer_1_heating_time_before')) error @endif"  id="step_3_dryer_1_heating_time_before" name="step_3_dryer_1_heating_time_before" value="{{ old('step_3_dryer_1_heating_time_before') ?? $data->ozon->step_3_dryer_1_heating_time_before }}">
    @if($errors->has('step_3_dryer_1_heating_time_before'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_time_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_1_heating_time_after @if($errors->has('step_3_dryer_1_heating_time_after')) error @endif"  id="step_3_dryer_1_heating_time_after" name="step_3_dryer_1_heating_time_after" value="{{ old('step_3_dryer_1_heating_time_after') ?? $data->ozon->step_3_dryer_1_heating_time_after }}">
    @if($errors->has('step_3_dryer_1_heating_time_after'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_time_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_1_heating_time_noted @if($errors->has('step_3_dryer_1_heating_time_noted')) error @endif"  id="step_3_dryer_1_heating_time_noted" name="step_3_dryer_1_heating_time_noted" value="{{ old('step_3_dryer_1_heating_time_noted') ?? $data->ozon->step_3_dryer_1_heating_time_noted }}">
    @if($errors->has('step_3_dryer_1_heating_time_noted'))  <em class="error">{{ $errors->first('step_3_dryer_1_heating_time_noted') }}</em> @endif
    </td>
    
    <td colspan="1" style="text-align: left;"> Heating Time </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_2_heating_time_before @if($errors->has('step_3_dryer_2_heating_time_before')) error @endif"  id="step_3_dryer_2_heating_time_before" name="step_3_dryer_2_heating_time_before" value="{{ old('step_3_dryer_2_heating_time_before') ?? $data->ozon->step_3_dryer_2_heating_time_before }}">
    @if($errors->has('step_3_dryer_2_heating_time_before'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_time_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_2_heating_time_after @if($errors->has('step_3_dryer_2_heating_time_after')) error @endif"  id="step_3_dryer_2_heating_time_after" name="step_3_dryer_2_heating_time_after" value="{{ old('step_3_dryer_2_heating_time_after') ?? $data->ozon->step_3_dryer_2_heating_time_after }}">
    @if($errors->has('step_3_dryer_2_heating_time_after'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_time_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_2_heating_time_noted @if($errors->has('step_3_dryer_2_heating_time_noted')) error @endif"  id="step_3_dryer_2_heating_time_noted" name="step_3_dryer_2_heating_time_noted" value="{{ old('step_3_dryer_2_heating_time_noted') ?? $data->ozon->step_3_dryer_2_heating_time_noted }}">
    @if($errors->has('step_3_dryer_2_heating_time_noted'))  <em class="error">{{ $errors->first('step_3_dryer_2_heating_time_noted') }}</em> @endif
    </td>
    
</tr>



<tr>
    <td colspan="1" style="text-align: left;"> Total Reg. Time </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_1_total_time_before @if($errors->has('step_3_dryer_1_total_time_before')) error @endif"  id="step_3_dryer_1_total_time_before" name="step_3_dryer_1_total_time_before" value="{{ old('step_3_dryer_1_total_time_before') ?? $data->ozon->step_3_dryer_1_total_time_before }}">
    @if($errors->has('step_3_dryer_1_total_time_before'))  <em class="error">{{ $errors->first('step_3_dryer_1_total_time_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_1_total_time_after @if($errors->has('step_3_dryer_1_total_time_after')) error @endif"  id="step_3_dryer_1_total_time_after" name="step_3_dryer_1_total_time_after" value="{{ old('step_3_dryer_1_total_time_after') ?? $data->ozon->step_3_dryer_1_total_time_after }}">
    @if($errors->has('step_3_dryer_1_total_time_after'))  <em class="error">{{ $errors->first('step_3_dryer_1_total_time_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_1_total_time_noted @if($errors->has('step_3_dryer_1_total_time_noted')) error @endif"  id="step_3_dryer_1_total_time_noted" name="step_3_dryer_1_total_time_noted" value="{{ old('step_3_dryer_1_total_time_noted') ?? $data->ozon->step_3_dryer_1_total_time_noted }}">
    @if($errors->has('step_3_dryer_1_total_time_noted'))  <em class="error">{{ $errors->first('step_3_dryer_1_total_time_noted') }}</em> @endif
    </td>
    
    <td colspan="1" style="text-align: left;"> Total Reg. Time </td>
    <td colspan="1" style="text-align: left;"> X </td>
    <td colspan="1" style="text-align: left;">  
    <input type="number" step="any" class="form-control step_3_dryer_2_total_time_before @if($errors->has('step_3_dryer_2_total_time_before')) error @endif"  id="step_3_dryer_2_total_time_before" name="step_3_dryer_2_total_time_before" value="{{ old('step_3_dryer_2_total_time_before') ?? $data->ozon->step_3_dryer_2_total_time_before }}">
    @if($errors->has('step_3_dryer_2_total_time_before'))  <em class="error">{{ $errors->first('step_3_dryer_2_total_time_before') }}</em> @endif 
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_3_dryer_2_total_time_after @if($errors->has('step_3_dryer_2_total_time_after')) error @endif"  id="step_3_dryer_2_total_time_after" name="step_3_dryer_2_total_time_after" value="{{ old('step_3_dryer_2_total_time_after') ?? $data->ozon->step_3_dryer_2_total_time_after }}">
    @if($errors->has('step_3_dryer_2_total_time_after'))  <em class="error">{{ $errors->first('step_3_dryer_2_total_time_after') }}</em> @endif 
    </td>
    
    <td colspan="1" style="text-align: left;"> 
    <input type="text" class="form-control step_3_dryer_2_total_time_noted @if($errors->has('step_3_dryer_2_total_time_noted')) error @endif"  id="step_3_dryer_2_total_time_noted" name="step_3_dryer_2_total_time_noted" value="{{ old('step_3_dryer_2_total_time_noted') ?? $data->ozon->step_3_dryer_2_total_time_noted }}">
    @if($errors->has('step_3_dryer_2_total_time_noted'))  <em class="error">{{ $errors->first('step_3_dryer_2_total_time_noted') }}</em> @endif
    </td>
    
</tr>


<tr>
    <td colspan="5" style="text-align: left;">Description : <br>
    <textarea class="form-control step_3_dryer_1_description @if($errors->has('step_3_dryer_1_description')) error @endif"  id="step_3_dryer_1_description" name="step_3_dryer_1_description">{{ old('step_3_dryer_1_description') ?? $data->ozon->step_3_dryer_1_description }}</textarea>
    @if($errors->has('step_3_dryer_1_description'))  <em class="error">{{ $errors->first('step_3_dryer_1_description') }}</em> @endif

    </td>
    <td colspan="5" style="text-align: left;">Description : <br>
    <textarea class="form-control step_3_dryer_2_description @if($errors->has('step_3_dryer_2_description')) error @endif"  id="step_3_dryer_2_description" name="step_3_dryer_2_description">{{ old('step_3_dryer_2_description') ?? $data->ozon->step_3_dryer_2_description }}</textarea>
    @if($errors->has('step_3_dryer_2_description'))  <em class="error">{{ $errors->first('step_3_dryer_2_description') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="10" style="text-align: center;"> <b>Step 4 - Columns of Data & Action</b> </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;"> Voltage </td>
    <td colspan="1" style="text-align: left;"> V </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_4_voltage_1 @if($errors->has('step_4_voltage_1')) error @endif"  id="step_4_voltage_1" name="step_4_voltage_1" value="{{ old('step_4_voltage_1') ?? $data->ozon->step_4_voltage_1 }}">
    @if($errors->has('step_4_voltage_1'))  <em class="error">{{ $errors->first('step_4_voltage_1') }}</em> @endif
    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_4_voltage_2 @if($errors->has('step_4_voltage_2')) error @endif"  id="step_4_voltage_2" name="step_4_voltage_2" value="{{ old('step_4_voltage_2') ?? $data->ozon->step_4_voltage_2 }}">
    @if($errors->has('step_4_voltage_2'))  <em class="error">{{ $errors->first('step_4_voltage_2') }}</em> @endif
    </td>
    <td colspan="2" style="text-align: left;"> **** </td>
    <td colspan="1" style="text-align: left;"> Phase R </td>
    <td colspan="1" style="text-align: left;"> Phase S </td>
    <td colspan="1" style="text-align: left;"> Phase T </td>
</tr>

<tr>
    <td colspan="2" style="text-align: left;"> Voltage </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_4_current_consumption_1 @if($errors->has('step_4_current_consumption_1')) error @endif"  id="step_4_current_consumption_1" name="step_4_current_consumption_1" value="{{ old('step_4_current_consumption_1') ?? $data->ozon->step_4_current_consumption_1 }}">
    @if($errors->has('step_4_current_consumption_1'))  <em class="error">{{ $errors->first('step_4_current_consumption_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_4_current_consumption_2 @if($errors->has('step_4_current_consumption_2')) error @endif"  id="step_4_current_consumption_2" name="step_4_current_consumption_2" value="{{ old('step_4_current_consumption_2') ?? $data->ozon->step_4_current_consumption_2 }}">
    @if($errors->has('step_4_current_consumption_2'))  <em class="error">{{ $errors->first('step_4_current_consumption_2') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> Booster Pump </td>
    <td colspan="1" style="text-align: left;"> A </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_booster_pump_phase_r @if($errors->has('step_4_booster_pump_phase_r')) error @endif"  id="step_4_booster_pump_phase_r" name="step_4_booster_pump_phase_r" value="{{ old('step_4_booster_pump_phase_r') ?? $data->ozon->step_4_booster_pump_phase_r }}">
    @if($errors->has('step_4_booster_pump_phase_r'))  <em class="error">{{ $errors->first('step_4_booster_pump_phase_r') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 
    <input type="number" step="any" class="form-control step_4_booster_pump_phase_s @if($errors->has('step_4_booster_pump_phase_s')) error @endif"  id="step_4_booster_pump_phase_s" name="step_4_booster_pump_phase_s" value="{{ old('step_4_booster_pump_phase_s') ?? $data->ozon->step_4_booster_pump_phase_s }}">
    @if($errors->has('step_4_booster_pump_phase_s'))  <em class="error">{{ $errors->first('step_4_booster_pump_phase_s') }}</em> @endif

     </td>
    <td colspan="1" style="text-align: left;">
    <input type="number" step="any" class="form-control step_4_booster_pump_phase_t @if($errors->has('step_4_booster_pump_phase_t')) error @endif"  id="step_4_booster_pump_phase_t" name="step_4_booster_pump_phase_t" value="{{ old('step_4_booster_pump_phase_t') ?? $data->ozon->step_4_booster_pump_phase_t }}">
    @if($errors->has('step_4_booster_pump_phase_t'))  <em class="error">{{ $errors->first('step_4_booster_pump_phase_t') }}</em> @endif
    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Ozone Level </td>
    <td colspan="1" style="text-align: left;"> step </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_ozone_level_1 @if($errors->has('step_4_ozone_level_1')) error @endif"  id="step_4_ozone_level_1" name="step_4_ozone_level_1" value="{{ old('step_4_ozone_level_1') ?? $data->ozon->step_4_ozone_level_1 }}">
    @if($errors->has('step_4_ozone_level_1'))  <em class="error">{{ $errors->first('step_4_ozone_level_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_ozone_level_2 @if($errors->has('step_4_ozone_level_2')) error @endif"  id="step_4_ozone_level_2" name="step_4_ozone_level_2" value="{{ old('step_4_ozone_level_2') ?? $data->ozon->step_4_ozone_level_2 }}">
    @if($errors->has('step_4_ozone_level_2'))  <em class="error">{{ $errors->first('step_4_ozone_level_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Check Original part & function </td>
    <td colspan="1" style="text-align: center;"> 
    √

    </td>
    <td colspan="1" style="text-align: center;"> 
    X

     </td>
    <td colspan="1" style="text-align: center;">
    Description
    </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;"> Excess Ozone in water </td>
    <td colspan="1" style="text-align: left;"> mg/l </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_excess_ozone_1 @if($errors->has('step_4_excess_ozone_1')) error @endif"  id="step_4_excess_ozone_1" name="step_4_excess_ozone_1" value="{{ old('step_4_excess_ozone_1') ?? $data->ozon->step_4_excess_ozone_1 }}">
    @if($errors->has('step_4_excess_ozone_1'))  <em class="error">{{ $errors->first('step_4_excess_ozone_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_excess_ozone_2 @if($errors->has('step_4_excess_ozone_2')) error @endif"  id="step_4_excess_ozone_2" name="step_4_excess_ozone_2" value="{{ old('step_4_excess_ozone_2') ?? $data->ozon->step_4_excess_ozone_2 }}">
    @if($errors->has('step_4_excess_ozone_2'))  <em class="error">{{ $errors->first('step_4_excess_ozone_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Glass Breakage Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_glass_breakage_relay') == 'Y' || $data->ozon->step_4_glass_breakage_relay == 'Y') checked="checked" @endif name="step_4_glass_breakage_relay" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_glass_breakage_relay') == 'N' || $data->ozon->step_4_glass_breakage_relay == 'N') checked="checked" @endif name="step_4_glass_breakage_relay" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

       <input type="text" class="form-control step_4_glass_breakage_relay_desc @if($errors->has('step_4_glass_breakage_relay_desc')) error @endif"  id="step_4_glass_breakage_relay_desc" name="step_4_glass_breakage_relay_desc" value="{{ old('step_4_glass_breakage_relay_desc') ?? $data->ozon->step_4_glass_breakage_relay_desc }}">
    @if($errors->has('step_4_glass_breakage_relay_desc'))  <em class="error">{{ $errors->first('step_4_glass_breakage_relay_desc') }}</em> @endif

    </td>
</tr>


<tr>
    <td colspan="2" style="text-align: left;"> Water Flow Rate </td>
    <td colspan="1" style="text-align: left;"> m³/h </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_water_flow_1 @if($errors->has('step_4_water_flow_1')) error @endif"  id="step_4_water_flow_1" name="step_4_water_flow_1" value="{{ old('step_4_water_flow_1') ?? $data->ozon->step_4_water_flow_1 }}">
    @if($errors->has('step_4_water_flow_1'))  <em class="error">{{ $errors->first('step_4_water_flow_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_water_flow_2 @if($errors->has('step_4_water_flow_2')) error @endif"  id="step_4_water_flow_2" name="step_4_water_flow_2" value="{{ old('step_4_water_flow_2') ?? $data->ozon->step_4_water_flow_2 }}">
    @if($errors->has('step_4_water_flow_2'))  <em class="error">{{ $errors->first('step_4_water_flow_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Glass Breakage Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_high_voltage_cable') == 'Y' || $data->ozon->step_4_high_voltage_cable == 'Y') checked="checked" @endif name="step_4_high_voltage_cable" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_high_voltage_cable') == 'N' || $data->ozon->step_4_high_voltage_cable == 'N') checked="checked" @endif name="step_4_high_voltage_cable" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_high_voltage_cable_desc @if($errors->has('step_4_high_voltage_cable_desc')) error @endif"  id="step_4_high_voltage_cable_desc" name="step_4_high_voltage_cable_desc" value="{{ old('step_4_high_voltage_cable_desc') ?? $data->ozon->step_4_high_voltage_cable_desc }}">
    @if($errors->has('step_4_high_voltage_cable_desc'))  <em class="error">{{ $errors->first('step_4_high_voltage_cable_desc') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Flow Cooling Water </td>
    <td colspan="1" style="text-align: left;"> l/h </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_flow_cooling_1 @if($errors->has('step_4_flow_cooling_1')) error @endif"  id="step_4_flow_cooling_1" name="step_4_flow_cooling_1" value="{{ old('step_4_flow_cooling_1') ?? $data->ozon->step_4_flow_cooling_1 }}">
    @if($errors->has('step_4_flow_cooling_1'))  <em class="error">{{ $errors->first('step_4_flow_cooling_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_flow_cooling_2 @if($errors->has('step_4_flow_cooling_2')) error @endif"  id="step_4_flow_cooling_2" name="step_4_flow_cooling_2" value="{{ old('step_4_flow_cooling_2') ?? $data->ozon->step_4_flow_cooling_2 }}">
    @if($errors->has('step_4_flow_cooling_2'))  <em class="error">{{ $errors->first('step_4_flow_cooling_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_relay') == 'Y' || $data->ozon->step_4_relay == 'Y') checked="checked" @endif name="step_4_relay" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_relay') == 'N' || $data->ozon->step_4_relay == 'N') checked="checked" @endif name="step_4_relay" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_relay_desc @if($errors->has('step_4_relay_desc')) error @endif"  id="step_4_relay_desc" name="step_4_relay_desc" value="{{ old('step_4_relay_desc') ?? $data->ozon->step_4_relay_desc }}">
    @if($errors->has('step_4_relay_desc'))  <em class="error">{{ $errors->first('step_4_relay_desc') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Flow Vaccum </td>
    <td colspan="1" style="text-align: left;"> Nm³/h </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_flow_vaccum_1 @if($errors->has('step_4_flow_vaccum_1')) error @endif"  id="step_4_flow_vaccum_1" name="step_4_flow_vaccum_1" value="{{ old('step_4_flow_vaccum_1') ?? $data->ozon->step_4_flow_vaccum_1 }}">
    @if($errors->has('step_4_flow_vaccum_1'))  <em class="error">{{ $errors->first('step_4_flow_vaccum_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_flow_vaccum_2 @if($errors->has('step_4_flow_vaccum_2')) error @endif"  id="step_4_flow_vaccum_2" name="step_4_flow_vaccum_2" value="{{ old('step_4_flow_vaccum_2') ?? $data->ozon->step_4_flow_vaccum_2 }}">
    @if($errors->has('step_4_flow_vaccum_2'))  <em class="error">{{ $errors->first('step_4_flow_vaccum_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Relay </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_noise_filter') == 'Y' || $data->ozon->step_4_noise_filter == 'Y') checked="checked" @endif name="step_4_noise_filter" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_noise_filter') == 'N' || $data->ozon->step_4_noise_filter == 'N') checked="checked" @endif name="step_4_noise_filter" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_noise_filter_desc @if($errors->has('step_4_noise_filter_desc')) error @endif"  id="step_4_noise_filter_desc" name="step_4_noise_filter_desc" value="{{ old('step_4_noise_filter_desc') ?? $data->ozon->step_4_noise_filter_desc }}">
    @if($errors->has('step_4_noise_filter_desc'))  <em class="error">{{ $errors->first('step_4_noise_filter_desc') }}</em> @endif

    </td>
</tr>




<tr>
    <td colspan="2" style="text-align: left;"> Injection Pressure In</td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_injection_pressure_in_1 @if($errors->has('step_4_injection_pressure_in_1')) error @endif"  id="step_4_injection_pressure_in_1" name="step_4_injection_pressure_in_1" value="{{ old('step_4_injection_pressure_in_1') ?? $data->ozon->step_4_injection_pressure_in_1 }}">
    @if($errors->has('step_4_injection_pressure_in_1'))  <em class="error">{{ $errors->first('step_4_injection_pressure_in_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_injection_pressure_in_2 @if($errors->has('step_4_injection_pressure_in_2')) error @endif"  id="step_4_injection_pressure_in_2" name="step_4_injection_pressure_in_2" value="{{ old('step_4_injection_pressure_in_2') ?? $data->ozon->step_4_injection_pressure_in_2 }}">
    @if($errors->has('step_4_injection_pressure_in_2'))  <em class="error">{{ $errors->first('step_4_injection_pressure_in_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Solenoid Valve Regeneration </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_solenoid_valve') == 'Y' || $data->ozon->step_4_solenoid_valve == 'Y') checked="checked" @endif name="step_4_solenoid_valve" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_solenoid_valve') == 'N' || $data->ozon->step_4_solenoid_valve == 'N') checked="checked" @endif name="step_4_solenoid_valve" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_solenoid_valve_desc @if($errors->has('step_4_solenoid_valve_desc')) error @endif"  id="step_4_solenoid_valve_desc" name="step_4_solenoid_valve_desc" value="{{ old('step_4_solenoid_valve_desc') ?? $data->ozon->step_4_solenoid_valve_desc }}">
    @if($errors->has('step_4_solenoid_valve_desc'))  <em class="error">{{ $errors->first('step_4_solenoid_valve_desc') }}</em> @endif

    </td>
</tr>




<tr>
    <td colspan="2" style="text-align: left;"> Injection Pressure Out </td>
    <td colspan="1" style="text-align: left;"> bar </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_injection_pressure_out_1 @if($errors->has('step_4_injection_pressure_out_1')) error @endif"  id="step_4_injection_pressure_out_1" name="step_4_injection_pressure_out_1" value="{{ old('step_4_injection_pressure_out_1') ?? $data->ozon->step_4_injection_pressure_out_1 }}">
    @if($errors->has('step_4_injection_pressure_out_1'))  <em class="error">{{ $errors->first('step_4_injection_pressure_out_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_injection_pressure_out_2 @if($errors->has('step_4_injection_pressure_out_2')) error @endif"  id="step_4_injection_pressure_out_2" name="step_4_injection_pressure_out_2" value="{{ old('step_4_injection_pressure_out_2') ?? $data->ozon->step_4_injection_pressure_out_2 }}">
    @if($errors->has('step_4_injection_pressure_out_2'))  <em class="error">{{ $errors->first('step_4_injection_pressure_out_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Solenoid Valve Operation </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_solenoid_valve_operation') == 'Y' || $data->ozon->step_4_solenoid_valve_operation == 'Y') checked="checked" @endif name="step_4_solenoid_valve_operation" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
    <input type="radio" @if(old('step_4_solenoid_valve_operation') == 'N' || $data->ozon->step_4_solenoid_valve_operation == 'N') checked="checked" @endif name="step_4_solenoid_valve_operation" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_solenoid_valve_operation_desc @if($errors->has('step_4_solenoid_valve_operation_desc')) error @endif"  id="step_4_solenoid_valve_operation_desc" name="step_4_solenoid_valve_operation_desc" value="{{ old('step_4_solenoid_valve_operation_desc') ?? $data->ozon->step_4_solenoid_valve_operation_desc }}">
    @if($errors->has('step_4_solenoid_valve_operation_desc'))  <em class="error">{{ $errors->first('step_4_solenoid_valve_operation_desc') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="2" style="text-align: left;"> Vaccum in PLC </td>
    <td colspan="1" style="text-align: left;"> Nm³/h </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_vaccu_in_plc_1 @if($errors->has('step_4_vaccu_in_plc_1')) error @endif"  id="step_4_vaccu_in_plc_1" name="step_4_vaccu_in_plc_1" value="{{ old('step_4_vaccu_in_plc_1') ?? $data->ozon->step_4_vaccu_in_plc_1 }}">
    @if($errors->has('step_4_vaccu_in_plc_1'))  <em class="error">{{ $errors->first('step_4_vaccu_in_plc_1') }}</em> @endif
    
    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_vaccu_in_plc_2 @if($errors->has('step_4_vaccu_in_plc_2')) error @endif"  id="step_4_vaccu_in_plc_2" name="step_4_vaccu_in_plc_2" value="{{ old('step_4_vaccu_in_plc_2') ?? $data->ozon->step_4_vaccu_in_plc_2 }}">
    @if($errors->has('step_4_vaccu_in_plc_2'))  <em class="error">{{ $errors->first('step_4_vaccu_in_plc_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Thermostat       16S5 </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_thermostat') == 'Y' || $data->ozon->step_4_thermostat  == 'Y') checked="checked" @endif name="step_4_thermostat" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_thermostat') == 'N' || $data->ozon->step_4_thermostat  == 'N') checked="checked" @endif name="step_4_thermostat" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_thermostat_desc @if($errors->has('step_4_thermostat_desc')) error @endif"  id="step_4_thermostat_desc" name="step_4_thermostat_desc" value="{{ old('step_4_thermostat_desc') ?? $data->ozon->step_4_thermostat_desc }}">
    @if($errors->has('step_4_thermostat_desc'))  <em class="error">{{ $errors->first('step_4_thermostat_desc') }}</em> @endif

    </td>
</tr>





<tr>
    <td colspan="2" style="text-align: left;"> Max absolute humidity </td>
    <td colspan="1" style="text-align: left;"> g/m³ </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_absolute_humidity_1 @if($errors->has('step_4_absolute_humidity_1')) error @endif"  id="step_4_absolute_humidity_1" name="step_4_absolute_humidity_1" value="{{ old('step_4_absolute_humidity_1') ?? $data->ozon->step_4_absolute_humidity_1 }}">
    @if($errors->has('step_4_absolute_humidity_1'))  <em class="error">{{ $errors->first('step_4_absolute_humidity_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_absolute_humidity_2 @if($errors->has('step_4_absolute_humidity_2')) error @endif"  id="step_4_absolute_humidity_2" name="step_4_absolute_humidity_2" value="{{ old('step_4_absolute_humidity_2') ?? $data->ozon->step_4_absolute_humidity_2 }}">
    @if($errors->has('step_4_absolute_humidity_2'))  <em class="error">{{ $errors->first('step_4_absolute_humidity_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Thermostat      26S2 </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_thermostat_26S2') == 'Y' || $data->ozon->step_4_thermostat_26S2 == 'Y') checked="checked" @endif name="step_4_thermostat_26S2" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_thermostat_26S2') == 'N' || $data->ozon->step_4_thermostat_26S2 == 'N') checked="checked" @endif name="step_4_thermostat_26S2" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_thermostat_26S2_desc @if($errors->has('step_4_thermostat_26S2_desc')) error @endif"  id="step_4_thermostat_26S2_desc" name="step_4_thermostat_26S2_desc" value="{{ old('step_4_thermostat_26S2_desc') ?? $data->ozon->step_4_thermostat_26S2_desc }}">
    @if($errors->has('step_4_thermostat_26S2_desc'))  <em class="error">{{ $errors->first('step_4_thermostat_26S2_desc') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Total Operation Time </td>
    <td colspan="1" style="text-align: left;"> min </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_total_operation_time_1 @if($errors->has('step_4_total_operation_time_1')) error @endif"  id="step_4_total_operation_time_1" name="step_4_total_operation_time_1" value="{{ old('step_4_total_operation_time_1') ?? $data->ozon->step_4_total_operation_time_1 }}">
    @if($errors->has('step_4_total_operation_time_1'))  <em class="error">{{ $errors->first('step_4_total_operation_time_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_total_operation_time_2 @if($errors->has('step_4_total_operation_time_2')) error @endif"  id="step_4_total_operation_time_2" name="step_4_total_operation_time_2" value="{{ old('step_4_total_operation_time_2') ?? $data->ozon->step_4_total_operation_time_2 }}">
    @if($errors->has('step_4_total_operation_time_2'))  <em class="error">{{ $errors->first('step_4_total_operation_time_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Ozone Fault main pump cut off </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_ozone_fault') == 'Y' || $data->ozon->step_4_ozone_fault == 'Y') checked="checked" @endif name="step_4_ozone_fault" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_ozone_fault') == 'N' || $data->ozon->step_4_ozone_fault == 'N') checked="checked" @endif name="step_4_ozone_fault" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_ozone_fault_desc @if($errors->has('step_4_ozone_fault_desc')) error @endif"  id="step_4_ozone_fault_desc" name="step_4_ozone_fault_desc" value="{{ old('step_4_ozone_fault_desc') ?? $data->ozon->step_4_ozone_fault_desc }}">
    @if($errors->has('step_4_ozone_fault_desc'))  <em class="error">{{ $errors->first('step_4_ozone_fault_desc') }}</em> @endif

    </td>
</tr>



<tr>
    <td colspan="2" style="text-align: left;"> Software PLC & OP 3 </td>
    <td colspan="1" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_software_plc_1 @if($errors->has('step_4_software_plc_1')) error @endif"  id="step_4_software_plc_1" name="step_4_software_plc_1" value="{{ old('step_4_software_plc_1') ?? $data->ozon->step_4_software_plc_1 }}">
    @if($errors->has('step_4_software_plc_1'))  <em class="error">{{ $errors->first('step_4_software_plc_1') }}</em> @endif

    </td>
    <td colspan="1" style="text-align: left;"> 

    <input type="number" step="any" class="form-control step_4_software_plc_2 @if($errors->has('step_4_software_plc_2')) error @endif"  id="step_4_software_plc_2" name="step_4_software_plc_2" value="{{ old('step_4_software_plc_2') ?? $data->ozon->step_4_software_plc_2 }}">
    @if($errors->has('step_4_software_plc_2'))  <em class="error">{{ $errors->first('step_4_software_plc_2') }}</em> @endif

    </td>
    <td colspan="2" style="text-align: center;"> Noted all fault data & reset </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_noted_all') == 'Y' || $data->ozon->step_4_noted_all == 'Y') checked="checked" @endif name="step_4_noted_all" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_noted_all') == 'N' || $data->ozon->step_4_noted_all == 'N') checked="checked" @endif name="step_4_noted_all" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_noted_all_desc @if($errors->has('step_4_noted_all_desc')) error @endif"  id="step_4_noted_all_desc" name="step_4_noted_all_desc" value="{{ old('step_4_noted_all_desc') ?? $data->ozon->step_4_noted_all_desc }}">
    @if($errors->has('step_4_noted_all_desc'))  <em class="error">{{ $errors->first('step_4_noted_all_desc') }}</em> @endif

    </td>
</tr>
<tr>
    <td colspan="4" style="text-align: cecnter;"> HITORY FAULTS </td>
    <td colspan="1" style="text-align: center;"> X </td>
    <td colspan="2" style="text-align: left;"> Check Butterfly Flap </td>
    <td colspan="1" style="text-align: center;"> 
     

    </td>
    <td colspan="1" style="text-align: center;">  

     </td>
    <td colspan="1" style="text-align: center;"> 
    </td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Regeneration blower failure </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_regeneration_blower_failure @if($errors->has('step_4_regeneration_blower_failure')) error @endif"  id="step_4_regeneration_blower_failure" name="step_4_regeneration_blower_failure" value="{{ old('step_4_regeneration_blower_failure') ?? $data->ozon->step_4_regeneration_blower_failure }}">
    @if($errors->has('step_4_regeneration_blower_failure'))  <em class="error">{{ $errors->first('step_4_regeneration_blower_failure') }}</em> @endif
	
	</td>
    <td colspan="2" style="text-align: center;"> * Open </td>
 <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_open') == 'Y' || $data->ozon->step_4_open == 'Y') checked="checked" @endif name="step_4_open" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_open') == 'N' || $data->ozon->step_4_open == 'N') checked="checked" @endif name="step_4_open" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_open_desc @if($errors->has('step_4_open_desc')) error @endif"  id="step_4_open_desc" name="step_4_open_desc" value="{{ old('step_4_open_desc') }}">
    @if($errors->has('step_4_open_desc'))  <em class="error">{{ $errors->first('step_4_open_desc') }}</em> @endif

    </td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Heating time in dryer 1 dan dryer 2 </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_heating_time_in_dryer_1_dan_dryer_2 @if($errors->has('step_4_heating_time_in_dryer_1_dan_dryer_2')) error @endif"  id="step_4_heating_time_in_dryer_1_dan_dryer_2" name="step_4_heating_time_in_dryer_1_dan_dryer_2" value="{{ old('step_4_heating_time_in_dryer_1_dan_dryer_2') ?? $data->ozon->step_4_heating_time_in_dryer_1_dan_dryer_2 }}">
    @if($errors->has('step_4_heating_time_in_dryer_1_dan_dryer_2'))  <em class="error">{{ $errors->first('step_4_heating_time_in_dryer_1_dan_dryer_2') }}</em> @endif
	
	</td>
    <td colspan="2" style="text-align: center;"> * Close </td>
 <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_close') == 'Y') checked="checked" @endif name="step_4_close" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_close') == 'N') checked="checked" @endif name="step_4_close" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_close_desc @if($errors->has('step_4_close_desc')) error @endif"  id="step_4_close_desc" name="step_4_close_desc" value="{{ old('step_4_close_desc') }}">
    @if($errors->has('step_4_close_desc'))  <em class="error">{{ $errors->first('step_4_close_desc') }}</em> @endif

    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Thermostat dryer 1 dan dryer 2 </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_thermostat_dryer_1_dan_dryer_2 @if($errors->has('step_4_thermostat_dryer_1_dan_dryer_2')) error @endif"  id="step_4_thermostat_dryer_1_dan_dryer_2" name="step_4_thermostat_dryer_1_dan_dryer_2" value="{{ old('step_4_thermostat_dryer_1_dan_dryer_2') ?? $data->ozon->step_4_thermostat_dryer_1_dan_dryer_2 }}">
    @if($errors->has('step_4_thermostat_dryer_1_dan_dryer_2'))  <em class="error">{{ $errors->first('step_4_thermostat_dryer_1_dan_dryer_2') }}</em> @endif
	
	</td>
    <td colspan="2" style="text-align: center;"> Seal Check Valve Injection </td>
 <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_seal_check_valve_injection') == 'Y' || $data->ozon->step_4_seal_check_valve_injection == 'Y') checked="checked" @endif name="step_4_seal_check_valve_injection" value="Y">

    </td>
    <td colspan="1" style="text-align: center;"> 
    
 <input type="radio" @if(old('step_4_seal_check_valve_injection') == 'N' || $data->ozon->step_4_seal_check_valve_injection == 'N') checked="checked" @endif name="step_4_seal_check_valve_injection" value="N">

     </td>
    <td colspan="1" style="text-align: center;">

    <input type="text" class="form-control step_4_seal_check_valve_injection_desc @if($errors->has('step_4_seal_check_valve_injection_desc')) error @endif"  id="step_4_seal_check_valve_injection_desc" name="step_4_seal_check_valve_injection_desc" value="{{ old('step_4_seal_check_valve_injection_desc') ?? $data->ozon->step_4_seal_check_valve_injection_desc }}">
    @if($errors->has('step_4_seal_check_valve_injection_desc'))  <em class="error">{{ $errors->first('step_4_seal_check_valve_injection_desc') }}</em> @endif

    </td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Ozone mixing/air flow low </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_ozone_mixing @if($errors->has('step_4_ozone_mixing')) error @endif"  id="step_4_ozone_mixing" name="step_4_ozone_mixing" value="{{ old('step_4_ozone_mixing') ?? $data->ozon->step_4_ozone_mixing }}">
    @if($errors->has('step_4_ozone_mixing'))  <em class="error">{{ $errors->first('step_4_ozone_mixing') }}</em> @endif
	
	</td>
    <td colspan="5" style="text-align: center;"> Step 5 - Check Safety Unit Ozone </td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Cooling water temp. too high/flow low </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_cooling_water @if($errors->has('step_4_cooling_water')) error @endif"  id="step_4_cooling_water" name="step_4_cooling_water" value="{{ old('step_4_cooling_water') ?? $data->ozon->step_4_cooling_water }}">
    @if($errors->has('step_4_cooling_water'))  <em class="error">{{ $errors->first('step_4_cooling_water') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;">  </td>
    <td colspan="1" style="text-align: center;"> Description </td>
</tr>
 
<tr>
    <td colspan="4" style="text-align: left;"> Ozone cabinet door switch open/emergency stop </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_ozone_cabinet_door @if($errors->has('step_4_ozone_cabinet_door')) error @endif"  id="step_4_ozone_cabinet_door" name="step_4_ozone_cabinet_door" value="{{ old('step_4_ozone_cabinet_door') ?? $data->ozon->step_4_ozone_cabinet_door }}">
    @if($errors->has('step_4_ozone_cabinet_door'))  <em class="error">{{ $errors->first('step_4_ozone_cabinet_door') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;"> Water inrush in ozone generation </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_water_inrush_in_ozone_generation @if($errors->has('step_5_water_inrush_in_ozone_generation')) error @endif"  id="step_5_water_inrush_in_ozone_generation" name="step_5_water_inrush_in_ozone_generation" value="{{ old('step_5_water_inrush_in_ozone_generation') ?? $data->ozon->step_5_water_inrush_in_ozone_generation }}">
    @if($errors->has('step_5_water_inrush_in_ozone_generation'))  <em class="error">{{ $errors->first('step_5_water_inrush_in_ozone_generation') }}</em> @endif
	
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Air too hot </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_air_too_hot @if($errors->has('step_4_air_too_hot')) error @endif"  id="step_4_air_too_hot" name="step_4_air_too_hot" value="{{ old('step_4_air_too_hot') ?? $data->ozon->step_4_air_too_hot }}">
    @if($errors->has('step_4_air_too_hot'))  <em class="error">{{ $errors->first('step_4_air_too_hot') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;"> Ozone mixing/air flow low </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_ozone_mixing @if($errors->has('step_5_ozone_mixing')) error @endif"  id="step_5_ozone_mixing" name="step_5_ozone_mixing" value="{{ old('step_5_ozone_mixing') ?? $data->ozon->step_5_ozone_mixing }}">
    @if($errors->has('step_5_ozone_mixing'))  <em class="error">{{ $errors->first('step_5_ozone_mixing') }}</em> @endif
	
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Mains power supply phase failure </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_mains_power_supply_phase_failure @if($errors->has('step_4_mains_power_supply_phase_failure')) error @endif"  id="step_4_mains_power_supply_phase_failure" name="step_4_mains_power_supply_phase_failure" value="{{ old('step_4_mains_power_supply_phase_failure') ?? $data->ozon->step_4_mains_power_supply_phase_failure }}">
    @if($errors->has('step_4_mains_power_supply_phase_failure'))  <em class="error">{{ $errors->first('step_4_mains_power_supply_phase_failure') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;"> Cooling water temp. too high </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_cooling_water_temp @if($errors->has('step_5_cooling_water_temp')) error @endif"  id="step_5_cooling_water_temp" name="step_5_cooling_water_temp" value="{{ old('step_5_cooling_water_temp') ?? $data->ozon->step_5_cooling_water_temp }}">
    @if($errors->has('step_5_cooling_water_temp'))  <em class="error">{{ $errors->first('step_5_cooling_water_temp') }}</em> @endif
	
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Water inrush in ozone generation </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_water_inrush_in_ozone_generation @if($errors->has('step_4_water_inrush_in_ozone_generation')) error @endif"  id="step_4_water_inrush_in_ozone_generation" name="step_4_water_inrush_in_ozone_generation" value="{{ old('step_4_water_inrush_in_ozone_generation') ?? $data->ozon->step_4_water_inrush_in_ozone_generation }}">
    @if($errors->has('step_4_water_inrush_in_ozone_generation'))  <em class="error">{{ $errors->first('step_4_water_inrush_in_ozone_generation') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;"> Cleaning Unit Ozone & etc </td>
    <td colspan="1" style="text-align: center;"> 
 
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;"> Booster pump failure/off </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_booster_pump_failure @if($errors->has('step_4_booster_pump_failure')) error @endif"  id="step_4_booster_pump_failure" name="step_4_booster_pump_failure" value="{{ old('step_4_booster_pump_failure') ?? $data->ozon->step_4_booster_pump_failure }}">
    @if($errors->has('step_4_booster_pump_failure'))  <em class="error">{{ $errors->first('step_4_booster_pump_failure') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;"> Trafo High Voltage </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_trafo_high_voltage @if($errors->has('step_5_trafo_high_voltage')) error @endif"  id="step_5_trafo_high_voltage" name="step_5_trafo_high_voltage" value="{{ old('step_5_trafo_high_voltage') ?? $data->ozon->step_5_trafo_high_voltage }}">
    @if($errors->has('step_5_trafo_high_voltage'))  <em class="error">{{ $errors->first('step_5_trafo_high_voltage') }}</em> @endif
	
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> Ozone generation </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_ozone_generation @if($errors->has('step_4_ozone_generation')) error @endif"  id="step_4_ozone_generation" name="step_4_ozone_generation" value="{{ old('step_4_ozone_generation') ?? $data->ozon->step_4_ozone_generation }}">
    @if($errors->has('step_4_ozone_generation'))  <em class="error">{{ $errors->first('step_4_ozone_generation') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;"> Tube Generator </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_tube_generator @if($errors->has('step_5_tube_generator')) error @endif"  id="step_5_tube_generator" name="step_5_tube_generator" value="{{ old('step_5_tube_generator') ?? $data->ozon->step_5_tube_generator }}">
    @if($errors->has('step_5_tube_generator'))  <em class="error">{{ $errors->first('step_5_tube_generator') }}</em> @endif
	
	</td>
</tr>


<tr>
    <td colspan="4" style="text-align: left;"> ozone gas warning </td>
    <td colspan="1" style="text-align: left;"> 
	
    <input type="text" class="form-control step_4_ozone_gas_warning @if($errors->has('step_4_ozone_gas_warning')) error @endif"  id="step_4_ozone_gas_warning" name="step_4_ozone_gas_warning" value="{{ old('step_4_ozone_gas_warning') ?? $data->ozon->step_4_ozone_gas_warning }}">
    @if($errors->has('step_4_ozone_gas_warning'))  <em class="error">{{ $errors->first('step_4_ozone_gas_warning') }}</em> @endif
	
	</td>
    <td colspan="4" style="text-align: center;"> Filter Cabinet Fan/Change </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_filter_cabinet_fan @if($errors->has('step_5_filter_cabinet_fan')) error @endif"  id="step_5_filter_cabinet_fan" name="step_5_filter_cabinet_fan" value="{{ old('step_5_filter_cabinet_fan') ?? $data->ozon->step_5_filter_cabinet_fan }}">
    @if($errors->has('step_5_filter_cabinet_fan'))  <em class="error">{{ $errors->first('step_5_filter_cabinet_fan') }}</em> @endif
	
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> 
	 
	</td>
    <td colspan="4" style="text-align: center;"> Filter Cooling Water </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_filter_cooling_water @if($errors->has('step_5_filter_cooling_water')) error @endif"  id="step_5_filter_cooling_water" name="step_5_filter_cooling_water" value="{{ old('step_5_filter_cooling_water') ?? $data->ozon->step_5_filter_cooling_water }}">
    @if($errors->has('step_5_filter_cooling_water'))  <em class="error">{{ $errors->first('step_5_filter_cooling_water') }}</em> @endif
	
	</td>
</tr>

<tr>
    <td colspan="4" style="text-align: left;">  </td>
    <td colspan="1" style="text-align: left;"> 
	 
	</td>
    <td colspan="4" style="text-align: center;"> Seal Check Valve </td>
    <td colspan="1" style="text-align: center;"> 

    <input type="text" class="form-control step_5_seal_check_valve @if($errors->has('step_5_seal_check_valve')) error @endif"  id="step_5_seal_check_valve" name="step_5_seal_check_valve" value="{{ old('step_5_seal_check_valve') ?? $data->ozon->step_5_seal_check_valve }}">
    @if($errors->has('step_5_seal_check_valve'))  <em class="error">{{ $errors->first('step_5_seal_check_valve') }}</em> @endif
	
	</td>
</tr>
 


<tr>
    <td colspan="10" style="text-align: center;"> Step 6 - Recommendation/Note </td>
</tr>



<tr>
    <td colspan="10" style="text-align: center;"> 


    <textarea class="form-control step_6_recommendation @if($errors->has('step_6_recommendation')) error @endif"  id="step_6_recommendation" name="step_6_recommendation">{{ old('step_6_recommendation') ?? $data->ozon->step_6_recommendation }}</textarea>
    @if($errors->has('step_6_recommendation'))  <em class="error">{{ $errors->first('step_6_recommendation') }}</em> @endif

    </td>
</tr>


  
<tr>
    <td colspan="10" style="text-align: left;">reminder : <br> 
        <input type="number" step="any" class="form-control reminder @if($errors->has('reminder')) error @endif" id="reminder " name="reminder" value="{{ old('reminder') ?? $data->reminder_service }}">
        @if($errors->has('reminder'))  <em class="error">{{ $errors->first('reminder') }}</em> @endif 
    </td>
</tr>

<tr>
    <td colspan="10" style="text-align: left;">file : 
    @if($data->ozon->file)
        <a href="/public/laporan/{{ $data->ozon->file }}" target="_blank"><input class="submit btn btn-primary" type="button" value="Download"></a>
        @endif
        <br> 
        <input type="file" class="form-control file @if($errors->has('file')) error @endif" id="file " name="file" value="{{ old('file') }}">
        @if($errors->has('file'))  <em class="error">{{ $errors->first('file') }}</em> @endif 
    </td>
</tr>

<tr>
    <td colspan="10" style="text-align: left;">
    <a href="/jadwal/{{ Crypt::encrypt($data->id) }}"><input class="submit btn btn-primary" type="button" value="Kembali"></a>
    <input class="submit btn btn-danger" type="submit" value="Submit"> 
</td>
</tr>



</table>

</form>

</div>




<script type="text/javascript">
    "use strict"; 
     
	$('.date').datepicker({format:'yyyy-mm-dd'});
	$('.year').datepicker({format:'mm/yyyy'});

   $(".select2-A").select2({
      placeholder: "pilih model",
      allowClear: true
    });

var radios = document.getElementsByTagName('input');
for(i=0; i<radios.length; i++ ) {
    radios[i].onclick = function(e) {
        if(e.ctrlKey) {
            this.checked = false;
        }
    }
}
</script>


@endsection