<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table='warehouse';
	protected $fillable = ['name','user_id','country_id','province_id','city','zip','address','rows_no','columns','shelves','racks','pallets','low_threshold','is_active','is_deleted','created_at','created_by','updated_at','updated_by'];
}
