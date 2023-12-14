<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'shows',
        'sales',
        'sets',
        'strict'
    ];

    public function cs()
    {
        return $this->hasMany(CookingShow::class);
    }
}
