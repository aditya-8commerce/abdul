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
use App\Models\Customer;

class CustomerController extends Controller
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
		
		$query = Customer::orderBy('id','DESC');
		
		if ($search) {
            $like = "%{$search}%";
            $query = $query->where('name', 'like', $like)->orWhere('code', 'like', $like);
        }
		
        
        if(isset($request->download)){
            $absent 	= $query->get();
            $fileName   = "data_Customer_download_at_".date('Y-m-d').".xls";
            $objPHPExcel = new PHPExcel(); 
            $objPHPExcel->setActiveSheetIndex(0); $objPHPExcel->getActiveSheet()
            ->setCellValue('A1', 'KODE PELANGGAN')
            ->setCellValue('B1', 'NAMA')
            ->setCellValue('C1', 'ALAMAT')
            ->setCellValue('D1', 'EMAIL')
            ->setCellValue('E1', 'TELEPON');
            
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);  
            $no=1;
            $row=2;
            if(count($absent) > 0){
                foreach ($absent as $d){
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $d->code);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $d->name);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $d->address);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $d->email);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $d->phone);
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
            return view('customer.index', ['datas' => $datas , 'total' => $total]);

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
		return view('customer.add');
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = new Customer;

        if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
            $valid = $this->validate($request, [
                'kode_pelanggan'               => 'required|max:255|unique:customers,code',
                'nama_pelanggan'               => 'required|max:255',
                'alamat_pelanggan'             => 'required',
                'email_pelanggan'              => 'required|max:255|email|unique:customers,email',
                'telepon_pelanggan'            => 'required|max:20|unique:customers,phone',
            ]);
 
		
           
            $data->code     = $request->kode_pelanggan;
            $data->name     = $request->nama_pelanggan;
            $data->address  = $request->alamat_pelanggan;
            $data->email    = $request->email_pelanggan;
            $data->phone    = $request->telepon_pelanggan;
            // echo json_encode($data);
            $data->save();
            return redirect()->back()->with('success', 'data berhasil ditambahkan');
        }else{
            return redirect()->back()->with('info', ' ');
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
		return redirect()->back()->with('info', ' ');
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
		$data = Customer::find($code);
		if($data){
			return view('customer.edit', ['data' => $data]);
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
		$data = Customer::find($code);
        if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
            $valid = $this->validate($request, [
                'kode_pelanggan'               => 'required|max:255|unique:customers,code,'.$code,
                'nama_pelanggan'               => 'required|max:255',
                'alamat_pelanggan'             => 'required',
                'email_pelanggan'              => 'required|max:255|email|unique:customers,email,'.$code,
                'telepon_pelanggan'            => 'required|max:20|unique:customers,phone,'.$code,
            ]);
           
           
            $data->code     = $request->kode_pelanggan;
            $data->name     = $request->nama_pelanggan;
            $data->address  = $request->alamat_pelanggan;
            $data->email    = $request->email_pelanggan;
            $data->phone    = $request->telepon_pelanggan;
            $data->save();
            
    
            return redirect()->back()->with('success', 'data berhasil di rubah');
        }else{
            return redirect()->back()->with('info', ' '); 
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
        $data = Customer::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');

    }

 
}
