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

class PermintaanBarangDetailsController extends Controller
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


    public function deleteById($id)
    {
        $code = Crypt::decrypt($id);
		$data = PermintaanBarangDetails::find($code);
		if($data){
            $data->delete();
			return redirect()->back()->with('success', 'data berhasil dihapus');
		}else{
			return redirect()->back()->with('info', 'data tidak ditemukan');
		}
    }
	 
}
