<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function serial()
    {
        $date = Carbon::parse($this->created_at)->format('mdy');
        return 'CNTST-' . $date . '-' . sprintf('%04d', $this->id);
    }
}
