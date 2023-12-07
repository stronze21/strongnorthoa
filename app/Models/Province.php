<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'table_province', $primaryKey = 'province_id';

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'region_id');
    }
}