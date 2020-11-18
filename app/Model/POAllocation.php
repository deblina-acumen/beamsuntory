<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class POAllocation extends Model
{
	  protected $table='purchase_order_allocation';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}