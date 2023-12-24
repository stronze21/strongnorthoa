<?php

namespace App\Models;

use App\Models\Municipality;
use App\Models\Province;
use App\Models\Region;
use App\Models\UserLifechangerProfile;
use App\Models\UserLifechangerPromotion;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
// implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    protected $connection = 'mysql';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'pw',
        'f_name',
        'l_name',
        'm_name',
        'birth_date',
        'region_id',
        'province_id',
        'municipality',
        'current_level',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->pw;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'pw',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'region_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'province_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'municipality_id');
    }

    public function profile()
    {
        return $this->hasOne(UserLifechangerProfile::class, 'user_id', 'user_id');
    }

    public function fullname()
    {
        $fullname = $this->l_name ? $this->l_name . ', ' . $this->f_name . ' ' . $this->m_name : $this->full_name;

        return $fullname;
    }

    public function full_address()
    {
        $address = $this->address . ', ' . $this->municipality->municipality_name . ', ' . $this->province->province_name;
        return $address;
    }

    public function cur_level()
    {
        return $this->hasOne(UserLifechangerPromotion::class, 'user_id', 'user_id')->latest('date_promoted');
    }
}