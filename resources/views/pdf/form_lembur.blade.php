<html>
    <body style="padding:0;font-size: 10px;">
    
    

 <table border="0" width="100%" style="padding:0;">
		
    <tr>
        <td colspan="10" align="center"><h1 align="center">FORM LEMBUR</h1></td>
    </tr>


    <tr>
        <td colspan="4" align="left"><h3 align="right">FORM NOMOR</h3></td>
        <td align="center"><h3 align="center">:</h3></td>
        <td colspan="5" align="left"><h3 align="left">{{$no_form}}</h3></td>
    </tr>


    <tr>
        <td colspan="5" align="left"><h3 align="left">TANGGAL FORM : <br>{{$data->created_at}}</h3></td>
        <td colspan="5" align="left"><h3 align="left">NAMA CUSTOMER: <br>{{$data->customer_name}}</h3></td>
    </tr>

    <tr>
        <td colspan="5" align="left"><h3 align="left">NIK : <br>{{$data->user->indentity_number}}</h3></td>
        <td colspan="5" align="left"><h3 align="left">NAMA : <br>{{$data->user->name}}</h3></td>
    </tr>

    <tr>
        <td colspan="5" align="left"><h3 align="left">BAGIAN : <br>{{$data->user->divisi->name}}</h3></td>
        <td colspan="5" align="left"><h3 align="left">JABATAN : <br>{{$data->user->posisi->name}}</h3></td>
    </tr>

    <tr>
        <td colspan="5" align="left"><h3 align="left">TANGGAL MULAI : <br>{{$data->date_start}}</h3></td>
        <td colspan="5" align="left"><h3 align="left">TANGGAL SELESAI : <br>{{$data->date_finish}}</h3></td>
    </tr>
    <tr>
        <td colspan="5" align="left"><h3 align="left">TOTAL JAM : <br>{{$data->total_hours}}</h3></td>
        <td colspan="5" align="left"><h3 align="left">KETERANGAN : <br>{{$data->description}}</h3></td>
    </tr>


    <tr>
        <td colspan="10" align="left"><h3 align="left">Mengetahui ,</h3></td>
    </tr>
 
    <tr>
        <td colspan="4" align="left"><h3 align="right">ATASAN</h3></td>
        <td align="center"><h3 align="center">:</h3></td>
        <td colspan="5" align="left"><h3 align="left">{{$data->approve_status_by_leader}} <br> {{$data->approve_by_leader}}</h3></td>
    </tr>
 
 
    <tr>
        <td colspan="4" align="left"><h3 align="right">DIREKSI</h3></td>
        <td align="center"><h3 align="center">:</h3></td>
        <td colspan="5" align="left"><h3 align="left">{{$data->approve_status_by_director}} <br> {{$data->approve_by_director}}</h3></td>
    </tr>
</table>	
       
       
   </body>
</html>