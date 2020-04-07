@extends('layouts.dashboard')
@section('content_dashboard')

<script src="{{ asset('/miminium/js/plugins/select2.full.min.js') }}"></script> 
<link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/select2.min.css') }}"/>
<style>
.selesai {
  background-color: rgba(30,232,43);
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
.batal {
  background-color: rgba(151,30,232);
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
.emergency {
  background-color: rgba(218,4,46);
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
.proses {
  background-color: rgba(239,239,15);
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
.sementara {
  background-color: rgba(90,211,242);
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
                              <h4>Jadwal Grafik  @if( Request::get('year')) {{Request::get('year')}} @else {{now()->year}} @endif</h4>
                            </div>
                            
                            <div class="col-md-6 col-sm-6 col-sm-12 text-left">
<form class="cmxform" method="get" action="/home" novalidate="novalidate">                            
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
                          <button type="button" class="selesai">selesai</button>
                          <button type="button" class="batal">batal</button>
                          <button type="button" class="emergency">emergency</button>
                          <button type="button" class="proses">proses</button>
                          <button type="button" class="sementara">sementara</button>
                              </div> 
                          </div>
                        </div>
                        


<script src="{{ asset('/miminium/js/plugins/chart.min.js') }}"></script> 
<script>


            var barChartData = {
                labels: ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"],
                datasets: [
                    {
                        label: "Selesai",
                        fillColor: "rgba(30,232,43)",
                        strokeColor: "rgba(30,232,43,0.8)",
                        highlightFill: "rgba(30,232,43,0.2)",
                        highlightStroke: "rgba(30,232,43,0.2)",
                        data: [{{$selesaiJanuary->data ?? 0}}, {{$selesaiFebruary->data ?? 0}}, {{$selesaiMarch->data ?? 0}}, {{$selesaiApril->data ?? 0}}, {{$selesaiMay->data ?? 0}}, {{$selesaiJune->data ?? 0}}, {{$selesaiJuly->data ?? 0}},  {{$selesaiAugust->data ?? 0}}, {{$selesaiSeptember->data ?? 0}}, {{$selesaiOctober->data ?? 0}}, {{$selesaiNovember->data ?? 0}}, {{$selesaiDecember->data ?? 0}}]
                    },
                    {
                        label: "Batal",
                        fillColor: "rgba(151,30,232)",
                        strokeColor: "rgba(151,30,232,0.8)",
                        highlightFill: "rgba(151,30,232,0.2)",
                        highlightStroke: "rgba(151,30,232,0.2)",
                        data: [{{$batalJanuary->data ?? 0}}, {{$batalFebruary->data ?? 0}}, {{$batalMarch->data ?? 0}}, {{$batalApril->data ?? 0}}, {{$batalMay->data ?? 0}}, {{$batalJune->data ?? 0}}, {{$batalJuly->data ?? 0}}, {{$batalAugust->data ?? 0}}, {{$batalSeptember->data ?? 0}}, {{$batalOctober->data ?? 0}}, {{$batalNovember->data ?? 0}}, {{$batalDecember->data ?? 0}}]
                    },
                    {
                        label: "emergency",
                        fillColor: "rgba(218,4,46)",
                        strokeColor: "rgba(218,4,46,0.8)",
                        highlightFill: "rgba(218,4,46,0.2)",
                        highlightStroke: "rgba(218,4,46,0.2)",
                        data: [{{$prosesDaruratJanuary->data ?? 0}}, {{$prosesDaruratFebruary->data ?? 0}}, {{$prosesDaruratMarch->data ?? 0}}, {{$prosesDaruratApril->data ?? 0}}, {{$prosesDaruratMay->data ?? 0}}, {{$prosesDaruratJune->data ?? 0}}, {{$prosesDaruratJuly->data ?? 0}},  {{$prosesDaruratAugust->data ?? 0}}, {{$prosesDaruratSeptember->data ?? 0}}, {{$prosesDaruratOctober->data ?? 0}}, {{$prosesDaruratNovember->data ?? 0}}, {{$prosesDaruratDecember->data ?? 0}}]
                    },
                    {
                        label: "proses",
                        fillColor: "rgba(239,239,15)",
                        strokeColor: "rgba(239,239,15,0.8)",
                        highlightFill: "rgba(239,239,15,0.2)",
                        highlightStroke: "rgba(239,239,15,0.2)",
                        data: [{{$prosesJanuary->data ?? 0}}, {{$prosesFebruary->data ?? 0}}, {{$prosesMarch->data ?? 0}}, {{$prosesApril->data ?? 0}}, {{$prosesMay->data ?? 0}}, {{$prosesJune->data ?? 0}}, {{$prosesJuly->data ?? 0}},{{$prosesAugust->data ?? 0}}, {{$prosesSeptember->data ?? 0}}, {{$prosesOctober->data ?? 0}}, {{$prosesNovember->data ?? 0}}, {{$prosesDecember->data ?? 0}}]
                    },
                    {
                        label: "sementara",
                        fillColor: "rgba(90,211,242)",
                        strokeColor: "rgba(90,211,242,0.8)",
                        highlightFill: "rgba(90,211,242,0.2)",
                        highlightStroke: "rgba(90,211,242,0.2)",
                        data: [{{$sementaraJanuary->data ?? 0}}, {{$sementaraFebruary->data ?? 0}}, {{$sementaraMarch->data ?? 0}}, {{$sementaraApril->data ?? 0}}, {{$sementaraMay->data ?? 0}}, {{$sementaraJune->data ?? 0}}, {{$sementaraJuly->data ?? 0}},  {{$sementaraAugust->data ?? 0}}, {{$sementaraSeptember->data ?? 0}}, {{$sementaraOctober->data ?? 0}}, {{$sementaraNovember->data ?? 0}}, {{$sementaraDecember->data ?? 0}}]
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
 