<?php

namespace App\Models;

use App\Models\Sspl;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLifechangerPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sspl_id',
        'date_promoted',
    ];

    public function sspl()
    {
        return $this->belongsTo(Sspl::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
