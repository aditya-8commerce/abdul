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
use App\Models\VSchedule;
use App\Models\Schedule;
use App\Models\ScheduleUser;
use App\Models\Customer;

class JadwalReminderController extends Controller
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
		$query = VSchedule::with('customer','users')->whereMonth('date_reminder', Carbon::now()->month)->orderBy('id','DESC');
		
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

        $datas 	= $query->paginate(10);
        $total 		= $query->count();
        return view('schedule.index_reminder', ['datas' => $datas , 'total' => $total]);
        

    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $like =  "%technical%";
		$users = User::whereHas('divisi', function ($queryPosisi) use ($like) {
            $queryPosisi->where('name', 'like', $like);
        })->orderBy('id','DESC')->get();
		$customers = Customer::orderBy('id','DESC')->get();
		return view('schedule.index_sementara_create', ['users' => $users, 'customers' => $customers]);
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    { 
        $model      = new Schedule;
        $valid = $this->validate($request, [
            'kode_pelanggan'     => 'required|max:255',
            'tanggal_mulai'      => 'required|date_format:Y-m-d H:i:s',
            'tanggal_selesai'    => 'required|date_format:Y-m-d H:i:s|after_or_equal:tanggal_mulai',
            'teknisi'            => 'required|max:255',
        ]);
 
        $checkTeknisi = $this->checkJadwalTeknisi($request->tanggal_mulai , $request->tanggal_selesai , $request->teknisi);
        if($checkTeknisi){
            echo json_encode($checkTeknisi);
            $ba = 'BA-'.sprintf("%010d", $checkTeknisi->id);
            return redirect()->back()->with('info', 'Salah satu teknisi memiliki jadwal yg sama '.$ba);
        }else{
            $model->id_customer     = $request->kode_pelanggan;
            $model->date_start      = $request->tanggal_mulai;
            $model->date_finish     = $request->tanggal_selesai;
            $model->report_type     = "";
            $model->id_ozon         = 0;
            $model->id_uv           = 0;
            $model->id_emergency    = 0;
            $model->id_log          = 0;
            $model->reminder_service= 0;
            $model->status          = "sementara";
            $model->remaks          = "";
            $model->save();

            $modelId = $model->id;

            for($x=0; $x < count($request->teknisi); $x++){
                $modelUser  = new ScheduleUser;
                $modelUser->id_schedule = $modelId;
                $modelUser->id_user     = $request->teknisi[$x];
                $modelUser->save();
                // echo $request->teknisi[$x].' ---- ';
            }
            return redirect()->back()->with('success', 'data berhasil di masukan');
        }
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
			return view('schedule.index_reminder_detail', ['data' => $data]);
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
		return redirect()->back()->with('info', 'data tidak ditemukan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
		return redirect()->back()->with('info', 'data tidak ditemukan');
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
  
}
