<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
	  protected $table='product_attribute';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}