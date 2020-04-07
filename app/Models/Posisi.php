<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{

    protected $table = 'positions';
    protected $primaryKey = 'id';
    protected $fillable = array('name');
    public $timestamps = true; 
	
    public function users()
    {
        return $this->belongsTo('App\Models\User','id_position');
    }
  
}
