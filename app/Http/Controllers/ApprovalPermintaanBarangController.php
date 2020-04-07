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
use App\Models\PermintaanBarang;

class ApprovalPermintaanBarangController extends Controller
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
        $search = $request->filter;
		
		if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
            $query = PermintaanBarang::with('user','details')->orderBy('id','DESC');
            if ($search) {
                $like = "%{$search}%";
                $query = $query->where('name_project', 'like', $like)->orWhere('id', 'like', $like);
            }
		}elseif(strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director'){
            $query = PermintaanBarang::with('user','details')->where('approve_status_by_leader', 'setuju')->orderBy('id','DESC');
            if ($search) {
                $like = "%{$search}%";
                $query = $query->orWhere('name_project', 'like', $like)->orWhere('id', 'like', $like);
            }

        }else{
			$query = PermintaanBarang::with('user','details')->whereHas('user', function ($query) {
                $query->where([['id_division', '=', Auth::user()->id_division],['id_position', '=', '4']]);
            })->orderBy('id','DESC');
            if ($search) {
                $like = "%{$search}%";
                $query = $query->where('name_project', 'like', $like)->orWhere('id', 'like', $like);
            }
		}        
        

        $datas 	= $query->paginate(10);
        $total  = $query->count();
        
        // echo json_encode($absent);
        return view('approval_form_permintaan_barang.index', ['datas' => $datas , 'total' => $total]);

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
		$data = PermintaanBarang::with('user')->find($code);
		if($data){
			return view('approval_form_permintaan_barang.detail', ['data' => $data]);
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
        $code = Crypt::decrypt($id);
        $data = PermintaanBarang::find($code);
        if(isset($request->status)){
            
            if($request->status == 'Setuju'){
                $data->approve_by_leader          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $data->approve_status_by_leader   = "setuju";

            }else{
                $data->approve_by_leader          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $data->approve_status_by_leader   = "ditolak";
            }

            
		    $data->save();
            return redirect()->back()->with('success', 'persetujuan berhasil di berikan');
        }elseif(isset($request->status_director)){
            
            if($request->status_director == 'Setuju'){
                $user = User::find($data->id_user);
                if($data->piece == "cuti"){
                    $cuti = $user->paid_leave - $data->total_days;
                    if($cuti < 0){
                        $cuti = 0;
                    }

                    $user->paid_leave = $cuti;
                    $user->save();
                }

                $data->approve_by_director          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $data->approve_status_by_director   = "setuju";

            }else{
                $data->approve_by_director          = Auth::user()->name.' ('.Auth::user()->indentity_number.')';
                $data->approve_status_by_director   = "ditolak";
            }
		    $data->save();
            return redirect()->back()->with('success', 'persetujuan berhasil di berikan');
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
		return redirect()->back()->with('info', ' ');
    }

}
