<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class POItem extends Model
{
	  protected $table='purchase_order_details';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}