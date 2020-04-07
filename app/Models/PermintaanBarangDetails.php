<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarangDetails extends Model
{
    protected $table = 'demand_for_good_details';
    protected $primaryKey = 'id';
    protected $fillable = array('demand_for_good_id','name','qty','price','description');
    public $timestamps = true; 
	 
    public function header()
    {
        return $this->belongsTo('App\Models\PermintaanBarang','demand_for_good_id');
    }
	
	
}
