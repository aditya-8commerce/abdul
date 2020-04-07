<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Response,View,Input,Auth,Session,Validator,File,Hash,DB,Mail;
use Illuminate\Support\Facades\Crypt;
Use Alert;

use PHPExcel; 
use PHPExcel_IOFactory;

use App\Models\User;
use App\Models\Posisi;
use App\Models\Divisi;
use App\Models\Schedule;
use App\Models\ScheduleUser;
use App\Models\Customer;
use App\Models\Produk;

class JadwalController extends Controller
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
     * Display a listing of the resource.
     *
     * @return Response
     */
	public function index(Request $request)
    {			  
        $kode_pelanggan = $request->kode_pelanggan;
        $no_jadwal      = $request->no_jadwal;
        $reportrange    = $request->reportrange; 
		
		$query = Schedule::with('customer','users','log','emergency','ozon','uv')->orderBy('id','DESC');
		
		if ($kode_pelanggan) { 
            $like = "%{$kode_pelanggan}%";
            $query = $query->whereHas('customer', function ($queryCustomer) use ($like) {
                $queryCustomer->where('code', 'like', $like);
            });
        }
 
        if($no_jadwal)
        {
            $query = $query->where('id',$no_jadwal);
        }

        if($reportrange)
        {
			$explode = explode("~", $reportrange);
			$date_start = date('Y-m-d', strtotime($explode[0]));
			$date_end = date('Y-m-d', strtotime($explode[1]));
            $query = $query->whereBetween('date_start',[$date_start, $date_end])->orWhereBetween('date_finish',[$date_start, $date_end]);
        }



        $datas   	= $query->paginate(10);
        $total 		= $query->count();
		$produk = Produk::orderBy('id','DESC')->get();
        return view('schedule.index', ['datas' => $datas , 'total' => $total,'produk'=>$produk]);

    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		return redirect()->back()->with('info', ' ');
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
		return redirect()->back()->with('info', ' ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		if($data){
			return view('schedule.detail', ['data' => $data]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        return redirect()->back()->with('info', ' ');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
		return redirect()->back()->with('info', ' ');
    }

    private function checkJadwalTeknisi($tanggal_mulai,$tanggal_selesai,$teknisi){
        $model =  Schedule::whereHas('users', function ($queryUser) use ($teknisi) {
            $queryUser->where('id_user', $teknisi);
        })->whereBetween('date_start',[$tanggal_mulai, $tanggal_selesai])->orWhereBetween('date_finish',[$tanggal_mulai, $tanggal_selesai])->first();
         
        return $model;
    }


    public function updateStatus(Request $request,$id){
 

    }

}
