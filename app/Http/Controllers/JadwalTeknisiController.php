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
use App\Models\VScheduleUser;
use App\Models\Customer;

class JadwalTeknisiController extends Controller
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
        DB::enableQueryLog();
        $datas = [];
        $like  =  "%technical%";
		$users = User::whereHas('divisi', function ($queryPosisi) use ($like) {
            $queryPosisi->where('name', 'like', $like);
        })->orderBy('id','DESC')->get();

        if(isset($request->cari)){
            $valid = $this->validate($request, [
                'tanggal_mulai'      => 'required|date_format:Y-m-d H:i:s',
                'tanggal_selesai'    => 'required|date_format:Y-m-d H:i:s|after_or_equal:tanggal_mulai',
                'teknisi'            => 'required|max:255',
            ]);

            $teknisi        = $request->teknisi;
            $tanggal_mulai  = $request->tanggal_mulai;
            $tanggal_selesai= $request->tanggal_selesai;
            // $datas = DB::table('v_schedule_user')
            // ->whereIn('id_user', $teknisi)
            // ->whereNotIn('status',['batal','selesai'])
            // ->where(function($q) use ($tanggal_mulai,$tanggal_selesai) {
            //     $q->where([['date_start','<=',$tanggal_mulai],['date_finish','>=',$tanggal_mulai]])
            //     ->orWhere([['date_start','<=',$tanggal_selesai],['date_finish','>=',$tanggal_selesai]])
            //     ->orWhere([['date_start','>=',$tanggal_mulai],['date_finish','<=',$tanggal_selesai]]);
            // })->get();
            
            $datas =  Schedule::whereHas('users', function ($queryUser) use ($teknisi) {
                $queryUser->whereIn('id_user', $teknisi);
               })
               ->whereNotIn('status',['batal','selesai'])
               ->where(function($q) use ($tanggal_mulai,$tanggal_selesai) {
                $q->where([['date_start','<=',$tanggal_mulai],['date_finish','>=',$tanggal_mulai]])
                ->orWhere([['date_start','<=',$tanggal_selesai],['date_finish','>=',$tanggal_selesai]])
                ->orWhere([['date_start','>=',$tanggal_mulai],['date_finish','<=',$tanggal_selesai]]);
            })->get();
        }
        // dd(DB::getQueryLog());
        return view('schedule.index_teknisi', ['users' => $users , 'datas' => $datas]);
    }
}