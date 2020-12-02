<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Delivery_order extends Model
{
	  protected $table='delivery_order';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}