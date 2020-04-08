<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Response,View,Input,Auth,Session,Validator,File,Hash,DB,Mail;
use Illuminate\Support\Facades\Crypt;
Use Alert;
use PDF;
 
use App\Models\PermintaanBarang;
use App\Models\Schedule;
use App\Models\VScheduleCustomer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
		$year = now()->year;
		$model = VScheduleCustomer::with("users")
		->whereYear('date_start', '=', $year)
		->orderBy('id','DESC')
        ->get();
		$res = [];
		foreach($model as $key => $k){
			
			$description = '<p>';
			foreach($k->users as $k2){
				$description .= $k2->name." (".$k2->indentity_number.")\n";
			}
			$description .= '</p>';
			$res[] = ["title" => 'BA-'.sprintf("%010d", $k->id).' - '.$k->code , "allday" => false , "customer" => $k->name , "borderColor" => '#'.$k->color , 'description' => $description , 'start' => $k->date_start , 'mulai' => $k->date_start , 'end' => $k->date_finish  , 'selesai' => $k->date_finish , 'address' => $k->address];
			
		}
		return view('home',['model' => $res]);
	}
	
	
    public function chartJadwal(Request $request){
        $year = now()->year;
        if($request->year){
            $year = $request->year;
        }
        $selesaiJanuary = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "01")
        ->first();
         
        $selesaiFebruary = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "02")
        ->first();
         
        $selesaiMarch = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "03")
        ->first();
         
        $selesaiApril = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "04")
        ->first();

         
        $selesaiMay = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "05")
        ->first();

         
        $selesaiJune = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "06")
        ->first();

         
        $selesaiJuly = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "07")
        ->first();

         
        $selesaiAugust = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "08")
        ->first();


         
        $selesaiSeptember = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "09")
        ->first();


         
        $selesaiOctober = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "10")
        ->first();


         
        $selesaiNovember = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "11")
        ->first();


         
        $selesaiDecember = Schedule::selectRaw('count(*) data')
        ->where('status','selesai')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "12")
        ->first();

        $sementaraJanuary = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "01")
        ->first();
         
        $sementaraFebruary = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "02")
        ->first();
         
        $sementaraMarch = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "03")
        ->first();
         
        $sementaraApril = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "04")
        ->first();

         
        $sementaraMay = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "05")
        ->first();

         
        $sementaraJune = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "06")
        ->first();

         
        $sementaraJuly = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "07")
        ->first();

         
        $sementaraAugust = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "08")
        ->first();


         
        $sementaraSeptember = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "09")
        ->first();


         
        $sementaraOctober = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "10")
        ->first();


         
        $sementaraNovember = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "11")
        ->first();


         
        $sementaraDecember = Schedule::selectRaw('count(*) data')
        ->where('status','sementara')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "12")
        ->first();



        $prosesDaruratJanuary = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "01")
        ->first();
         
        $prosesDaruratFebruary = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "02")
        ->first();
         
        $prosesDaruratMarch = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "03")
        ->first();
         
        $prosesDaruratApril = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "04")
        ->first();

         
        $prosesDaruratMay = Schedule::selectRaw('count(*) data')
        ->where('status','prosesDarurat')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "05")
        ->first();

         
        $prosesDaruratJune = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "06")
        ->first();

         
        $prosesDaruratJuly = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "07")
        ->first();

         
        $prosesDaruratAugust = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "08")
        ->first();


         
        $prosesDaruratSeptember = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "09")
        ->first();


         
        $prosesDaruratOctober = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "10")
        ->first();


         
        $prosesDaruratNovember = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "11")
        ->first();


         
        $prosesDaruratDecember = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "12")
        ->first();



        $batalJanuary = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "01")
        ->first();
         
        $batalFebruary = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "02")
        ->first();
         
        $batalMarch = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "03")
        ->first();
         
        $batalApril = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "04")
        ->first();

         
        $batalMay = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "05")
        ->first();

         
        $batalJune = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "06")
        ->first();

         
        $batalJuly = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "07")
        ->first();

         
        $batalAugust = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "08")
        ->first();


         
        $batalSeptember = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "09")
        ->first();


         
        $batalOctober = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "10")
        ->first();


         
        $batalNovember = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "11")
        ->first();


         
        $batalDecember = Schedule::selectRaw('count(*) data')
        ->where('status','batal')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "12")
        ->first();


        $prosesJanuary = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "01")
        ->first();
         
        $prosesFebruary = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "02")
        ->first();
         
        $prosesMarch = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "03")
        ->first();
         
        $prosesApril = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "04")
        ->first();

         
        $prosesMay = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->where('status','proses')
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "05")
        ->first();

         
        $prosesJune = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "06")
        ->first();

         
        $prosesJuly = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "07")
        ->first();

         
        $prosesAugust = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "08")
        ->first();


         
        $prosesSeptember = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "09")
        ->first();


         
        $prosesOctober = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "10")
        ->first();


         
        $prosesNovember = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "11")
        ->first();


         
        $prosesDecember = Schedule::selectRaw('count(*) data')
        ->where([['status','proses'],['type','<>','darurat']])
        ->whereYear('date_start', '=', $year)
        ->whereMonth('date_start', '=', "12")
        ->first();
 
        return view('home',['selesaiJanuary ' => $selesaiJanuary ,
        'selesaiFebruary' => $selesaiFebruary,
        'selesaiMarch' => $selesaiMarch,
        'selesaiApril' => $selesaiApril,
        'selesaiMay' => $selesaiMay,
        'selesaiJune' => $selesaiJune,
        'selesaiJuly' => $selesaiJuly,
        'selesaiAugust' => $selesaiAugust,
        'selesaiSeptember' => $selesaiSeptember,
        'selesaiOctober' => $selesaiOctober,
        'selesaiNovember' => $selesaiNovember,
        'selesaiDecember' => $selesaiDecember,
        'sementaraJanuary' => $sementaraJanuary,
        'sementaraFebruary' => $sementaraFebruary,
        'sementaraMarch' => $sementaraMarch,
        'sementaraApril' => $sementaraApril,
        'sementaraMay' => $sementaraMay,
        'sementaraJune' => $sementaraJune,
        'sementaraJuly' => $sementaraJuly,
        'sementaraAugust' => $sementaraAugust,
        'sementaraSeptember' => $sementaraSeptember,
        'sementaraOctober' => $sementaraOctober,
        'sementaraNovember' => $sementaraNovember,
        'sementaraDecember' => $sementaraDecember,
        'prosesDaruratJanuary' => $prosesDaruratJanuary,
        'prosesDaruratFebruary' => $prosesDaruratFebruary,
        'prosesDaruratMarch' => $prosesDaruratMarch,
        'prosesDaruratApril' => $prosesDaruratApril,
        'prosesDaruratMay' => $prosesDaruratMay,
        'prosesDaruratJune' => $prosesDaruratJune,
        'prosesDaruratJuly' => $prosesDaruratJuly,
        'prosesDaruratAugust' => $prosesDaruratAugust,
        'prosesDaruratSeptember' => $prosesDaruratSeptember,
        'prosesDaruratOctober' => $prosesDaruratOctober,
        'prosesDaruratNovember' => $prosesDaruratNovember,
        'prosesDaruratDecember' => $prosesDaruratDecember,
        'batalJanuary' => $batalJanuary,
        'batalFebruary' => $batalFebruary,
        'batalMarch' => $batalMarch,
        'batalApril' => $batalApril,
        'batalMay' => $batalMay,
        'batalJune' => $batalJune,
        'batalJuly' => $batalJuly,
        'batalAugust' => $batalAugust,
        'batalSeptember' => $batalSeptember,
        'batalOctober' => $batalOctober,
        'batalNovember' => $batalNovember,
        'batalDecember' => $batalDecember,
        'prosesJanuary' => $prosesJanuary,
        'prosesFebruary' => $prosesFebruary,
        'prosesMarch' => $prosesMarch,
        'prosesApril' => $prosesApril,
        'prosesMay' => $prosesMay,
        'prosesJune' => $prosesJune,
        'prosesJuly' => $prosesJuly,
        'prosesAugust' => $prosesAugust,
        'prosesSeptember' => $prosesSeptember,
        'prosesOctober' => $prosesOctober,
        'prosesNovember' => $prosesNovember,
        'prosesDecember' => $prosesDecember]);
         
    }
	
    public function profile()
    {
        return view('profile');
    }
	
}
