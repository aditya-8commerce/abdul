@extends('layouts.dashboard')
@section('content_dashboard')

<script src="{{ asset('/miminium/js/plugins/select2.full.min.js') }}"></script> 
<link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/select2.min.css') }}"/>
<style>
.diTerima {
  background-color: rgba(21,186,103,0.4);
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.diTolak {
  background-color: rgba(21,113,186,0.5);
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
<div class="panel">
                          <div class="panel-heading bg-white border-none" style="padding:20px;">
                            <div class="col-md-6 col-sm-6 col-sm-12 text-left">
                              <h4>Permintaan Barang @if( Request::get('year')) {{Request::get('year')}} @else {{now()->year}} @endif</h4>
                            </div>
                            
                            <div class="col-md-6 col-sm-6 col-sm-12 text-left">
<form class="cmxform" method="get" action="/grafik-permintaan-barang" novalidate="novalidate">                            
  <select class="select2-A form-control" id="year" name="year" aria-required="true">
    <option value=""> </option>
    @for($x=2019; $x <= now()->year;$x++)
    <option value="{{$x}}">{{$x}}</option>
    @endfor		
    </select>

    <input class="submit btn btn-warning" type="submit" value="Cari">
</form>
                            </div>
                          </div>
                          <div class="panel-body" style="padding-bottom:50px;">
                              <div id="canvas-holder1">
                                <canvas class="bar-chart" height="200" width="400" style="width: 400px; height: 200px;"></canvas>
                          <button type="button" class="diTerima">di Terima</button>
                          <button type="button" class="diTolak">di Tolak</button>
                              </div> 
                          </div>
                        </div>
                        


<script src="{{ asset('/miminium/js/plugins/chart.min.js') }}"></script> 
<script>


            var barChartData = {
                labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
                datasets: [
                    {
                        label: "Setuju",
                        fillColor: "rgba(21,186,103,0.4)",
                        strokeColor: "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(21,186,103,0.2)",
                        highlightStroke: "rgba(21,186,103,0.2)",
                        data: [{{$resultSetujuJanuary->data ?? 0}}, {{$resultSetujuFebruary->data ?? 0}}, {{$resultSetujuMarch->data ?? 0}}, {{$resultSetujuApril->data ?? 0}}, {{$resultSetujuMay->data ?? 0}}, {{$resultSetujuJune->data ?? 0}}, {{$resultSetujuJuly->data ?? 0}}, {{$resultSetujuAugust->data ?? 0}}, {{$resultSetujuSeptember->data ?? 0}}, {{$resultSetujuOctober->data ?? 0}}, {{$resultSetujuNovember->data ?? 0}}, {{$resultSetujuDecember->data ?? 0}}]
                    },
                    {
                        label: "Ditolak",
                        fillColor: "rgba(21,113,186,0.5)",
                        strokeColor: "rgba(151,187,205,0.8)",
                        highlightFill: "rgba(21,113,186,0.2)",
                        highlightStroke: "rgba(21,113,186,0.2)",
                        data: [{{$resultTolakJanuary->data ?? 0}}, {{$resultTolakFebruary->data ?? 0}}, {{$resultTolakMarch->data ?? 0}}, {{$resultTolakApril->data ?? 0}}, {{$resultTolakMay->data ?? 0}}, {{$resultTolakJune->data ?? 0}}, {{$resultTolakJuly->data ?? 0}}, {{$resultTolakAugust->data ?? 0}}, {{$resultTolakSeptember->data ?? 0}}, {{$resultTolakOctober->data ?? 0}}, {{$resultTolakNovember->data ?? 0}}, {{$resultTolakDecember->data ?? 0}}]
                    }
                ]
            };
   window.onload = function(){
            

                var ctx3 = $(".bar-chart")[0].getContext("2d");
                window.myLine = new Chart(ctx3).Bar(barChartData, {
                     responsive: true,
                        showTooltips: true
                });
 

            };
</script>


<script type="text/javascript">
    "use strict"; 
   $(".select2-A").select2({
      placeholder: "pilih model",
      allowClear: true
    });
 
</script>
@endsection
 