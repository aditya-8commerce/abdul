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
use App\Models\VScheduleUser;
use App\Models\Schedule;
use App\Models\ScheduleUser;
use App\Models\Customer;

class JadwalSementaraController extends Controller
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
		
		
		$query = Schedule::with('customer','users')->where('status','sementara')->orderBy('id','DESC');
		
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

        if(isset($request->download)){
            $datas 	= $query->get();
            $fileName   = "data_Jadwal_Sementara_download_at_".date('Y-m-d').".xls";
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'NO JADWAL')
            ->setCellValue('B1', 'KODE PELANGGAN')
            ->setCellValue('C1', 'TANGGAL JADWAL DIBUAT')
            ->setCellValue('D1', 'TANGGAL MULAI')
            ->setCellValue('E1', 'TANGGAL SELESAI')
            ->setCellValue('F1', 'TOTAL JAM')
            ->setCellValue('G1', 'STATUS')
            ->setCellValue('H1', 'CATATAN')
            ->setCellValue('I1', 'TIPE PELAYANAN')
            ->setCellValue('J1', 'NAMA TEKNISI');

            $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);  
            $no=1;
            $row=2;
            $lfcr = chr(10) . chr(13);
            if(count($datas) > 0){
                foreach ($datas as $d){
                    $date1 = strtotime($d->date_start);
                    $date2 = strtotime($d->date_finish);
                    $diff = abs($date2 - $date1); 
                    $years = floor($diff / (365*60*60*24)); 
                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
                    $str = '';
                    foreach($d->users as $u) {
                        $str .=  '1. '.$u->user->name .' - '. $u->user->indentity_number.' '.$lfcr;    
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'BA-'.sprintf("%010d", $d->id));
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $d->customer->code);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $d->created_at);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $d->date_start);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $d->date_finish);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $hours);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $d->status);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $d->remarks);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $d->service_type);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $str);
                    $no++; 
                    $row++;
                }
            }
            
            $objPHPExcel->getActiveSheet()->setTitle('Sheet1'); 
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output'); 

        }else{
            $datas 	= $query->paginate(10);
            $total 		= $query->count();
            return view('schedule.index_sementara', ['datas' => $datas , 'total' => $total]);
        }

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
            'tipe_pelayanan'     => 'required|max:255',
        ]);
 
        $checkTeknisi = $this->checkJadwalTeknisi($request->tanggal_mulai , $request->tanggal_selesai , $request->teknisi);
        if($checkTeknisi){
            $ba = 'BA-'.sprintf("%010d", $checkTeknisi->id);
            return redirect()->back()->with('info', 'Salah satu teknisi memiliki jadwal yg sama '.$ba);
        }else{
            $model->id_customer     = $request->kode_pelanggan;
            $model->date_start      = $request->tanggal_mulai;
            $model->date_finish     = $request->tanggal_selesai;
            $model->service_type    = $request->tipe_pelayanan;
            $model->report_type     = "";
            $model->id_ozon         = 0;
            $model->id_uv           = 0;
            $model->id_emergency    = 0;
            $model->id_log          = 0;
            $model->reminder_service= 0;
            $model->status          = "sementara";
            $model->remarks         = "";
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
			return view('schedule.index_sementara_detail', ['data' => $data]);
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
        $like =  "%technical%";
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
		$users = User::whereHas('divisi', function ($queryPosisi) use ($like) {
            $queryPosisi->where('name', 'like', $like);
        })->orderBy('id','DESC')->get();
        $customers = Customer::orderBy('id','DESC')->get();
		if($data){
			return view('schedule.index_sementara_edit', ['data' => $data , 'users' => $users, 'customers' => $customers]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request,$id)
    {
        $code = Crypt::decrypt($id);
        $data = Schedule::find($code);
        $valid = $this->validate($request, [
            'kode_pelanggan'     => 'required|max:255',
            'tanggal_mulai'      => 'required|date_format:Y-m-d H:i:s',
            'tanggal_selesai'    => 'required|date_format:Y-m-d H:i:s|after_or_equal:tanggal_mulai',
            'teknisi'            => 'required|max:255',
            'tipe_pelayanan'     => 'required|max:255',
        ]);
 
        $checkTeknisi = $this->checkJadwalTeknisi($request->tanggal_mulai , $request->tanggal_selesai , $request->teknisi , $code);
        if($checkTeknisi){
            // echo json_encode($checkTeknisi);
            $ba = 'BA-'.sprintf("%010d", $checkTeknisi->id);
            return redirect()->back()->with('info', 'Salah satu teknisi memiliki jadwal yg sama '.$ba);
        }else{
            //  echo 'ok';
            $data->id_customer     = $request->kode_pelanggan;
            $data->date_start      = $request->tanggal_mulai;
            $data->date_finish     = $request->tanggal_selesai;
            $data->service_type    = $request->tipe_pelayanan;
            $data->report_type     = "";
            $data->id_ozon         = 0;
            $data->id_uv           = 0;
            $data->id_emergency    = 0;
            $data->id_log          = 0;
            $data->reminder_service= 0;
            $data->status          = "sementara";
            $data->remarks         = "";
            $data->save();

            ScheduleUser::where('id_schedule',$code)->delete();

            for($x=0; $x < count($request->teknisi); $x++){
                $modelUser  = new ScheduleUser;
                $modelUser->id_schedule = $code;
                $modelUser->id_user     = $request->teknisi[$x];
                $modelUser->save();
                // echo $request->teknisi[$x].' ---- ';
            }
            return redirect()->back()->with('success', 'data berhasil di rubah');
            
        }
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
 
 
    private function checkJadwalTeknisi($tanggal_mulai,$tanggal_selesai,$teknisi,$id=''){
        if(empty($id)){
            $model =  Schedule::whereHas('users', function ($queryUser) use ($teknisi) {
                $queryUser->whereIn('id_user', $teknisi);
               })->where(function($q) use ($tanggal_mulai,$tanggal_selesai) {
                $q->where([['date_start','<=',$tanggal_mulai],['date_finish','>=',$tanggal_mulai]])
                ->orWhere([['date_start','<=',$tanggal_selesai],['date_finish','>=',$tanggal_selesai]])
                ->orWhere([['date_start','>=',$tanggal_mulai],['date_finish','<=',$tanggal_selesai]]);
                })->whereNotIn('status',['batal','selesai'])
               ->first();
        }else{
            $model =  Schedule::whereHas('users', function ($queryUser) use ($teknisi) {
                $queryUser->whereIn('id_user', $teknisi);
               })->where(function($q) use ($tanggal_mulai,$tanggal_selesai) {
                $q->where([['date_start','<=',$tanggal_mulai],['date_finish','>=',$tanggal_mulai]])
                ->orWhere([['date_start','<=',$tanggal_selesai],['date_finish','>=',$tanggal_selesai]])
                ->orWhere([['date_start','>=',$tanggal_mulai],['date_finish','<=',$tanggal_selesai]]);
                })->whereNotIn('status',['batal','selesai'])->whereNotIn('id',[$id])
               ->first();
     
        }
        return $model;
    }


    public function updateStatus(Request $request,$id){
        $code = Crypt::decrypt($id);
        $data = Schedule::find($code);
        $valid = $this->validate($request, [
            'type'             => 'required|max:255'
        ]);
        $data->status = 'proses';
        $data->type   = $request->type;
        $data->save();

        return redirect('/jadwal-sementara')->with('success', 'data berhasil di rubah');
    }

    public function updateStatusBatal(Request $request,$id){
        $code = Crypt::decrypt($id);
        $data = Schedule::find($code);
        $valid = $this->validate($request, [
            'catatan'             => 'required|max:255'
        ]);
        $data->status = "batal";
        $data->remarks = $request->catatan;
        $data->save();

        return redirect('/jadwal-sementara')->with('success', 'data berhasil di rubah');
    }
}
