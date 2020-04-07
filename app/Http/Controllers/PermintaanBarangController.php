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
use App\Models\PermintaanBarang;
use App\Models\PermintaanBarangDetails;

class PermintaanBarangController extends Controller
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
        $reportrange    = $request->reportrange;
		if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator' || strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director'){
            $query = PermintaanBarang::with('user','details')->orderBy('id','DESC');
                
            if ($search) {
                $like = "%{$search}%";
                $query = $query->where('name_project', 'like', $like)->orWhere('id', 'like', $like);
            }
		}else{
			$query = PermintaanBarang::with('user','details')->where('id_user',Auth::user()->id)->orderBy('id','DESC');
        
            if ($search) {
                $like = "%{$search}%";
                $query = $query->orWhere('name_project', 'like', $like)->orWhere('id', 'like', $like);
            }
        }
		
        if($reportrange)
        {
			$explode = explode(" - ", $reportrange);
			$date_start = date('Y-m-d', strtotime($explode[0]));
			$date_end = date('Y-m-d', strtotime($explode[1]));
            $query = $query->whereDate('created_at','>=',$date_start)->whereDate('created_at','<=',$date_end);
        }
        $datas   	= $query->paginate(10);
        $total 		= $query->count();
        return view('permintaanBarang.index', ['datas' => $datas , 'total' => $total]);
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		$users = User::orderBy('id','DESC')->get();
		return view('permintaanBarang.add',['users' => $users]);
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $data = new PermintaanBarang;

        if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
            $valid = $this->validate($request, [
                'nama_karyawan'      => 'required|max:255',
                'nama_proyek'        => 'required|max:255',
                'bukti'              => 'required|image|mimes:jpg,jpeg,png'
            ]);

            
            $user = User::with('divisi','posisi')->find($request->nama_karyawan);
            $data->id_user                    = $user->id;

            if(strtolower($user->posisi->name) == 'head'){
                $data->approve_by_leader          = $user->name.' ('.$user->indentity_number.')';
                $data->approve_status_by_leader   = "setuju";
                
            }else{
                $data->approve_by_leader          = "";
                $data->approve_status_by_leader   = "";
            }

        }else{
            $valid = $this->validate($request, [
                'nama_proyek'        => 'required|max:255',
                'bukti'              => 'required|image|mimes:jpg,jpeg,png'
            ]);

            $data->id_user                    = Auth::user()->id;

            if(strtolower(Auth::user()->posisi->name) == 'head'){
                $data->approve_by_leader          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $data->approve_status_by_leader   = "setuju";
                
            }else{
                $data->approve_by_leader          = "";
                $data->approve_status_by_leader   = "";
            }
        }
		
        $file = $request->file('bukti');
        $extension  = $request->file('bukti')->getClientOriginalExtension();
		
		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/permintaan-barang/'; // upload path
			$fileName   = str_replace(' ', '-', $request->nama_proyek).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
                $data->name_project       = $request->nama_proyek;
                $data->file	              = $fileName;
                $data->save();
                $id = $data->id;

                for($x=0;$x < count($request->nama_barang);$x++){
                    if($request->nama_barang[$x]){
                        PermintaanBarangDetails::create(['demand_for_good_id' =>  $id, 'name' => $request->nama_barang[$x] ,'qty' => $request->qty[$x], 'price' => $request->harga[$x] , 'description' => $request->keterangan[$x]]);
                    }else{
                        continue;
                    }
                }

                return redirect()->back()->with('success', 'data berhasil ditambahkan');
			}
		}else{
			return redirect()->back()->with('info', 'gambar foto lebih dari 2 MB');
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
		$data = PermintaanBarang::with('user','details')->find($code);
		if($data){
			return view('permintaanBarang.detail', ['data' => $data]);
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
		$data = PermintaanBarang::with('user')->find($code);
		$users = User::orderBy('id','DESC')->get();
		if($data){
			return view('permintaanBarang.edit', ['data' => $data,'users' => $users]);
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
		$data = PermintaanBarang::find($code);
        if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
            $valid = $this->validate($request, [
                'nama_karyawan'      => 'required|max:255',
                'nama_proyek'        => 'required|max:255'
            ]);

            
            $user = User::with('divisi','posisi')->find($request->nama_karyawan);
            $data->id_user                    = $user->id;

            if(strtolower($user->posisi->name) == 'head'){
                $data->approve_by_leader          = $user->name.' ('.$user->indentity_number.')';
                $data->approve_status_by_leader   = "setuju";
                
            }else{
                $data->approve_by_leader          = "";
                $data->approve_status_by_leader   = "";
            }

        }else{
            $valid = $this->validate($request, [
                'nama_proyek'        => 'required|max:255'
            ]);

            $data->id_user                    = Auth::user()->id;

            if(strtolower(Auth::user()->posisi->name) == 'head'){
                $data->approve_by_leader          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $data->approve_status_by_leader   = "setuju";
                
            }else{
                $data->approve_by_leader          = "";
                $data->approve_status_by_leader   = "";
            }
        }

        if($request->bukti){
            $valid = $this->validate($request, [
                'bukti'           => 'image|mimes:jpg,jpeg,png'
            ]);
               
            $file = $request->file('bukti');
            $extension  = $request->file('bukti')->getClientOriginalExtension();
            
            if ($file->getSize() <= 2000000){
                $destinationPath = public_path().'/public/permintaan-barang/'; // upload path
                $fileName   = str_replace(' ', '-', $request->nik).'-'.time().'.'.$extension; // renameing image
                if(file_exists($destinationPath.$fileName)){
                    File::delete($destinationPath .$fileName);
                }
                 $upload_success     = $file->move($destinationPath, $fileName);
                if(!$upload_success){
                    return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
                }else{
                    $data->file	  = $fileName;
                }
            }else{
                return redirect()->back()->with('info', 'gambar bukti lebih dari 2 MB');
            }
           }

           $data->name_project       = $request->nama_proyek;
           $data->save();
		
           PermintaanBarangDetails::where('demand_for_good_id',$code)->delete();

           
           for($x=0;$x < count($request->nama_barang);$x++){
            if($request->nama_barang[$x]){
                PermintaanBarangDetails::create(['demand_for_good_id' =>  $code, 'name' => $request->nama_barang[$x] ,'qty' => $request->qty[$x], 'price' => $request->harga[$x] , 'description' => $request->keterangan[$x]]);
            }else{
                continue;
            }
        }

        return redirect()->back()->with('success', 'data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = PermintaanBarang::find($id);
        $destinationPath = public_path().'/public/permintaan-barang/'; // upload path
        $fileName   = $data->file; // renameing image
        if(file_exists($destinationPath.$fileName)){
            File::delete($destinationPath .$fileName);
        }
        $data->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');

    }

    public function grafikPermintaanBarang(Request $request)
    {
        $year = now()->year;
        if($request->year){
            $year = $request->year;
        }
        $resultSetujuJanuary = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "01")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();
        
        $resultSetujuFebruary = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "02")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();
        
        $resultSetujuMarch = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "03")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();

        $resultSetujuApril = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "04")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();

        $resultSetujuMay = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "05")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first(); 

        $resultSetujuJune = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "06")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();

        $resultSetujuJuly = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "07")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();


        $resultSetujuAugust = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "08")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();


        $resultSetujuSeptember = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "09")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();


        $resultSetujuOctober = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "10")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();



        $resultSetujuNovember = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "11")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();



        $resultSetujuDecember = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','setuju')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "12")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();


        $resultTolakJanuary = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "01")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();
        
        $resultTolakFebruary = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "02")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();
        
        $resultTolakMarch = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "03")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();

        $resultTolakApril = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "04")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();

        $resultTolakMay = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "05")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first(); 

        $resultTolakJune = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "06")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();

        $resultTolakJuly = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "07")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();


        $resultTolakAugust = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "08")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();


        $resultTolakSeptember = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "09")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();


        $resultTolakOctober = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "10")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();



        $resultTolakNovember = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "11")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();



        $resultTolakDecember = PermintaanBarang::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
        ->where('approve_status_by_director','ditolak')
        ->whereYear('created_at', '=', $year)
        ->whereMonth('created_at', '=', "12")
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->first();
        
        
        return view('permintaanBarang.grafik',['resultSetujuJanuary' => $resultSetujuJanuary , 'resultSetujuFebruary' => $resultSetujuFebruary, 
        'resultSetujuMarch' => $resultSetujuMarch ,'resultSetujuApril' => $resultSetujuApril , 'resultSetujuMay' => $resultSetujuMay, 
        'resultSetujuJune' => $resultSetujuJune, 'resultSetujuJuly' => $resultSetujuJuly , 'resultSetujuAugust' => $resultSetujuAugust , 
         'resultSetujuSeptember' => $resultSetujuSeptember, 'resultSetujuOctober' => $resultSetujuOctober , 
         'resultSetujuNovember' => $resultSetujuNovember , 'resultSetujuDecember' => $resultSetujuDecember,'resultTolakJanuary' => $resultTolakJanuary , 'resultTolakFebruary' => $resultTolakFebruary, 
         'resultTolakMarch' => $resultTolakMarch ,'resultTolakApril' => $resultTolakApril , 'resultTolakMay' => $resultTolakMay, 
         'resultTolakJune' => $resultTolakJune, 'resultTolakJuly' => $resultTolakJuly , 'resultTolakAugust' => $resultTolakAugust , 
          'resultTolakSeptember' => $resultTolakSeptember, 'resultTolakOctober' => $resultTolakOctober , 
          'resultTolakNovember' => $resultTolakNovember , 'resultTolakDecember' => $resultTolakDecember ]);
    }

}
