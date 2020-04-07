<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = array('code','name','address','email','phone');
    public $timestamps = true; 
	 

    public function schedule()
    {
        return $this->belongsTo('App\Models\Schedule','id','id_customer');
    }

    public function vSchedule()
    {
        return $this->belongsTo('App\Models\VSchedule','id','id_customer');
    }
}
