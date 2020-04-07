<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Response,View,Input,Auth,Session,Validator,File,Hash,DB,Mail;
use Illuminate\Support\Facades\Crypt;
Use Alert;
use PDF;

use PHPExcel; 
use PHPExcel_IOFactory;

use App\Models\User;
use App\Models\Posisi;
use App\Models\Divisi;
use App\Models\Lembur;
use App\Models\Customer;

class LemburController extends Controller
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
        $search         = $request->filter;
        $no_form         = $request->no_form;
        $reportrange    = $request->reportrange;
        $divisi         = $request->divisi;
        $posisi         = $request->posisi;
		
		if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director'){
			$query = Lembur::with('user')->orderBy('id','DESC');
		}else{
			$query = Lembur::with('user')->where('id_user',Auth::user()->id)->orderBy('id','DESC');
		}
		
		if ($search) {
            $like = "%{$search}%";
            $query = $query->whereHas('user', function ($queryUser) use ($like) {
				$queryUser->where('name', 'like', $like)->orWhere('indentity_number', 'like', $like);
			});
        }
		
		if ($divisi) {
            $query = $query->whereHas('user', function ($queryUser) use ($divisi) {
				$queryUser->where('id_division', $divisi);
			});
        }
		
		if ($posisi) {
            $query = $query->whereHas('user', function ($queryUser) use ($posisi) {
				$queryUser->where('id_position', $posisi);
			});
        }
		
        if($reportrange)
        {
			$explode = explode("~", $reportrange);
			$date_start = date('Y-m-d', strtotime($explode[0]));
			$date_end = date('Y-m-d', strtotime($explode[1]));
            $query = $query->whereDate('created_at','>=',$date_start)->whereDate('created_at','<=',$date_end);
        }
		
        if($no_form)
        {
            $like = "%{$no_form}%";
            $query = $query->where('id','like',$like);
        }
        
        if(isset($request->download)){
            $absent 	= $query->get();
            $fileName   = "data_lembur_download_at_".date('Y-m-d').".xls";
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'NO FORM')
            ->setCellValue('B1', 'NIK')
            ->setCellValue('C1', 'NAMA')
            ->setCellValue('D1', 'DIVISI')
            ->setCellValue('E1', 'JABATAN')
            ->setCellValue('F1', 'NAMA CUSTOMER')
            ->setCellValue('G1', 'TANGGAL FORM')
            ->setCellValue('H1', 'TANGGAL MULAI')
            ->setCellValue('I1', 'TANGGAL SELESAI')
            ->setCellValue('J1', 'TOTAL WAKTU')
            ->setCellValue('K1', 'KETERANGAN')
            ->setCellValue('L1', 'APPROVED ATASAN')
            ->setCellValue('M1', 'APPROVED DIREKSI');
            
            $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);  
            $no=1;
            $row=2;
            if(count($absent) > 0){
                foreach ($absent as $d){
                    $no     = 'LB-'.sprintf("%010d", $d->id);

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $no);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $d->user->indentity_number);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $d->user->name);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $d->divisi->name);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $d->posisi->name);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $d->customer_name);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row, date('Y-m-d', strtotime($d->created_at)));
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $d->date_start);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row, $d->date_finish);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row, $d->total_hours);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row, $d->description);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row, $d->approve_by_leader." - ".$d->approve_status_by_leader);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row, $d->approve_by_director." - ".$d->approve_status_by_director);
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
            $divions 	= Divisi::select('id','name')->get();
            $positions 	= Posisi::select('id','name')->get();
            $absent 	= $query->paginate(10);
            $total 		= $query->count();
            return view('lembur.index', ['absents' => $absent , 'total' => $total , 'divions' => $divions , 'positions' => $positions]);

        }
		
		// echo $reportrange;
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		$users = User::orderBy('id','DESC')->get();
		$customers = Customer::orderBy('id','DESC')->get();
		return view('lembur.add',['users' => $users , 'customers' => $customers]);
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $absent = new Lembur;

        if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
            $valid = $this->validate($request, [
                'nama_karyawan'      => 'required|max:255',
                'nama_customer'      => 'required|max:255',
                'tanggal_mulai'      => 'required|date_format:Y-m-d H:i:s',
                'tanggal_selesai'    => 'required|date_format:Y-m-d H:i:s|after_or_equal:tanggal_mulai',
                'keterangan'         => 'required|max:255',
            ]);

            
            $user = User::with('divisi','posisi')->find($request->nama_karyawan);
            $absent->id_user                    = $user->id;

            if(strtolower($user->posisi->name) == 'head'){
                $absent->approve_by_leader          = $user->name.' ('.$user->indentity_number.')';
                $absent->approve_status_by_leader   = "setuju";
                
            }else{
                $absent->approve_by_leader          = "";
                $absent->approve_status_by_leader   = "";
            }

        }else{
            $valid = $this->validate($request, [
                'nama_customer'      => 'required|max:255',
                'tanggal_mulai'      => 'required|date_format:Y-m-d H:i:s',
                'tanggal_selesai'    => 'required|date_format:Y-m-d H:i:s|after_or_equal:tanggal_mulai',
                'keterangan'         => 'required|max:255'
            ]);

            $absent->id_user                    = Auth::user()->id;

            if(strtolower(Auth::user()->posisi->name) == 'head'){
                $absent->approve_by_leader          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $absent->approve_status_by_leader   = "setuju";
                
            }else{
                $absent->approve_by_leader          = "";
                $absent->approve_status_by_leader   = "";
            }
        }
		
		
        $date1 = date_create($request->tanggal_mulai);
        $date2 = date_create($request->tanggal_selesai);
        $diff = date_diff($date1,$date2);
		
	   
		$absent->customer_name     = $request->nama_customer;
		$absent->date_start        = $request->tanggal_mulai;
		$absent->date_finish       = $request->tanggal_selesai;
		$absent->total_hours       = $diff->format('%h');
		$absent->description       = $request->keterangan;
        
        
		$absent->approve_by_director        = "";
		$absent->approve_status_by_director = "";
        // echo json_encode($absent);
        $absent->save();
        return redirect()->back()->with('success', 'data berhasil ditambahkan');
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
        
		$customers = Customer::orderBy('id','DESC')->get();
		$data = Lembur::with('user')->find($code);
		if($data){
			return view('lembur.detail', ['data' => $data]);
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
        $code = Crypt::decrypt($id);
		$data = Lembur::with('user')->find($code);
		$users = User::orderBy('id','DESC')->get();
		$customers = Customer::orderBy('id','DESC')->get();
		if($data){
			return view('lembur.edit', ['data' => $data,'users' => $users , 'customers' => $customers]);
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
		$absent = Lembur::find($code);
        if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
            $valid = $this->validate($request, [
                'nama_karyawan'      => 'required|max:255',
                'nama_customer'      => 'required|max:255',
                'tanggal_mulai'      => 'required|date_format:Y-m-d H:i:s',
                'tanggal_selesai'    => 'required|date_format:Y-m-d H:i:s|after_or_equal:tanggal_mulai',
                'keterangan'         => 'required|max:255',
            ]);

            
            $user = User::with('divisi','posisi')->find($request->nama_karyawan);
            $absent->id_user                    = $user->id;

            if(strtolower($user->posisi->name) == 'head'){
                $absent->approve_by_leader          = $user->name.' ('.$user->indentity_number.')';
                $absent->approve_status_by_leader   = "setuju";
                
            }else{
                $absent->approve_by_leader          = "";
                $absent->approve_status_by_leader   = "";
            }


        }else{
            $valid = $this->validate($request, [
                'nama_customer'      => 'required|max:255',
                'tanggal_mulai'      => 'required|date_format:Y-m-d H:i:s',
                'tanggal_selesai'    => 'required|date_format:Y-m-d H:i:s|after_or_equal:tanggal_mulai',
                'keterangan'         => 'required|max:255'
            ]);

            $absent->id_user                    = Auth::user()->id;

            if(strtolower(Auth::user()->posisi->name) == 'head'){
                $absent->approve_by_leader          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $absent->approve_status_by_leader   = "setuju";
                
            }else{
                $absent->approve_by_leader          = "";
                $absent->approve_status_by_leader   = "";
            }
        }
		
		
        $date1 = date_create($request->tanggal_mulai);
        $date2 = date_create($request->tanggal_selesai);
        $diff = date_diff($date1,$date2);
		
	   
	   
		$absent->customer_name     = $request->nama_customer;
		$absent->date_start        = $request->tanggal_mulai;
		$absent->date_finish       = $request->tanggal_selesai;
		$absent->total_hours       = $diff->format('%h');
		$absent->description       = $request->keterangan;
		$absent->approve_by_director        = "";
		$absent->approve_status_by_director = "";
        $absent->save();
        

        return redirect()->back()->with('success', 'data berhasil di rubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = Lembur::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');

    }


    /**
     * print the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function print($id)
    {
        
        $code = Crypt::decrypt($id);
		$data = Lembur::with('user')->find($code);
		if($data){
            $no     = 'LB-'.sprintf("%010d", $data->id);
            $res    = ["no_form" => $no , "data" =>$data];
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);		
            $pdf = PDF::loadView('pdf.form_lembur', $res)->setPaper('a4', 'portrait');
            return $pdf->download($no.'.pdf');
            // return $pdf->stream();
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }
}
