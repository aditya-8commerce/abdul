<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Response,View,Input,Auth,Session,Validator,File,Hash,DB,Mail;
use Illuminate\Support\Facades\Crypt;
Use Alert;

use App\Models\User;
use App\Models\Posisi;

class JabatanController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('userPrivilege:administrator,administrator');
    }
	/**
     * Display a listing of the resource.
     *
     * @return Response
     */
	public function index(Request $request)
    {			
        $search = $request->filter;
        $query = Posisi::orderBy('id','DESC');
        if ($search) {
            $like = "%{$search}%";
            $query = $query->where('name', 'LIKE', $like);
        }
        $positions 	= $query->paginate(10);
		$total 		= $query->count();
		return view('posisi.index', ['positions' => $positions , 'total' => $total ]);
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		return view('posisi.add');
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $valid = $this->validate($request, [
            'nama_jabatan' => 'required|max:255|unique:positions,name',
        ]);
		
        $divisi = new Posisi;
		$divisi->name	  = $request->nama_jabatan;
		$divisi->save();
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
        return redirect()->back()->with('info', 'data tidak ditemukan');
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
		$posisi = Posisi::find($code);
		if($posisi){
			return view('posisi.edit', ['posisi' => $posisi]);
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
        $code 	= Crypt::decrypt($id);
		$posisi = Posisi::find($code);
		$valid 	= $this->validate($request, [
				'nama_jabatan' => 'required|max:255|unique:positions,name,'.$code,
			]);
		$posisi->name       = $request->nama_jabatan;
		$posisi->save();
		
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
        $posisi = Posisi::find($id);
        $posisi->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');

    }

}
