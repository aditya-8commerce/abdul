<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = array('code','name','brand','model');
    public $timestamps = true; 
	  
	public function scheduleUV()
    {
        return $this->belongsTo('App\Models\ScheduleUV','id','id_product');
    }
}
