<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Sspl;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserLifechangerPromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sspl_id',
        'date_promoted',
    ];

    protected $casts = [
        'date_promoted' => 'datetime',
    ];

    // Accessor to format the date_promoted as only the date
    public function getDatePromotedAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d'); // Format to date only
    }

    public function sspl()
    {
        return $this->belongsTo(Sspl::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}