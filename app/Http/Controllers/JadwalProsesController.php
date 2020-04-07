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

class JadwalProsesController extends Controller
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
		
		
		$query = Schedule::with('customer','users')->where('status','proses')->orderBy('id','DESC');
		
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
            return view('schedule.index_proses', ['datas' => $datas , 'total' => $total]);
        }
       
    }

    public function show($id)
    {	
        $code = Crypt::decrypt($id);
		$data = Schedule::with('customer','users','log','emergency','ozon','uv')->find($code);
        
		if($data){
			return view('schedule.index_proses_detail', ['data' => $data]);
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}

    }

}