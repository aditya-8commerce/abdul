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
use App\Models\TidakMasuk;

class ApprovalTidakMasukController extends Controller
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
        $no_form= $request->no_form;
        $divisi = $request->divisi;
        $posisi = $request->posisi;
		
		if(strtolower(Auth::user()->divisi->name) == 'administrator' &&  strtolower(Auth::user()->posisi->name) == 'administrator'){
			$query = TidakMasuk::with('user')->orderBy('id','DESC');
		}elseif(strtolower(Auth::user()->divisi->name) == 'director' &&  strtolower(Auth::user()->posisi->name) == 'director'){
			$query = TidakMasuk::with('user')->where('approve_status_by_leader', 'setuju')->orderBy('id','DESC');
        }else{
			$query = TidakMasuk::with('user')->whereHas('user', function ($query) {
                $query->where([['id_division', '=', Auth::user()->id_division],['id_position', '=', '4']]);
            })->orderBy('id','DESC');
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
        
		
        if($no_form)
        {
            $like = "%{$no_form}%";
            $query = $query->where('id','like',$like);
        }


        $absent 	= $query->paginate(10);
        $total 		= $query->count();
        $divions 	= Divisi::select('id','name')->get();
        $positions 	= Posisi::select('id','name')->get();
        // echo json_encode($absent);
        return view('approval_form_tidak_masuk.index', ['absents' => $absent , 'total' => $total, 'divions' => $divions , 'positions' => $positions]);

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
		$data = TidakMasuk::with('user')->find($code);
		if($data){
			return view('approval_form_tidak_masuk.detail', ['data' => $data]);
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
        $data = TidakMasuk::find($code);
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
