<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
    protected $table = 'demand_for_goods';
    protected $primaryKey = 'id';
    protected $fillable = array('id_user','file','name_project','approve_by_leader','approve_status_by_leader','approve_by_director','approve_status_by_director');
    public $timestamps = true; 
	 
    public function users()
    {
        return $this->belongsTo('App\Models\User','id_user');
    }
	
	
    public function user()
    {
        return $this->hasOne('App\Models\User','id','id_user');
    }

    public function details()
    {
        return $this->hasMany('App\Models\PermintaanBarangDetails','demand_for_good_id','id');
    }
}
