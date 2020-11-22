<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PoBox extends Model
{
	  protected $table='purchase_order_box_details';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}