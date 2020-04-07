<?php

namespace App\Models;
use App\Models\Produk;
 
class Chart
{
 
    public function produk()
    {
        $res = Produk::orderBy('id','DESC')->get();
        return $res;
    }
}
