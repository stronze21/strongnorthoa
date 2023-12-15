<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestLifechanger extends Model
{
    use HasFactory;

    protected $fillable = [
        'contest_id',
        'user_id',
    ];

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function lifechanger()
    {
        return $this->belongsTo(User::class);
    }
}
