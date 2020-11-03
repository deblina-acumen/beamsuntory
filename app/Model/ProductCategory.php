<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
	  protected $table='product_category';
      protected $fillable = [];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}