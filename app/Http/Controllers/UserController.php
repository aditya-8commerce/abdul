<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Response,View,Input,Auth,Session,Validator,File,Hash,DB,Mail;
use Illuminate\Support\Facades\Crypt;
Use Alert;

use App\Models\User;
use App\Models\Posisi;
use App\Models\Divisi;

class UserController extends Controller
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
        $divisi = $request->divisi;
        $posisi = $request->posisi;
        $query = User::with('divisi','posisi')->orderBy('id','DESC');
        if ($search) {
            $like = "%{$search}%";
            $query = $query->where('name', 'LIKE', $like);
        }
        if ($divisi) {
            $query = $query->where('id_division', $divisi);
        }
        if ($posisi) {
            $query = $query->where('id_position', $posisi);
        }
        $users 		= $query->paginate(10);
		$total 		= $query->count();
		$divions 	= Divisi::select('id','name')->get();
		$positions 	= Posisi::select('id','name')->get();
		// return $query->paginate(10);
		// echo $posisi;
		return view('users.index', ['users' => $users , 'total' => $total , 'divions' => $divions , 'positions' => $positions]);
    }
	
	/**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		$divions 	= Divisi::select('id','name')->get();
		$positions 	= Posisi::select('id','name')->get();
		return view('users.add', ['divions' => $divions , 'positions' => $positions]);
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $valid = $this->validate($request, [
                'nama' => 'required|max:255',
                'divisi' => 'required|numeric',
                'cuti' => 'required|numeric',
                'jabatan' => 'required|numeric',
                'password' => 'required|max:255',
                'phone' => 'required|max:20',
                'nik' => 'required|max:255|unique:users,indentity_number',
                'email' => 'required|max:255|email|unique:users,email',
                'alamat' => 'required',
        ]);
		
        $user = new User;
		
		if($request->foto){
			$valid = $this->validate($request, [
				'foto'           => 'image|mimes:jpg,jpeg,png'
			]);
			   
			$file = $request->file('foto');
			$extension  = $request->file('foto')->getClientOriginalExtension();
			
			if ($file->getSize() <= 2000000){
				$destinationPath = public_path().'/public/foto/'; // upload path
				$fileName   = str_replace(' ', '-', $request->nik).'-'.time().'.'.$extension; // renameing image
				if(file_exists($destinationPath.$fileName)){
					File::delete($destinationPath .$fileName);
				}
				 $upload_success     = $file->move($destinationPath, $fileName);
				if(!$upload_success){
					return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
				}else{
					$user->photo	  = $fileName;
				}
			}else{
				return redirect()->back()->with('info', 'gambar foto lebih dari 2 MB');
			}
		}
	   
		$user->indentity_number       = $request->nik;
		$user->paid_leave = $request->cuti;
		$user->name       = $request->nama;
		$user->email      = $request->email;
		$user->id_division= $request->divisi;
		$user->id_position= $request->jabatan;
		$user->phone	  = $request->phone;
		$user->address	  = $request->alamat;
		$user->password	  = Hash::make($request->password);
		$user->save();
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
		$user = User::with('divisi','posisi')->find($code);
		if($user){
			return view('users.detail', ['user' => $user]);
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
		$user = User::find($code);
		if($user){
			$divions 	= Divisi::select('id','name')->get();
			$positions 	= Posisi::select('id','name')->get();
			return view('users.edit', ['user' => $user, 'divions' => $divions , 'positions' => $positions]);
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
		$user = User::find($code);
       if($request->password){
			$valid = $this->validate($request, [
					'nik' => 'required|max:255|unique:users,indentity_number,'.$code,
					'nama' => 'required|max:255',
					'cuti' => 'required|numeric',
					'divisi' => 'required|numeric',
					'jabatan' => 'required|numeric',
					'phone' => 'required|max:20',
					'password' => 'required|max:255',
					'email' => 'required|max:255|email|unique:users,email,'.$code,
					'alamat' => 'required',
			]);
		$user->password	  = Hash::make($request->password);
	   }else{ 
			$valid = $this->validate($request, [
					'nik' => 'required|max:255|unique:users,indentity_number,'.$code,
					'nama' => 'required|max:255',
					'cuti' => 'required|numeric',
					'divisi' => 'required|numeric',
					'jabatan' => 'required|numeric',
					'phone' => 'required|max:20',
					'email' => 'required|max:255|email|unique:users,email,'.$code,
					'alamat' => 'required',
			]);
	   }
	   
	   if($request->foto){
        $valid = $this->validate($request, [
            'foto'           => 'image|mimes:jpg,jpeg,png'
        ]);
		   
        $file = $request->file('foto');
        $extension  = $request->file('foto')->getClientOriginalExtension();
		
		if ($file->getSize() <= 2000000){
			$destinationPath = public_path().'/public/foto/'; // upload path
			$fileName   = str_replace(' ', '-', $request->nik).'-'.time().'.'.$extension; // renameing image
            if(file_exists($destinationPath.$fileName)){
                File::delete($destinationPath .$fileName);
            }
			 $upload_success     = $file->move($destinationPath, $fileName);
			if(!$upload_success){
                return redirect()->back()->with('info', 'upload gambar gagal , silahkan ulangi');
            }else{
				$user->photo	  = $fileName;
			}
		}else{
			return redirect()->back()->with('info', 'gambar foto lebih dari 2 MB');
		}
	   }
	   
		$user->indentity_number       = $request->nik;
		$user->name       = $request->nama;
		$user->paid_leave      = $request->cuti;
		$user->email      = $request->email;
		$user->id_division= $request->divisi;
		$user->id_position= $request->jabatan;
		$user->phone	  = $request->phone;
		$user->address	  = $request->alamat;
		$user->save();
		
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
        $user = User::find($id);
		$destinationPath = public_path().'/public/foto/'; // upload path
		File::delete($destinationPath .$user->photo);
        $user->delete();
        return redirect()->back()->with('success', 'data berhasil dihapus');

    }
	
    public function changePassword(Request $request)
    {
        $valid = $this->validate($request, [
                'password' => 'required|max:255',
                'password_confirmation' => 'required|max:255|same:password'
        ]);
        User::where("id",Auth::user()->id)->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success', 'perubahan password masuk berhasil');
    }
	
	public function downloadFoto($fileName){
		$destinationPath = public_path().'/public/foto/'.$fileName; // upload path
        return Response::download($destinationPath, $fileName);
    }
}
