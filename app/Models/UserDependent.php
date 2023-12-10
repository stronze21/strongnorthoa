<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDependent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'school',
    ];

    public function age()
    {
        $age = Carbon::parse($this->birth_date)->age;
        $created = Carbon::parse($this->created_at)->age;
        return $age - $created;
    }
}
