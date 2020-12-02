<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Delivery_orderItem extends Model
{
	  protected $table='delivery_order_item';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}