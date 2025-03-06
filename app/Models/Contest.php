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
        'strict',
        'restriction',
        'sspl_id',
        'for_team_builders',
    ];

    // Cast dates to Carbon instances
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Ensure created_at is never null when accessed
    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : Carbon::now();
    }

    // Ensure updated_at is never null when accessed
    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : Carbon::now();
    }

    // Ensure start_date is never null when accessed
    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Ensure end_date is never null when accessed
    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    public function cs()
    {
        return $this->hasMany(CookingShow::class);
    }

    public function serial()
    {
        $createdAt = $this->created_at ?: Carbon::now();
        $date = Carbon::parse($createdAt)->format('mdy');
        return 'CNTST-' . $date . '-' . sprintf('%04d', $this->id);
    }

    public function sspl()
    {
        return $this->belongsTo(Sspl::class);
    }

    // Calculate status based on dates
    public function getStatusAttribute()
    {
        $now = Carbon::now();

        if (!$this->start_date || !$this->end_date) {
            return 'Unknown';
        }

        if ($this->end_date->isPast()) {
            return 'Ended';
        } elseif ($this->start_date->isFuture()) {
            return 'Upcoming';
        } else {
            return 'Active';
        }
    }
}