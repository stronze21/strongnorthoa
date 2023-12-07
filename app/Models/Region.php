<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'table_region', $primaryKey = 'region_id';

    public function provinces()
    {
        return $this->hasMany(Province::class, 'region_id', 'region_id');
    }
}