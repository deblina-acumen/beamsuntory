<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    protected $table='store_category';
    public function getDateFormat()
    {
         return 'Y-m-d H:i:s';
    }
}
