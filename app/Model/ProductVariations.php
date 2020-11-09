<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
	  protected $table='item_variation_details';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}