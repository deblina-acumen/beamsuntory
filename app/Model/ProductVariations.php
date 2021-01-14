<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariations extends Model
{
	  protected $table='item_variation_details';
      protected $fillable = ['item_id','sku','variation','is_active','is_deleted','created_at','created_by','updated_at','updated_by'];
	  public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
	
   
}