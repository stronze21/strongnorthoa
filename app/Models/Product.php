<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $connection = 'strongnorthcrm';
    protected $table = 'tblproducts', $primaryKey = 'product_id';


    public function set()
    {
        return $this->belongsTo(Set::class, 'tblset_id', 'set_id');
    }
}
