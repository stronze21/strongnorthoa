<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLifechangerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'occupation',
        'current_level',
        'birth_date',
        'birth_place',
        'civil_status',
        'cs_date',
        'amount_invested',
        'sign_up_date',
        'team_leader',
        'team_builder',
        'distributor',
        'spouse',
        'tin',
    ];

    public function age_signup()
    {
        $age = Carbon::parse($this->birth_date)->age;
        $created = Carbon::parse($this->sign_up_date)->age;
        return $age - $created;
    }

    public function builder()
    {
        return $this->belongsTo(User::class, 'team_builder', 'user_id');
    }

    public function distrib()
    {
        return $this->belongsTo(User::class, 'distributor', 'user_id');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'team_leader', 'user_id');
    }
}