<?php

namespace App\Models;

use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipality extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'table_municipality', $primaryKey = 'municipality_id';

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }
}