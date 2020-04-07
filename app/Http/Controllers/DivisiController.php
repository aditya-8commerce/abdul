<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Response,View,Input,Auth,Session,Validator,File,Hash,DB,Mail;
use Illuminate\Support\Facades\Crypt;
Use Alert;

use App\Models\User;
use App\Models\Divisi;

class DivisiController extends Controller
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
        $query = Divisi::with('listUsers')->orderBy('id','DESC');
        if ($search) {
            $like = "%{$search}%";
            $query = $query->where('name', 'LIKE', $like);
        }
        $divisions 	= $query->paginate(10);
		$total 		= $query->count();
		// echo json_encode( $divisions);
		return view('divisi.index', ['divisions' => $divisions , 'total' => $total ]);
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		return view('divisi.add');
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $valid = $this->validate($request, [
            'nama_divisi' => 'required|max:255|unique:divisions,name',
        ]);
		
        $divisi = new Divisi;
		$divisi->name	  = $request->nama_divisi;
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
		$divisi = Divisi::find($code);
		if($divisi){
			return view('divisi.edit', ['divisi' => $divisi]);
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
		$divisi = Divisi::find($code);
		$valid 	= $this->validate($request, [
				'nama_divisi' => 'required|max:255|unique:divisions,name,'.$code,
			]);
		$divisi->name       = $request->nama_divisi;
		$divisi->save();
		
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
        $divisi = Divisi::find($id);
        $divisi->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');

    }

}
